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
}
