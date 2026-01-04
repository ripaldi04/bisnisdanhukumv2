<?php

namespace App\Mail;

use App\Models\SubscribeTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(SubscribeTransaction $invoice)
    {
        $this->invoice = $invoice;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pembayaran Membership',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $formatHarga = number_format($this->invoice->total_amount, 0, ',', '.');
        $expires = $this->invoice->expires_at->format('d M Y H:i');

        return new Content(
            view: 'emails.invoice',
            with: [
                'name' => $this->invoice->user->name,
                'price' => $formatHarga,
                'expires' => $expires,
                'trxID' => $this->invoice->trx_id
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
