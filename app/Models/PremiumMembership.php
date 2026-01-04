<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumMembership extends Model
{
    use HasFactory;

    public function premiumDescriptions() {
        return $this->hasMany(PremiumDescription::class);
    }
}
