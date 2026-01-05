<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ebook_id',
        'amount',
        'trx_id',
        'status',
        'payment_type',
        'midtrans_transaction_id',
        'paid_at',
        'name',
        'email',
        'whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
