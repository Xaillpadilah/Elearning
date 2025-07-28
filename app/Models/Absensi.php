<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
     protected $fillable = [
        'siswa_id', 'guru_id', 'mapel_id', 'kelas_id',
        'tanggal', 'status', 'keterangan'
    ];

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel() {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }
    
public function guru()
{
    return $this->belongsTo(\App\Models\Guru::class);
}
}
