<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;

class GuruImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Guru([
            'nama' => $row[0],
            'nip' => $row[1],
            'email' => $row[2],
            'alamat' => $row[3],
            'no_telp' => $row[4],
        ]);
    }
}