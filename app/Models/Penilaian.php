<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
    'siswa_id',
    'guru_id',
    'mapel_id',
    'kelas_id',
    'nilai_tugas',
    'nilai_kuis',
    'nilai_uts',
    'nilai_uas',
    'catatan',
];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
    
}
