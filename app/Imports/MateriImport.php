<?php

namespace App\Imports;

use App\Models\Materi;
use Maatwebsite\Excel\Concerns\ToModel;

class MateriImport implements ToModel
{
   public function model(array $row)
    {
        return new Materi([
            'judul'        => $row['judul'],
            'mapel'        => $row['mapel'],
            'kelas'        => $row['kelas'],
            'uploaded_by'  => auth()->id(),
            'uploaded_at'  => now(),
        ]);
    }
}