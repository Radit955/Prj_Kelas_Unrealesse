<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{
    protected $fillable = ['title', 'subject', 'description', 'due_date', 'created_by', 'from_absent_teacher'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
