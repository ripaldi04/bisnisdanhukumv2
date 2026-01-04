<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Mail\PaymentSuccessNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPaymentSuccessEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccessful $event): void
    {
        $user = $event->transaction->user;
        $amount = number_format($event->transaction->total_amount, 0, ',', '.');

        // Mengirim email menggunakan notifikasi dengan format jumlah yang diformat
        Mail::to($user->email)->send(new PaymentSuccessNotification($amount));
    }
}
