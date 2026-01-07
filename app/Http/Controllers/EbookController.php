<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookTransaction;
use App\Models\EbookDownload;
use App\Models\EmailRecipient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EbookController extends Controller
{
    // LIST SEMUA EBOOK
    public function index()
    {
        $ebooks = Ebook::where('status', 'published')->paginate(12);
        return view('ebooks.index', compact('ebooks'));
    }

    // DETAIL EBOOK BERDASARKAN ID
    public function show($id)
    {
        $ebook = Ebook::findOrFail($id);
        $ebook->increment('views');

        $hasPaid = false;

        if (auth()->check()) {
            $hasPaid = EbookTransaction::where('user_id', auth()->id())
                ->where('ebook_id', $ebook->id)
                ->where('status', 'Paid')
                ->exists();
        }

        // Ambil ebook lainnya (selain ebook yang sedang ditampilkan)
        $otherEbooks = Ebook::where('status', 'published')
            ->where('id', '!=', $ebook->id)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('ebooks.landing', compact('ebook', 'hasPaid', 'otherEbooks'));
    }

    /**
     * Handle download form submission for free ebooks
     */
    public function downloadForm(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        // Hanya untuk ebook gratis
        if (!$ebook->is_free) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->with('error', 'Ebook ini berbayar, silakan beli terlebih dahulu.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Cek apakah email sudah pernah download ebook ini
        if (EbookDownload::hasDownloaded($ebook->id, $data['email'])) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->with('error', 'Email Anda sudah pernah mendownload ebook ini sebelumnya.');
        }

        // Simpan data download
        EbookDownload::create([
            'ebook_id' => $ebook->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'downloaded_at' => now(),
        ]);

        // Tambahkan email ke daftar penerima broadcast otomatis
        EmailRecipient::firstOrCreate(['email' => $data['email']]);

        // Redirect ke WhatsApp dengan template message
        $waNumber = Setting::where('key', 'whatsapp_number')->value('value');
        $template = Setting::where('key', 'whatsapp_message_template')->value('value');

        if ($waNumber && $template) {
            $message = strtr($template, [
                '{title}' => $ebook->title,
                '{name}' => $data['name'],
                '{email}' => $data['email'],
                '{whatsapp}' => $data['whatsapp'],
                '{url}' => route('ebooks.show', $ebook->id),
            ]);

            $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
            return redirect()->away($waLink);
        }

        // Fallback jika WhatsApp belum dikonfigurasi
        return redirect()->route('ebooks.show', $ebook->id)
            ->with('error', 'WhatsApp belum dikonfigurasi oleh admin.');
    }

    /**
     * Handle purchase form submission for paid ebooks (without login)
     */
    public function purchaseForm(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        // Hanya untuk ebook berbayar
        if ($ebook->is_free) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->with('error', 'Ebook ini gratis, silakan download langsung.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Basic email validation (don't sanitize as it might break valid emails)
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->withErrors(['email' => 'Format email tidak valid.'])
                ->withInput();
        }

        // Cek apakah email sudah pernah membeli ebook ini
        if (
            EbookTransaction::where('ebook_id', $ebook->id)
                ->where('email', $data['email'])
                ->where('status', 'Paid')
                ->exists()
        ) {
            return redirect()->route('ebooks.show', $ebook->id)
                ->with('error', 'Email Anda sudah pernah membeli ebook ini sebelumnya.');
        }

        // Buat transaksi baru
        $trx = EbookTransaction::create([
            'user_id' => null, // Tidak ada user karena tidak login
            'ebook_id' => $ebook->id,
            'amount' => $ebook->price,
            'trx_id' => 'EBK-' . time() . rand(1000, 9999),
            'status' => 'Pending',
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
        ]);

        // Tambahkan email ke daftar penerima broadcast otomatis
        EmailRecipient::firstOrCreate(['email' => $data['email']]);

        // MIDTRANS CONFIG
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // PARAMETER PAYMENT
        $params = [
            'transaction_details' => [
                'order_id' => $trx->trx_id,
                'gross_amount' => $trx->amount,
            ],
            'customer_details' => [
                'first_name' => $data['name'],
                'last_name' => '',
                'email' => $data['email'],
                'phone' => $data['whatsapp'],
            ],
            'item_details' => [
                [
                    'id' => $ebook->id,
                    'price' => $ebook->price,
                    'quantity' => 1,
                    'name' => $ebook->title,
                ]
            ]
        ];

        // SNAP TOKEN
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'trx_id' => $trx->trx_id
            ]);
        } catch (\Exception $e) {
            // Hapus transaksi yang gagal
            $trx->delete();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.'
            ], 500);
        }
    }

    // DOWNLOAD EBOOK (SETELAH BAYAR)
    public function download($id)
    {
        $ebook = Ebook::findOrFail($id);

        // Jika gratis → langsung download
        if ($ebook->is_free) {
            return response()->download(storage_path("app/public/{$ebook->file_path}"));
        }

        // Cek apakah user sudah membeli ebook ini (dengan login)
        if (auth()->check()) {
            $user = Auth::user();
            $payment = EbookTransaction::where('user_id', $user->id)
                ->where('ebook_id', $ebook->id)
                ->where('status', 'Paid')
                ->first();

            if ($payment) {
                // Tambah counter download
                $ebook->increment('downloads');
                return response()->download(storage_path("app/public/{$ebook->file_path}"));
            }
        }

        // Cek apakah email sudah membeli ebook ini (tanpa login)
        $email = session('purchased_email');
        if ($email) {
            $payment = EbookTransaction::where('email', $email)
                ->where('ebook_id', $ebook->id)
                ->where('status', 'Paid')
                ->first();

            if ($payment) {
                // Tambah counter download
                $ebook->increment('downloads');
                return response()->download(storage_path("app/public/{$ebook->file_path}"));
            }
        }

        return redirect()->route('ebooks.show', $ebook->id)
            ->with('error', 'Anda belum membeli ebook ini.');
    }

    // MEMBUAT INVOICE / TRANSAKSI EBOOK
    public function buy($id)
    {
        $ebook = Ebook::findOrFail($id);
        $user = Auth::user();

        // Jika gratis, langsung download
        if ($ebook->is_free) {
            return redirect()->route('ebooks.download', $ebook->id);
        }

        // 1. CEK APAKAH SUDAH PERNAH BAYAR
        $paid = EbookTransaction::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->where('status', 'Paid')
            ->first();

        if ($paid) {
            return redirect()->route('ebooks.download', $ebook->id);
        }

        // 2. CEK TRANSAKSI PENDING YANG BELUM DIBAYAR
        $pending = EbookTransaction::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->where('status', 'Pending')
            ->first();

        if ($pending) {
            $trx = $pending;
        } else {
            // 3. BUAT TRANSAKSI BARU
            $trx = EbookTransaction::create([
                'user_id' => $user->id,
                'ebook_id' => $ebook->id,
                'amount' => $ebook->price,
                'trx_id' => 'EBK-' . time() . rand(1000, 9999),
                'status' => 'Pending',
            ]);
        }

        // MIDTRANS CONFIG
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // PARAMETER PAYMENT
        $params = [
            'transaction_details' => [
                'order_id' => $trx->trx_id,
                'gross_amount' => $trx->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $ebook->id,
                    'price' => $ebook->price,
                    'quantity' => 1,
                    'name' => $ebook->title,
                ]
            ]
        ];

        // SNAP TOKEN
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('ebooks.checkout', [
            'trx' => $trx,
            'ebook' => $ebook,
            'snapToken' => $snapToken,
        ]);
    }

    // Callback Midtrans untuk transaksi tanpa login
    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $trx = EbookTransaction::where('trx_id', $notif->order_id)->first();

        if (!$trx)
            return;

        // Simpan data yang penting
        $trx->payment_type = $notif->payment_type;
        $trx->midtrans_transaction_id = $notif->transaction_id;

        if ($notif->transaction_status == 'settlement') {
            $trx->status = 'Paid';
            $trx->paid_at = now();

            // Simpan email ke session untuk download tanpa login
            session(['purchased_email' => $trx->email]);
        } elseif ($notif->transaction_status == 'expire') {
            $trx->status = 'Expired';
        } elseif ($notif->transaction_status == 'cancel') {
            $trx->status = 'Failed';
        }

        $trx->save();
    }

}
