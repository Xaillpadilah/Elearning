<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    public function mapel()
{
    return $this->belongsTo(Mapel::class);
}

public function kelas()
{
    return $this->belongsTo(Kelas::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function balasan()
{
    return $this->hasMany(BalasanDiskusi::class);
}
}
