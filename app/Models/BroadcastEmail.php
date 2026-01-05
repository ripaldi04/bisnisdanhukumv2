<?php

namespace App\Models;

use App\Events\BroadcastEmailCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'file_path',
    ];

    protected $dispatchesEvents = [
        'created' => \App\Events\BroadcastEmailCreated::class,
    ];

    public function emailRecipients()
    {
        return $this->belongsToMany(EmailRecipient::class, 'broadcast_email_recipient');
    }
}
