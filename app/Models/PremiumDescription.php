<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumDescription extends Model
{
    use HasFactory;

    public function premiumMembership() {
        $this->belongsTo(PremiumMembership::class);
    }
}
