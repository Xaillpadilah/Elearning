<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
        use HasFactory;
  protected $table = 'siswas';
    protected $fillable = ['nama', 'nisn', 'kelas_id', 'jenis_kelamin', 'nomor_hp', 'user_id', 'orangtua_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function orangtua()
{
    return $this->hasOne(Orangtua::class);
}


    public function jawaban_tugas()
    {
        return $this->hasMany(JawabanTugas::class);
    }
    public function rekapPembelajaran()
{
    return $this->hasMany(RekapPembelajaranBulanan::class);
}
public function rekapSemester()
{
    return $this->hasMany(RekapPembelajaranSemester::class);
}
  public function guru()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }
    public function pengumumen()
{
    return $this->hasMany(Pengumuman::class, 'dibuat_oleh');
}
public function penilaians()
{
    return $this->hasMany(Penilaian::class, 'siswa_id');
}

}
