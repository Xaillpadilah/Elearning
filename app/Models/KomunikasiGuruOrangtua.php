<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomunikasiGuruOrangtua extends Model
{
    use HasFactory;

    protected $table = 'komunikasi_guru_orangtua';

    protected $fillable = [
        'guru_id',
        'orangtua_id',
        'pesan',
        'pengirim',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class);
    }

}
