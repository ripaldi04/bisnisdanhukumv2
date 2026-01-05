<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookLandingDescription extends Model
{
    use HasFactory;

    protected $fillable = ['ebook_id', 'description'];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
