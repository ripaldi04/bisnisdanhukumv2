<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    public function todoChecklistItems() {
        return $this->hasMany(TodoChecklistItem::class);
    }
}
