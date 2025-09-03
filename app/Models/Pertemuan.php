<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_id',
        'semester1',
        'semester2',
    ];


    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
