<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Mail\InvoiceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail
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
    public function handle(InvoiceCreated $event): void
    {
        $invoice = $event->invoice;
        $user = $invoice->user;

        Mail::to($user->email)->send(new InvoiceNotification($invoice));
    }
}
