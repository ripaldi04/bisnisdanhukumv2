<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookTransaction;
use App\Models\EbookDownload;
use App\Models\EmailRecipient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\BroadcastEmailMailable;

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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Anda sudah pernah mendownload ebook ini sebelumnya.'
                ]);
            }
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

        // Update jumlah download
        $ebook->increment('downloads');

        // Kirim ebook gratis via email
        $title = $ebook->title;
        $content = '
    <p>Halo <strong>' . e($data['name']) . '</strong>,</p>

    <p>Terima kasih telah berkunjung ke website <strong>Bisnis dan Hukum</strong> dan mengunduh ebook gratis kami.</p>

    <p>Kami sangat mengapresiasi ketertarikan Anda pada materi:</p>

    <div style="background:#f9fafb; padding:16px; border-radius:8px; margin:16px 0; border-left:4px solid #D4AF37;">
        <strong>' . e($ebook->title) . '</strong>
    </div>

    <p>Sebagai bentuk apresiasi, kami lampirkan file ebook lengkap dalam email ini. Ebook ini dirancang untuk memberikan pemahaman yang praktis, relevan, dan mudah diterapkan dalam dunia bisnis dan hukum.</p>

    <p>Silakan unduh dan pelajari materi di dalamnya. Semoga ebook ini dapat menambah wawasan, membuka sudut pandang baru, serta membantu Anda mengambil keputusan yang lebih tepat.</p>

    <p>Apabila Anda memiliki pertanyaan atau ingin berdiskusi lebih lanjut, jangan ragu untuk menghubungi kami melalui email atau WhatsApp. Kami dengan senang hati siap membantu.</p>

    <p>Terima kasih atas kepercayaan Anda. Semoga bermanfaat dan membawa keberkahan.</p>

    <p>Salam hangat,<br>
    <strong>Tim Bisnis dan Hukum</strong></p>
';
        Mail::to($data['email'])->queue(new BroadcastEmailMailable($title, $content, $ebook->file_path));

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

            // Jika AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'whatsapp_url' => $waLink,
                    'new_downloads' => $ebook->downloads
                ]);
            }

            return redirect()->away($waLink);
        }

        // Fallback jika WhatsApp belum dikonfigurasi
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp belum dikonfigurasi oleh admin.'
            ]);
        }

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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format email tidak valid.'
                ]);
            }
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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Anda sudah pernah membeli ebook ini sebelumnya.'
                ]);
            }
            return redirect()->route('ebooks.show', $ebook->id)
                ->with('error', 'Email Anda sudah pernah membeli ebook ini sebelumnya.');
        }

        // Cek apakah ada transaksi pending dengan email ini untuk ebook ini
        $pending = EbookTransaction::where('ebook_id', $ebook->id)
            ->where('email', $data['email'])
            ->where('status', 'Pending')
            ->first();

        if ($pending) {
            // Update data transaksi dengan data terbaru jika berbeda
            $pending->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'whatsapp' => $data['whatsapp'],
            ]);
            $trx = $pending;
        } else {
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
        try {
            Log::info('MIDTRANS CALLBACK RAW', $request->all());

            // MIDTRANS CONFIG
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $notif = new \Midtrans\Notification();

            Log::info('MIDTRANS NOTIF', [
                'order_id' => $notif->order_id,
                'transaction_status' => $notif->transaction_status,
                'payment_type' => $notif->payment_type,
            ]);

            $trx = EbookTransaction::where('trx_id', $notif->order_id)->first();

            if (!$trx) {
                Log::warning('MIDTRANS: trx not found', [
                    'order_id' => $notif->order_id
                ]);

                return response()->json(['status' => 'trx not found'], 200);
            }

            $trx->payment_type = $notif->payment_type;
            $trx->midtrans_transaction_id = $notif->transaction_id;

            if ($notif->transaction_status === 'settlement' || $notif->transaction_status === 'capture') {
                $trx->status = 'Paid';
                $trx->paid_at = now();

                // Kirim ebook berbayar via email setelah pembayaran berhasil
                $ebook = $trx->ebook;
                if ($ebook) {
                    $title = $ebook->title;
                    $content = '
                        <p>Halo ' . $trx->name . ',</p>
                        <p>Terima kasih telah menyelesaikan pembayaran untuk ebook: <strong>' . $ebook->title . '</strong>.</p>
                        <p>Pembayaran Anda telah dikonfirmasi dan ebook lengkap telah dilampirkan dalam email ini.</p>
                        <p>Silakan download file terlampir dan mulai menikmati materi yang bermanfaat. Ebook ini berisi pengetahuan mendalam yang dapat membantu Anda dalam bidang bisnis dan hukum.</p>
                        <p>Jika Anda mengalami kesulitan download atau memiliki pertanyaan, hubungi kami melalui WhatsApp atau email.</p>
                        <p>Semoga ebook ini memberikan nilai tambah bagi perjalanan Anda. Sukses selalu!</p>
                        <p>Salam hangat,<br>Tim Bisnis dan Hukum</p>
                    ';
                    Mail::to($trx->email)->queue(new BroadcastEmailMailable($title, $content, $ebook->file_path));
                }
            } elseif ($notif->transaction_status === 'expire') {
                $trx->status = 'Expired';
            } elseif ($notif->transaction_status === 'cancel') {
                $trx->status = 'Failed';
            }

            $trx->save();

            return response()->json(['status' => 'ok'], 200);

        } catch (\Throwable $e) {
            Log::error('MIDTRANS CALLBACK ERROR', [
                'message' => $e->getMessage()
            ]);

            // TETAP BALIK 200 supaya Midtrans tidak retry terus
            return response()->json(['status' => 'error'], 200);
        }
    }

}
