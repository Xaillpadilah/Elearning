<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{ protected $fillable = [
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
}

