<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
   protected $fillable = [
        'siswa_id', 'ujian_id',
        'jumlah_soal', 'jumlah_benar', 'jumlah_salah', 'skor', 'detail_salah',
    ];

    protected $casts = [
        'detail_salah' => 'array',
    ];

   
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // 🔁 Relasi ke ujian
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}


