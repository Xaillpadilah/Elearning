<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
   use HasFactory;

    protected $fillable = [
    'nama',
    'user_id',
    'nomor_hp',
    'siswa_id',
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
public function siswa()
{
    return $this->belongsTo(Siswa::class, 'siswa_id'); // <- pastikan ini juga
}
public function pengumumen()
{
    return $this->hasMany(Pengumuman::class, 'dibuat_oleh');
}
}