<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
     protected $table = 'ujians';
    protected $fillable = [
        'judul',
        'tanggal',
        'keterangan',
        'tipe_ujian',
        'file_soal',
        'guru_mapel_kelas_id',
        'acak_soal',
    ];
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
    public function soalUjians()
{
    return $this->hasMany(SoalUjian::class);
}
public function guruMapelKelas()
{
    return $this->belongsTo(GuruMapelKelas::class);
}
public function relasi()
    {
        return $this->belongsTo(GuruMapelKelas::class, 'guru_mapel_kelas_id');
    }
    public function soals()
    {
        return $this->hasMany(SoalUjian::class, 'ujian_id');
    }
    public function hasilUjians()
{
    return $this->hasMany(HasilUjian::class, 'ujian_id');
}
// Ujian.php

public function jawabanPilihanGandaBySiswa($siswaId)
{
    return $this->hasMany(JawabanUjian::class)->where('user_id', $siswaId);
}
public function jawabanSiswa()
{
    return $this->hasMany(\App\Models\JawabanUjian::class)->where('user_id', auth()->id());
}
}

