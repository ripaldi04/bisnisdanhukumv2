<?php

namespace App\Http\Controllers;

use App\Events\InvoiceCreated;
use App\Models\Article;
use App\Models\Benefit;
use App\Models\Book;
use App\Models\Category;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Module;
use App\Models\PaymentMethod;
use App\Models\PremiumMembership;
use App\Models\ReferralCommission;
use App\Models\SubModule;
use App\Models\SubscribeTransaction;
use App\Models\Testimonial;
use App\Models\TodoList;
use App\Models\Uniqueness;
use App\Models\UserProgress;
use App\Models\UserTodoProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FrontController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)->get();
        $faqs = Faq::where('is_active', true)->get();
        $course = Course::first();
        $benefits = Benefit::where('is_active', true)->get();
        $uniquenesses = Uniqueness::where('is_active', true)->get();
        $articles = Article::where('status', 'Published')->orderBy('viewed', 'desc')->take(3)->get();
        return view('home', compact('testimonials', 'faqs', 'course', 'benefits', 'uniquenesses', 'articles'));
    }

    public function pricing()
    {
        $course = Course::first();
        $testimonials = Testimonial::where('is_active', true)->get();
        $faqs = Faq::where('is_active', true)->get();
        $premium = PremiumMembership::first();
        return view('harga', compact('course', 'faqs', 'testimonials', 'premium'));
    }

    public function createInvoice()
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return redirect()->back()->with('info', 'Anda sudah memiliki membership aktif.');
        }

        $existingInvoice = SubscribeTransaction::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->where('expires_at', '>', now())
            ->first();

        // Jika ada invoice yang Pending dan belum expired, arahkan ke invoice tersebut
        if ($existingInvoice) {
            return redirect()->route('checkout', ['trxID' => $existingInvoice->trx_id]);
        }

        $basePrice = PremiumMembership::pluck('price')->first();
        do {
            // Generate harga dengan tiga digit acak terakhir
            $randomSuffix = mt_rand(100, 999);
            $finalPrice = $basePrice + $randomSuffix;

            // Cek apakah harga ini unik pada invoice 'Pending' atau 'Expires' lainnya
            $exists = SubscribeTransaction::where('total_amount', $finalPrice)
                ->where('status', 'Pending')
                ->exists();
        } while ($exists); // Ulangi sampai menemukan angka unik

        $invoice = SubscribeTransaction::create([
            'user_id' => $user->id,
            'expires_at' => now()->addDay(3),
            'total_amount' => $finalPrice,
            'trx_id' => SubscribeTransaction::generateUniqueTrxId()
        ]);
        $formatHarga = number_format($invoice->total_amount, 0, ',', '.');
        $expires = $invoice->expires_at->format('d M Y H:i');

        $response = Http::withHeaders([
            'Authorization' => 'JMH7E2kvnrJ9nv3JrdCu',
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->no_hp,
            'message' => "Dear Bapak/Ibu $user->name\n\nSemangat Sukses\n\nUntuk menikmati sajian ilmu luar biasa dari Bisnis dan Hukum, Anda dapat membayar membership dengan melakukan transfer sejumlah Rp $formatHarga sebelum $expires\n\nFaktur Pembayaran:\nhttps://bisnisdanhukum.com/checkout/$invoice->trx_id\n\nUntuk informasi tiket,\nSilahkan login akun pada halaman berikut:\nhttps://bisnisdanhukum.com/login"
        ]);

        event(new InvoiceCreated($invoice));

        // Redirect ke halaman checkout
        return redirect()->route('checkout', ['trxID' => $invoice->trx_id]);
    }

    public function showCheckout($trxID)
    {
        $user = Auth::user();
        $invoice = SubscribeTransaction::where('trx_id', $trxID)->where('user_id', $user->id)->first();

        if (!$invoice) {
            return redirect()->route('pricing')->with('error', 'Anda tidak memiliki akses ke invoice ini.');
        }

        if ($invoice->isExpired()) {
            return redirect()->route('pricing')->with('error', 'Invoice sudah kedaluwarsa. Silakan coba lagi.');
        }

        if ($invoice->status == 'Rejected') {
            return redirect()->route('pricing')->with('error', 'Pembayaran ditolak. Silakan coba lagi.');
        }

        if ($invoice->status == 'Success') {
            return redirect()->route('pricing')->with('error', 'Invoice sudah tidak valid. Silakan coba lagi.');
        }
        if ($invoice->proof) {
            return redirect()->route('dashboard')->with('info', 'Pembayaran anda telah kami terima, mohon menunggu untuk diverifikasi terlebih dahulu.');
        };

        $course = Course::first();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('checkout', compact('invoice', 'course', 'paymentMethods'));
    }

    public function checkout_store(Request $request)
    {
        $user = Auth::user();

        if (Auth::user()->hasActiveSubscription()) {
            return redirect()->route('index');
        }

        DB::transaction(function () use ($request, $user) {
            $invoice = SubscribeTransaction::where('trx_id', $request->trxID)->firstOrFail();
            $validated = $request->validate([
                'proof' => 'mimes:jpeg,jpg,png,pdf|required'
            ]);

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $invoice->update($validated);
        });

        return redirect()->route('dashboard')->with('success', 'Pembayaran anda telah kami terima, mohon menunggu untuk diverifikasi terlebih dahulu.');
    }


    // public function books()
    // {
    //     $books = Book::with('bookImages')->paginate(12);
    //     $course = Course::first();
    //     return view('books.index', compact('books', 'course'));
    // }
    // public function detailBook(string $id)
    // {
    //     $course = Course::first();
    //     $book = Book::with('bookImages')->findOrFail($id);
    //     return view('books.show', compact('book', 'course'));
    // }

    public function articles(Request $request)
    {
        // Pencarian berdasarkan judul
        $search = $request->input('search');
        $course = Course::first();
        $latestArticles = Article::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->latest()->paginate(10);

        // Artikel dengan viewed terbanyak (5 artikel teratas)
        $mostViewedArticles = Article::orderBy('viewed', 'desc')->take(5)->get();

        return view('articles.index', compact('latestArticles', 'mostViewedArticles', 'course'));
    }

    public function detailArticle($slug)
    {
        $course = Course::first();
        $article = Article::where('slug', $slug)->firstOrFail();
        $article->increment('viewed');
        return view('articles.show', compact('course', 'article'));
    }

    public function articlesByCategory($slug, Request $request)
    {
        $search = $request->input('search');

        // Ambil kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();


        $course = Course::first();
        $latestArticles = Article::where('category_id', $category->id)
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })->latest()->paginate(10);

        $mostViewedArticles = Article::orderBy('viewed', 'desc')->take(5)->get();

        return view('articles.index', compact('latestArticles', 'mostViewedArticles', 'course'));
    }

    public function learn()
    {
        $course = Course::first();
        $totalModules = Module::count();
        $modules = Module::with(['subModules' => function ($query) {
            $query->where('published_date', '<=', now());
        }])->orderBy('order', 'asc')->get();
        $totalSubModules = $modules->sum(function ($module) {
            return $module->subModules->count();
        });
        $faqs = Faq::where('is_active', true)->get();
        return view('learn', compact('course', 'modules',  'totalSubModules', 'totalModules', 'faqs'));
    }
    public function learning($moduleId, $subModuleId)
    {
        $course = Course::first();
        $totalModules = Module::count();
        $modules = Module::with(['subModules' => function ($query) {
            $query->where('published_date', '<=', now());
        }])->orderBy('order', 'asc')->get();
        $totalSubModules = $modules->sum(function ($module) {
            return $module->subModules->count();
        });
        $user = Auth::user();


        $subModule = SubModule::findOrFail($subModuleId);
        if (!$subModule->is_free && !$user->hasActiveSubscription()) {
            return redirect()->route('pricing');
        }

        $userProgress = UserProgress::where('user_id', $user->id)
            ->where('sub_module_id', $subModuleId)
            ->first();

        return view('learning', compact('course', 'subModule', 'modules',  'totalSubModules', 'totalModules', 'userProgress'));
    }

    public function completeSubModule($subModuleId)
    {
        $user = Auth::user();
        $userProgress = UserProgress::where('user_id', $user->id)
            ->where('sub_module_id', $subModuleId)
            ->first();

        if ($userProgress) {
            // Update progress menjadi selesai
            $userProgress->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }
        return redirect()->back();
    }

    // Get to-do list items
    public function getTodoList()
    {
        $userId = Auth::id();
        // Ambil todo_lists beserta todo_checklist_items dan progress user
        $todoLists = TodoList::with(['todoChecklistItems.progress' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        return response()->json($todoLists);
    }

    // Update progress
    public function updateProgress(Request $request)
    {
        $userId = Auth::id();
        $itemId = $request->input('item_id');
        $isChecked = $request->input('is_checked');

        $progress = UserTodoProgress::where('user_id', $userId)
            ->where('todo_checklist_item_id', $itemId)
            ->first();

        if ($progress) {
            $progress->is_checked = $isChecked;
            $progress->save();
        }

        return response()->json(['success' => true]);
    }


    public function dashboard()
    {
        $user = Auth::user();
        $referralPercentage = $user->referral_commission_percentage;
        $transactions = $user->subscribe_transactions()->latest()->get();

        // Get membership status
        $membershipExpiryDate = null;
        if ($user->hasActiveSubscription()) {
            $latestSubscription = $user->subscribe_transactions()
                ->where('status', 'Success')
                ->latest('updated_at')
                ->first();
            $membershipExpiryDate = Carbon::parse($latestSubscription->subscription_start_date)->addYear(1);
        }
        $referredUsers = $user->referredUsers;
        $commissions = $user->referralCommissions()->with('referredUser')->latest()->get();

        return view('dashboard', [
            'transactions' => $transactions,
            'membershipStatus' => $user->hasActiveSubscription(),
            'membershipExpiry' => $membershipExpiryDate,
            'user' => $user,
            'referredUsers' => $referredUsers,
            'commissions' => $commissions, // Assuming this method exists in your User model
            'referralPercentage' => $referralPercentage
        ]);
    }

    public function withdraw(Request $request)
    {
        // Validasi data yang dikirimkan
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nama_rekening' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Cek apakah user memiliki komisi yang belum dicairkan
        $totalCommission = ReferralCommission::where('referrer_id', $user->id)
            ->where('status', 'Not Submitted')
            ->sum('amount');

        if ($totalCommission <= 0) {
            return back()->withErrors(['message' => 'Tidak ada komisi yang dapat dicairkan.']);
        }

        // Update informasi rekening pada semua komisi dengan status 'Pending'
        ReferralCommission::where('referrer_id', $user->id)
            ->where('status', 'Not Submitted')
            ->update([
                'nama_bank' => $request->nama_bank,
                'nama_rekening' => $request->nama_rekening,
                'nomor_rekening' => $request->nomor_rekening,
                'status' => 'Pending',
            ]);

        return back()->with('success', 'Pengajuan pencairan komisi berhasil diajukan.');
    }
}
