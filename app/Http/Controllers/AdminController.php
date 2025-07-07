<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruExport;
use App\Imports\GuruImport;
class AdminController extends Controller
{
     // Dashboard Admin
     public function dashboard()
    {
        return view('admin.dashboard');
    }

   public function guru(Request $request)
    {
        // Ekspor jika tombol ekspor ditekan
        if ($request->has('export')) {
            $gurus = Guru::all();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Nama');
            $sheet->setCellValue('B1', 'NIK');
            $sheet->setCellValue('C1', 'Mengajar');
            $sheet->setCellValue('D1', 'Email');

            $row = 2;
            foreach ($gurus as $guru) {
                $sheet->setCellValue('A' . $row, $guru->nama);
                $sheet->setCellValue('B' . $row, $guru->nik);
                $sheet->setCellValue('C' . $row, $guru->mengajar);
                $sheet->setCellValue('D' . $row, $guru->email);
                $row++;
            }

            $fileName = 'data_guru_' . date('Ymd_His') . '.xlsx';
            $filePath = storage_path($fileName);
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        // Impor jika file dikirim
        if ($request->isMethod('post') && $request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);

            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            for ($i = 2; $i <= count($sheetData); $i++) {
                $row = $sheetData[$i];
                Guru::create([
                    'nama'     => $row['A'],
                    'nik'      => $row['B'],
                    'mengajar' => $row['C'],
                    'email'    => $row['D'],
                ]);
            }

            return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diimpor.');
        }

        // Default: tampilkan halaman guru
        $search = $request->input('search');

        $gurus = Guru::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%")
                         ->orWhere('mengajar', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->orderBy('nama')->get();

        return view('admin.guru.index', compact('gurus', 'search'));
    }

        public function create()
    {
        return view('admin.guru.create');
    }
    public function export()
    {
        return Excel::download(new GuruExport, 'data_guru.xlsx');
    }
        public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'nik' => 'required|string|max:100|unique:gurus',
        'mengajar' => 'required|string|max:255',
        'email' => 'required|email|unique:gurus',
    ]);

    Guru::create($request->all());

    return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan.');
    }
   

 // Menangani upload & import file Excel
     public function showImportForm()
        {
                return view('admin.guru.import');
        }
public function edit($id)
{
    $guru = Guru::findOrFail($id);
    return view('admin.guru.edit', compact('guru'));
}

public function update(Request $request, $id)
{
    $guru = Guru::findOrFail($id);
    $guru->update([
        'nama' => $request->nama,
        'nik' => $request->nik,
        'mengajar' => $request->mengajar,
        'email' => $request->email,
    ]);

    return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui.');
}
    // Menangani upload & import file Excel
    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Proses import menggunakan GuruImport
            Excel::import(new GuruImport, $request->file('file'));

            return back()->with('success', 'Data guru berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function siswa()
    {
        $user = auth()->user();
        $daftarSiswa = [
            ['nama' => 'Budi', 'kelas' => '7A'],
            ['nama' => 'Ani', 'kelas' => '8B'],
        ];
        return view('admin.siswa.index', compact('user', 'daftarSiswa'));
    }

    public function kelas()
    {
        $user = auth()->user();
        $daftarKelas = ['7A', '7B', '8A', '8B', '9A'];
        return view('admin.kelas.index', compact('user', 'daftarKelas'));
    }

    public function mapel()
    {
        $user = auth()->user();
        $daftarMapel = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris'];
        return view('admin.mapel.index', compact('user', 'daftarMapel'));
    }

    public function pengumuman()
    {
        $user = auth()->user();
        $pengumuman = [
            ['judul' => 'Ujian Tengah Semester', 'tanggal' => '2025-09-15'],
            ['judul' => 'Libur Akhir Tahun', 'tanggal' => '2025-12-20'],
        ];
        return view('admin.pengumuman.index', compact('user', 'pengumuman'));
    }
}