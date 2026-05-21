<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeksiKegiatan extends Model
{
    protected $table = 'seksi_kegiatan';

    protected $fillable = ['name', 'category', 'description', 'ketua_id'];

    public function ketua()
    {
        return $this->belongsTo(Student::class, 'ketua_id');
    }

    public function members()
    {
        return $this->belongsToMany(Student::class, 'seksi_kegiatan_members', 'seksi_id', 'student_id')->withTimestamps();
    }
}
