<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class BroadcastEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $content;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($title, $content, $filePath = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->filePath = $filePath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.broadcast',
            with: [
                'title' => $this->title,
                'content' => $this->content,
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
        $attachments = [];

        if ($this->filePath && file_exists(storage_path('app/public/' . $this->filePath))) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/' . $this->filePath));
        }

        return $attachments;
    }
}
