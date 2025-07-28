<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{

      protected $table = 'pengumumen'; // Nama tabel sesuai migrasi

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_pengumuman',
        'ditujukan_kepada',
        'dibuat_oleh',
    ];

    /**
     * Relasi ke User (pembuat pengumuman / admin).
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
    public function dibuat_oleh_user()
{
    return $this->belongsTo(\App\Models\User::class, 'dibuat_oleh');
}
public function siswa()
{
    return $this->belongsTo(Siswa::class, 'siswa_id'); // <- pastikan ini juga
}
 public function orangtua()
{
    return $this->hasOne(Orangtua::class);
}
  public function guru()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }
    
}