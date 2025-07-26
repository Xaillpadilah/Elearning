<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
   
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'guru_id',
        'hari',
        'jam',
        'tipe_ruangan',
        'ruangan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function siswa()
{
    return $this->hasManyThrough(
        Siswa::class,   // Model tujuan akhir
        Kelas::class,   // Model perantara
        'id',           // Foreign key di tabel kelas (relasi ke jadwal.kelas_id)
        'kelas_id',     // Foreign key di tabel siswa (relasi ke kelas.id)
        'kelas_id',     // Local key di tabel jadwal
        'id'            // Local key di tabel kelas
    );
}
}