<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;

class KelasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kelas::select('nama_kelas', 'wali_kelas', 'jumlah_siswa')->get();
    }

    public function headings(): array
    {
        return [
            'nama_kelas',
            'wali_kelas',
            'jumlah_siswa',
        ];
    }
}

