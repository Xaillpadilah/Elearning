<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{protected $table = 'pengumuman'; // Tambahkan ini agar tidak salah nama tabel

    protected $fillable = [
        'judul',
        'isi',
        'tujuan',
        'tanggal',
    ];
}
