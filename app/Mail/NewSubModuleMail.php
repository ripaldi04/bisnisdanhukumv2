<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSubModuleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subModule;

    /**
     * Create a new message instance.
     */
    public function __construct($subModule)
    {
        $this->subModule = $subModule;
    }

    public function build()
    {
        return $this->subject('New Sub-Module Available: ' . $this->subModule->title)
                    ->view('emails.new_sub_module')
                    ->with([
                        'title' => $this->subModule->title,
                        'description' => $this->subModule->description,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Sub-Module Available: ' . $this->subModule->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_sub_module', // Define the view for your email template
            with: [
                'title' => $this->subModule->title,
                'description' => $this->subModule->description,
            ],
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
