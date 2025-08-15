<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjian extends Model
{
     protected $table = 'soal_ujians';

     protected $fillable = [
        'ujian_id', 'nomor', 'pertanyaan',
        'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d',
        'jawaban_benar',
    ];
  
       public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
    

