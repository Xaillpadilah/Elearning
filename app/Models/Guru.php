<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
  use HasFactory;

    protected $fillable = ['user_id', 'nama', 'nik','jenis_kelamin',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel_kelas')
            ->withPivot('mapel_id')
            ->withTimestamps();
    }
  public function mapelKelas()
{
    return $this->hasMany(GuruMapelKelas::class);
}
public function kelasWali()
{
    return $this->hasOne(Kelas::class, 'wali_kelas');
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
    public function pengumumen()
{
    return $this->hasMany(Pengumuman::class, 'dibuat_oleh');
}
public function mapels()
{
    return $this->belongsToMany(Mapel::class, 'guru_mapel_kelas', 'guru_id', 'mapel_id')
        ->withPivot('kelas_id');
}
}