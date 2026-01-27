<?php

namespace App\Services;

use Midtrans\Config;

class MidtransConfig
{
    const ENABLED_PAYMENTS = [
        'bank_transfer',
        'bsi_va',
        'gopay',
        'qris'
    ];

    public static function configure()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
