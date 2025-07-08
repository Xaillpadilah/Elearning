<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
     public function model(array $row)
    {
        return new Siswa([
            'nama' => $row[0],
            'nisn' => $row[1],
            'kelas' => $row[2],
            'email' => $row[3],
        ]);
    }
}
