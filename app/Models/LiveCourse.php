<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveCourse extends Model
{
    use HasFactory;
    public function transactions()
    {
        return $this->hasMany(LiveCourseTransaction::class);
    }
}
