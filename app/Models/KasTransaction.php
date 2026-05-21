<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasTransaction extends Model
{
    protected $fillable = ['student_id', 'amount', 'method', 'week', 'status', 'paid_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
