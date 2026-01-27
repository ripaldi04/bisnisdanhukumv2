<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            // Ensure updated_at is not earlier than created_at
            if ($article->updated_at && $article->created_at && $article->updated_at->lt($article->created_at)) {
                $article->updated_at = $article->created_at;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
