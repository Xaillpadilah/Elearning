<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
  use HasFactory;

    protected $table = 'soals';

    protected $fillable = [
        'tugas_id',
        'pertanyaan',
        'pilihan',
        'jawaban_benar',
    ];

    protected $casts = [
        'pilihan' => 'array',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}