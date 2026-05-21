<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'nis', 'class', 'seat_position'];

    protected $casts = ['seat_position' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function kasTransactions()
    {
        return $this->hasMany(KasTransaction::class);
    }

    public function piketAssignments()
    {
        return $this->hasMany(PiketAssignment::class);
    }

    public function classSection()
    {
        return $this->hasOne(ClassSection::class);
    }

    public function seatLayout()
    {
        return $this->hasOne(SeatLayout::class);
    }
}
