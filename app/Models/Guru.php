<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
  use HasFactory;

    protected $fillable = ['user_id', 'nama', 'nik'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel_kelas')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel_kelas')
            ->withPivot('mapel_id')
            ->withTimestamps();
    }
}