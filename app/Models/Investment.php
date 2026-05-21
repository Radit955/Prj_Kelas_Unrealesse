<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['name', 'type', 'principal', 'rate_percent', 'start_date', 'maturity_date', 'current_value'];

    protected $casts = [
        'start_date' => 'date',
        'maturity_date' => 'date',
    ];
}
