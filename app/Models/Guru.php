<?php

namespace App\Models;
use App\Exports\GuruExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
     protected $fillable = ['nama', 'nik', 'mengajar', 'email'];
}
