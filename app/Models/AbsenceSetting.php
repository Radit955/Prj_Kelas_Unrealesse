<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceSetting extends Model
{
    protected $fillable = ['max_izin_days', 'sakit_unlimited'];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'max_izin_days'   => 3,
            'sakit_unlimited' => true,
        ]);
    }
}
