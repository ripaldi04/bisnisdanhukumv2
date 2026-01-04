<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LakM\Comments\Concerns\Commentable;
use LakM\Comments\Contracts\CommentableContract;

class SubModule extends Model implements CommentableContract
{
    use HasFactory;
    use Commentable;

    protected static function booted()
    {
        static::created(function ($item) {
            // Dapatkan semua pengguna yang ada
            $users = User::all();

            // Untuk setiap user, buat entry baru di user_todo_progress untuk item checklist baru
            foreach ($users as $user) {
                UserProgress::create([
                    'user_id' => $user->id,
                    'sub_module_id' => $item->id,
                    'is_completed' => false,
                ]);
            }
        });
    }

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function userProgresses()
    {
        return $this->hasMany(UserProgress::class);
    }

    
}
