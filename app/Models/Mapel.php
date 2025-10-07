<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{  use HasFactory;
     protected $table = 'mapels'; // ✅ ini penting!
    protected $fillable = ['nama_mapel', 'kode_mapel'];

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel_kelas')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }
    public function guru()
{
    return $this->belongsTo(Guru::class);
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
    public function kelas()
{
    return $this->belongsTo(Kelas::class);
}
}