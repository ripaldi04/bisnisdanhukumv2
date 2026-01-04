<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineEvent extends Model
{
    use HasFactory;

    public function transactions()
    {
        return $this->hasMany(OfflineEventTransaction::class);
    }
}
