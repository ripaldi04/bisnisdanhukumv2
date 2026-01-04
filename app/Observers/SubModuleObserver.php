<?php

namespace App\Observers;

use App\Mail\NewSubModuleMail;
use App\Models\SubModule;
use Illuminate\Support\Facades\Mail;

class SubModuleObserver
{
    /**
     * Handle the SubModule "created" event.
     */
    public function created(SubModule $subModule): void
    {
        // Get all users with an active membership
        $activeMembers = \App\Models\User::whereHas('subscribe_transactions', function ($query) {
            $query->where('status', 'Success')
                ->whereDate('subscription_start_date', '>=', now()->subYear());
        })->get();

        // Send email to each user
        foreach ($activeMembers as $user) {
            Mail::to($user->email)->queue(new NewSubModuleMail($subModule));
        }
    }

    /**
     * Handle the SubModule "updated" event.
     */
    public function updated(SubModule $subModule): void
    {
        //
    }

    /**
     * Handle the SubModule "deleted" event.
     */
    public function deleted(SubModule $subModule): void
    {
        //
    }

    /**
     * Handle the SubModule "restored" event.
     */
    public function restored(SubModule $subModule): void
    {
        //
    }

    /**
     * Handle the SubModule "force deleted" event.
     */
    public function forceDeleted(SubModule $subModule): void
    {
        //
    }
}
