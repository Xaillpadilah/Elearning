<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{    protected $fillable = [
        'judul', 'deskripsi', 'jenis', 'tanggal_deadline', 'file_path', 'guru_mapel_kelas_id'
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

    public function jawaban_tugas()
    {
        return $this->hasMany(JawabanTugas::class);
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
        return $this->hasMany(Soal::class);
    }
}