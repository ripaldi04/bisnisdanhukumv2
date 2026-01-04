<?php

namespace App\Console\Commands;

use App\Models\SubscribeTransaction;
use Illuminate\Console\Command;

class ExpirePendingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-pending-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTransactions = SubscribeTransaction::where('status', 'Pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'Expired']);

        $this->info('$expiredTransactions transactions have been updated.');
    }
}
