<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
   protected $table = 'materis';

    protected $fillable = [
        'judul', 'mapel', 'kelas', 'file', 'uploaded_at',
    ];
    public function uploader()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}
public function mapel()
{
    return $this->belongsTo(Mapel::class, 'mapel_id');
}
public function kelas()
{
    return $this->belongsTo(Kelas::class, 'kelas_id');
}
public function guru()
{
    return $this->belongsTo(Guru::class, 'guru_id');
}

}

