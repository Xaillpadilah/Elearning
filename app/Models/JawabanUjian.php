<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    protected $table = 'jawaban_ujian'; // nama tabel di database

    protected $fillable = [
        'ujian_id',
        'user_id',
        'jawaban',
        'file_path',
        'skor',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Ujian
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}