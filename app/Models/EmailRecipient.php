<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRecipient extends Model
{
    use HasFactory;

    protected $fillable = ['email'];

    public function broadcastEmails()
    {
        return $this->belongsToMany(BroadcastEmail::class, 'broadcast_email_recipient');
    }
}
