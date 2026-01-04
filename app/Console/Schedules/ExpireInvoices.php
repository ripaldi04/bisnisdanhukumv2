<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class ExpireInvoices
{
    public function __invoke(Schedule $schedule)
    {
        $schedule->command('app:expire-pending-transactions')->everyMinute();
    }
}