<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BroadcastEmailCreated;
use App\Mail\BroadcastEmailMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\BroadcastEmail;
use App\Models\EmailRecipient;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;

class SendBroadcastEmail implements ShouldQueueAfterCommit
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
    public function handle(BroadcastEmailCreated $event): void
    {
        // Ambil data BroadcastEmail berdasarkan event
        $broadcastEmailId = BroadcastEmail::find($event->broadcastEmail->id);
        $id = $broadcastEmailId->id;
        $broadcastEmail = BroadcastEmail::with('emailRecipients')->find($id);
        $recipients = $broadcastEmail->emailRecipients->pluck('email');

        foreach ($recipients as $email) {
            Mail::to($email)->queue(
                new BroadcastEmailMailable($broadcastEmail->title, $broadcastEmail->content)
            );
        }
    }
}
