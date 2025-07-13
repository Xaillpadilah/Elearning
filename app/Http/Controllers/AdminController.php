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
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
    // $jumlahPengumuman = Pengumuman::count();

    $dataChart = [
        'labels' => ['Guru', 'Siswa', 'Kelas', 'Mapel', 'Pengumuman'],
        'jumlah' => [$jumlahGuru, $jumlahSiswa, $jumlahKelas, $jumlahMapel, ],
    ];

    return view('admin.dashboard', compact(
        'user',
        'jumlahGuru',
        'jumlahSiswa',
        'jumlahKelas',
        'jumlahMapel',
    
        'dataChart'
    ));
}
//guru
  public function guruIndex(Request $request)
{
    $search = $request->input('search');

    $gurus = Guru::with(['user', 'mapels']) // << penting
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%");
        })
        ->get();

    return view('admin.guru.index', compact('gurus', 'search'));
}
public function guruStore(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'nik' => 'required|unique:gurus,nik',
        'email' => 'required|email|unique:users,email',
        'mengajar' => 'nullable',
    ]);

    // Buat akun user guru
    $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt('password'), // Default password
        'role' => 'guru',
    ]);

    // Buat data guru
    Guru::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'nik' => $request->nik,
        'mengajar' => $request->mengajar ?? '-',
    ]);

    return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan.');
}

public function guruUpdate(Request $request, $id)
{
    $guru = Guru::findOrFail($id);
    $user = $guru->user;

    $request->validate([
        'nama' => 'required',
        'nik' => 'required|unique:gurus,nik,' . $guru->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'mengajar' => 'nullable',
    ]);

    $guru->update([
        'nama' => $request->nama,
        'nik' => $request->nik,
        'mengajar' => $request->mengajar ?? '-',
    ]);

    $user->update([
        'name' => $request->nama,
        'email' => $request->email,
    ]);

    return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui.');
}

public function guruExport()
{
    return Excel::download(new GuruExport, 'data_guru.xlsx');
}

public function guruImport(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new GuruImport, $request->file('file'));

    return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diimpor.');
}
    //siswa
    public function indexSiswa(Request $request)
{
    $search = $request->input('search');

    $siswas = Siswa::with(['kelas', 'user'])
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%");
        })
        ->get();

    $kelas = Kelas::all(); // variabel benar: $kelas

    return view('admin.siswa.index', compact('siswas', 'kelas'));
}

public function storeSiswa(Request $request)
{
    $request->validate([
        'nama' => 'required|string',
        'nisn' => 'required|string|unique:siswas,nisn',
        'email' => 'required|email|unique:users,email',
        'kelas_id' => 'required|exists:kelas,id',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'siswa',
    ]);

    Siswa::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'email' => $request->email, // WAJIB ADA
        'nisn' => $request->nisn,
        'kelas_id' => $request->kelas_id,
    ]);

    return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan.');
}
    // Import siswa dari file Excel
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diimpor.');
    }

    // Export siswa ke file Excel
    public function exportSiswa()
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }

    // Mengupdate data siswa
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'nama' => 'required|string',
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil diperbarui.');
    }

    // Menghapus data siswa
    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $siswa->delete();
        if ($user) $user->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus.');
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