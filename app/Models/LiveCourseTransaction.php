<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveCourseTransaction extends Model
{
    use HasFactory;
    public function liveCourse()
    {
        return $this->belongsTo(LiveCourse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
