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
use App\Models\Siswa;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Imports\KelasImport;
use App\Exports\KelasExport;

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
    //siswa
    public function indexsiswa(Request $request)
{
     $search = $request->search;

    $siswas = Siswa::with('kelas')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function ($kelasQuery) use ($search) {
                      $kelasQuery->where('nama_kelas', 'like', "%{$search}%");
                  });
            });
        })
        ->get();

    return view('admin.siswa.index', compact('siswas', 'search'));
}

public function storesiswa(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'nisn' => 'required|unique:siswas',
        'kelas' => 'required',
        'email' => 'required|email|unique:siswas',
    ]);

    Siswa::create($request->all());

    return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan.');
}

public function updatesiswa(Request $request, $id)
{
    $siswa = Siswa::findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'nisn' => 'required|unique:siswas,nisn,' . $id,
        'kelas' => 'required',
        'email' => 'required|email|unique:siswas,email,' . $id,
    ]);

    $siswa->update($request->all());

    return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui.');
}

public function exportsiswa()
{
    return Excel::download(new SiswaExport, 'data-siswa.xlsx');
}
public function importsiswa(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new SiswaImport, $request->file('file'));

    return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diimpor.');
}
public function destroy($id)
{
    $siswa = Siswa::findOrFail($id);
    $siswa->delete();

    return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil dihapus.');
}
//kelas
   public function indexkelas(Request $request)
    {
        $search = $request->search;
        $kelas = Kelas::when($search, function ($query, $search) {
            $query->where('nama_kelas', 'like', "%$search%")
                  ->orWhere('wali_kelas', 'like', "%$search%");
        })->get();

        return view('admin.kelas.index', compact('kelas', 'search'));
    }

    public function storekelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
            'jumlah_siswa' => 'required|integer|min:0',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function updatekelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
            'jumlah_siswa' => 'required|integer|min:0',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function importkelas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new KelasImport, $request->file('file'));

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil diimpor.');
    }

    public function exportkelas()
    {
        return Excel::download(new KelasExport, 'data_kelas.xlsx');
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