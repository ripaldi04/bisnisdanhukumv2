<?php

namespace App\Http\Controllers;

use App\Models\OfflineEvent;
use App\Models\OfflineEventTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfflineEventController extends Controller
{
    // List semua event
    public function index()
    {
        $events = OfflineEvent::where('status', 'published')
            ->orderBy('start_time', 'asc')
            ->paginate(12);

        return view('events.index', compact('events'));
    }

    // Detail event
    public function show($id)
    {
        $event = OfflineEvent::findOrFail($id);
        $hasTicket = false;
        $trxId = null;

        if (auth()->check()) {
            $trx = OfflineEventTransaction::where('user_id', auth()->id())
                ->where('offline_event_id', $event->id)
                ->where('status', 'Paid')
                ->first();

            if ($trx) {
                $hasTicket = true;
                $trxId = $trx->id; // nanti dipakai untuk route tiket
            }
        }

        return view('events.show', compact('event','hasTicket','trxId'));
    }

    // Beli tiket event
    public function buy($id)
    {
        $event = OfflineEvent::findOrFail($id);
        $user = Auth::user();

        // Event gratis → langsung dapat tiket
        if ($event->is_free) {
            return $this->generateTicket($user, $event);
        }

        // Jika sudah bayar, langsung ke tiket
        $existing = OfflineEventTransaction::where('user_id', $user->id)
            ->where('offline_event_id', $event->id)
            ->where('status', 'Paid')
            ->first();

        if ($existing) {
            return redirect()->route('events.ticket', $existing->id);
        }

        // Buat transaksi baru
        $trx = OfflineEventTransaction::create([
            'user_id' => $user->id,
            'offline_event_id' => $event->id,
            'amount' => $event->price,
            'trx_id' => 'EVT-' . time() . rand(1000, 9999),
            'ticket_code' => strtoupper(uniqid('TICKET')),
            'status' => 'Pending',
            'payment_deadline' => now()->addHours(2),
        ]);

        // MIDTRANS CONFIG
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // PARAMETER PAYMENT
        $params = [
            'transaction_details' => [
                'order_id' => $trx->trx_id,
                'gross_amount' => (int) $trx->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $event->id,
                    'price' => (int) $event->price,
                    'quantity' => 1,
                    'name' => $event->title,
                ]
            ]
        ];

        // SNAP TOKEN
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('events.checkout', [
            'trx' => $trx,
            'event' => $event,
            'snapToken' => $snapToken,
        ]);
    }

    // Tiket setelah bayar
    public function ticket($transactionId)
    {
        $trx = OfflineEventTransaction::findOrFail($transactionId);

        if ($trx->status !== 'Paid') {
            return redirect()->back()->with('error', 'Transaksi belum dibayar.');
        }

        $event = $trx->event; // <-- tambahkan ini
        $checkedIn = !is_null($trx->checked_in_at); // <--- CEK apakah sudah scan


        return view('events.ticket', compact('event', 'trx', 'checkedIn'));
    }

    public function checkIn($code)
    {
        $trx = OfflineEventTransaction::where('ticket_code', $code)->first();

        if (!$trx) {
            return "Tiket tidak ditemukan.";
        }

        if ($trx->checked_in_at) {
            return "Tiket sudah digunakan.";
        }

        $trx->checked_in_at = now();
        $trx->save();

        return "Check-in berhasil untuk " . $trx->user->name;
    }


}
