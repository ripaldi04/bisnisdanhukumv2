<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LakM\Comments\Models\Comment as BaseComment;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends BaseComment
{
    use HasFactory;

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function commenter(): MorphTo
    {
        return $this->morphTo();
    }

    public function reply()
    {
        return $this->belongsTo(self::class, 'reply_id');
    }
}
