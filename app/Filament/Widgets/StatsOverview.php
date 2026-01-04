<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\SubscribeTransaction;
use App\Models\SubModule;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Jumlah user yang telah mendaftar
        $totalUsers = User::count();

        // 2. Jumlah user dengan membership aktif
        $activeMemberships = User::whereHas('subscribe_transactions', function ($query) {
            $query->where('status', 'Success')
                ->whereDate('subscription_start_date', '>=', now()->subYear());
        })->count();

        // 3. Jumlah total transaksi
        $totalTransactions = SubscribeTransaction::count();

        // 4. Jumlah sub-module (materi)
        $totalSubModules = SubModule::count();

        // 5. Jumlah keuntungan (hanya status "Success" dan harga tetap)
        $profit = SubscribeTransaction::where('status', 'Success')
            ->sum('total_amount');

        return [
            Stat::make('Total Users', $totalUsers),
            Stat::make('Active Memberships', $activeMemberships),
            Stat::make('Total Transactions', $totalTransactions),
            Stat::make('Total Sub Modules', $totalSubModules),
            Stat::make('Total Profit', number_format($profit, 0, ',', '.')),
        ];
    }
}
