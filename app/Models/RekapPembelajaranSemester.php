<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPembelajaranSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'semester',
        'tahun_ajaran',
        'jumlah_hadir',
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_alfa',
        'total_tugas',
        'tugas_selesai',
        'rata_rata_nilai',
        'catatan_guru',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

}
