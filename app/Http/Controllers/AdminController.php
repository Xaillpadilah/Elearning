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
use App\Models\Materi;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengumuman;

class AdminController extends Controller
{
     // Dashboard Admin
     public function dashboard()
    {
         $user = auth()->user();

    $jumlahGuru = Guru::count();
    $jumlahSiswa = Siswa::count();
    $jumlahKelas = Kelas::count();
    $jumlahMapel = Materi::distinct('mapel')->count('mapel');
    $jumlahPengumuman = Pengumuman::count();

    $dataChart = [
        'labels' => ['Guru', 'Siswa', 'Kelas', 'Mapel', 'Pengumuman'],
        'jumlah' => [$jumlahGuru, $jumlahSiswa, $jumlahKelas, $jumlahMapel, $jumlahPengumuman],
    ];

    return view('admin.dashboard', compact(
        'user',
        'jumlahGuru',
        'jumlahSiswa',
        'jumlahKelas',
        'jumlahMapel',
        'jumlahPengumuman',
        'dataChart'
    ));
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
        public function storeguru(Request $request)
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
//mapel
      public function indexmateri(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $materi = Materi::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%$search%")
                         ->orWhere('mapel', 'like', "%$search%")
                         ->orWhere('kelas', 'like', "%$search%");
        })->latest()->get();

        return view('admin.mapel.index', compact('materi', 'user', 'search'));
    }

    public function storemateri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'file'  => 'required|file|mimes:pdf,docx,ppt,pptx|max:2048',
        ]);

        $path = $request->file('file')->store('mapel', 'public');

        Materi::create([
            'judul' => $request->judul,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'file'  => $path,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function updatemateri(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'file'  => 'nullable|file|mimes:pdf,docx,ppt,pptx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($materi->file && Storage::disk('public')->exists($materi->file)) {
                Storage::disk('public')->delete($materi->file);
            }

            $materi->file = $request->file('file')->store('materi', 'public');
        }

        $materi->update([
            'judul' => $request->judul,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'file'  => $materi->file,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function importmateri(Request $request)
    {
        // Validasi dan baca file excel
        // Gunakan Laravel Excel (maatwebsite/excel) jika sudah terpasang
        return back()->with('info', 'Fitur impor materi belum diimplementasikan.');
    }

    public function exportmateri()
    {
        // Gunakan Laravel Excel juga di sini jika sudah di-setup
        return back()->with('info', 'Fitur ekspor materi belum diimplementasikan.');
    }

//pengumuman
  public function indexpengumuman(Request $request)
    {
        $search = $request->input('search');

        $pengumuman = Pengumuman::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%$search%")
                         ->orWhere('isi', 'like', "%$search%");
        })->latest()->get();

        return view('admin.pengumuman.index', compact('pengumuman', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tujuan' => 'required|in:guru,siswa,orangtua',
            'tanggal' => 'required|date',
        ]);

        Pengumuman::create($request->all());

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function editpengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function updatepengumuman(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tujuan' => 'required|in:guru,siswa,orangtua',
            'tanggal' => 'required|date',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update($request->all());

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil diperbarui.');
    }
}