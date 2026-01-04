<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoChecklistItem extends Model
{
    use HasFactory;

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }

    public function progress()
    {
        // Setiap TodoChecklistItem memiliki satu progress untuk user tertentu
        return $this->hasMany(UserTodoProgress::class, 'todo_checklist_item_id');
    }

    protected static function booted()
    {
        static::created(function ($item) {
            // Dapatkan semua pengguna yang ada
            $users = User::all();

            // Untuk setiap user, buat entry baru di user_todo_progress untuk item checklist baru
            foreach ($users as $user) {
                UserTodoProgress::create([
                    'user_id' => $user->id,
                    'todo_checklist_item_id' => $item->id,
                    'is_checked' => false,
                ]);
            }
        });
    }
}
