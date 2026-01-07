<?php

namespace App\Observers;

use App\Models\EmailRecipient;
use App\Models\Ebook;
use App\Mail\BroadcastEmailMailable;
use Illuminate\Support\Facades\Mail;

class EmailRecipientObserver
{
    /**
     * Handle the EmailRecipient "created" event.
     */
    public function created(EmailRecipient $emailRecipient): void
    {
        // Find the welcome ebook - first free published ebook
        $ebook = Ebook::where('is_free', true)
            ->where('status', 'published')
            ->first();

        if ($ebook) {
            // Prepare welcome content
            $title = 'Selamat Datang di Bisnis dan Hukum';
            $content = '
                <p>Halo!</p>
                <p>Terima kasih telah bergabung dengan komunitas Bisnis dan Hukum. Kami sangat senang Anda ada di sini!</p>
                <p>Sebagai hadiah selamat datang, kami kirimkan ebook gratis untuk Anda:</p>
                <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #FFD700;">
                    <h3>' . $ebook->title . '</h3>
                    <p>' . $ebook->description . '</p>
                </div>
                <p>Ebook telah dilampirkan dalam email ini. Silakan download dan nikmati bacaan yang bermanfaat.</p>
                <p>Jangan ragu untuk menjelajahi lebih banyak konten menarik di website kami.</p>
                <p>Semoga ebook ini memberikan manfaat dan inspirasi bagi Anda!</p>
            ';

            // Send welcome email with ebook attachment using broadcast mailable
            Mail::to($emailRecipient->email)->queue(
                new BroadcastEmailMailable($title, $content, $ebook->file_path)
            );
        }
    }

    /**
     * Handle the EmailRecipient "updated" event.
     */
    public function updated(EmailRecipient $emailRecipient): void
    {
        //
    }

    /**
     * Handle the EmailRecipient "deleted" event.
     */
    public function deleted(EmailRecipient $emailRecipient): void
    {
        //
    }

    /**
     * Handle the EmailRecipient "restored" event.
     */
    public function restored(EmailRecipient $emailRecipient): void
    {
        //
    }

    /**
     * Handle the EmailRecipient "force deleted" event.
     */
    public function forceDeleted(EmailRecipient $emailRecipient): void
    {
        //
    }
}