<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'ebook_id',
        'user_id',
        'name',
        'email',
        'whatsapp',
        'ip_address',
        'user_agent',
        'is_verified',
        'downloaded_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'downloaded_at' => 'datetime',
    ];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cek apakah user/email sudah pernah download ebook ini
     */
    public static function hasDownloaded($ebookId, $email)
    {
        return self::where('ebook_id', $ebookId)
            ->where('email', $email)
            ->exists();
    }
}