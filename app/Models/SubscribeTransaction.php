<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeTransaction extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function generateUniqueTrxId()
    {
        $prefix = 'CC';
        do {
            $randomString = $prefix . mt_rand(1000, 999999);
        } while (self::where('trx_id', $randomString)->exists());
        return $randomString;
    }

    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }
}
