<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatLayout extends Model
{
    protected $fillable = ['row', 'col', 'student_id', 'label'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
