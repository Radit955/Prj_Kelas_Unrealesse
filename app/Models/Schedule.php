<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['day', 'lesson_code', 'lesson_name', 'teacher_code', 'start_time', 'end_time', 'class_name'];
}
