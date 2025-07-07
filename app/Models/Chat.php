<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
      protected $fillable = [
        'from',     // <- tambahkan ini
        'message',  // dan kolom lainnya jika ada
    ];
}

