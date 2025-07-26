<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
   use HasFactory;

   protected $fillable = ['nama_kelas', 'wali_kelas'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    public function wali()
{
    return $this->belongsTo(Guru::class, 'wali_kelas');
}
 public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
    public function jadwals()
{
    return $this->hasMany(Jadwal::class);
}
 
    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }
}



