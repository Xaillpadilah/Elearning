<?php

namespace App\Exports;

use App\Models\Materi;
use Maatwebsite\Excel\Concerns\FromCollection;

class MateriExport implements FromCollection
{
    public function collection()
    {
        return Materi::select('judul', 'mapel', 'kelas', 'uploaded_at')->get();
    }

    /**
     * Tambahkan header kolom untuk Excel.
     */
    public function headings(): array
    {
        return [
            'Judul Materi',
            'Mata Pelajaran',
            'Kelas',
            'Tanggal Upload',
        ];
    }
}