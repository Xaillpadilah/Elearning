<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalTugas extends Model
{
   protected $fillable = ['tugas_id', 'pertanyaan', 'pilihan', 'jawaban_benar'];

public function tugas()
{
    return $this->belongsTo(\App\Models\Tugas::class);
}
    public function soals()
{
    return $this->hasMany(SoalTugas::class);
}
}
