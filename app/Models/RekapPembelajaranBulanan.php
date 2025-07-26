<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPembelajaranBulanan extends Model
{
     use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status_kehadiran',
        'jumlah_tugas',
        'jumlah_tugas_selesai',
        'rata_rata_nilai',
        'catatan_guru',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

}
