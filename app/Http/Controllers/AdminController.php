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
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;
use App\Models\Orangtua;
use App\Models\Jadwal; 
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
  
     // Dashboard Admin
     public function dashboard()
    {
         $user = auth()->user();

    $jumlahGuru = Guru::count();
    $jumlahSiswa = Siswa::count();
    $jumlahKelas = Kelas::count();
 
    // $jumlahPengumuman = Pengumuman::count();

    $dataChart = [
        'labels' => ['Guru', 'Siswa', 'Kelas', 'Mapel', 'Pengumuman'],
        'jumlah' => [$jumlahGuru, $jumlahSiswa, $jumlahKelas, ],
    ];

    return view('admin.dashboard', compact(
        'user',
        'jumlahGuru',
        'jumlahSiswa',
        'jumlahKelas',
      
    
        'dataChart'
    ));
}
//guru
public function guruindex(Request $request)
    {
        $search = $request->input('search');

        $gurus = Guru::with(['user', 'mapelKelas.mapel', 'mapelKelas.kelas'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('nik', 'like', "%{$search}%");
            })
            ->get()
            ->map(function ($guru) {
                // Format agar cocok untuk Blade
                $guru->mapel_kelas = $guru->mapelKelas->map(function ($mk) {
                    return [
                        'mapel_nama' => $mk->mapel->nama_mapel ?? '-',
                        'kelas_id' => $mk->kelas->nama_kelas ?? '-',
                    ];
                });
                return $guru;
            });

        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('admin.guru.index', compact('gurus', 'mapels', 'kelas', 'search'));
    }

    public function gurustore(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Simpan user
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('gurusmp5cidaun'), // default password
                'role' => 'guru',
            ]);

            // 2. Simpan guru
            $guru = Guru::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // 3. Simpan mapel_kelas (relasi pivot)
            foreach ($request->pelajaran as $pel) {
    if (!empty($pel['nama']) && !empty($pel['kelas_id'])) {
        $mapelId = Mapel::where('nama_mapel', $pel['nama'])->value('id');

        // Cek apakah kombinasi ini sudah ada
        $existing = $guru->mapelKelas()
            ->where('mapel_id', $mapelId)
            ->where('kelas_id', $pel['kelas_id'])
            ->first();

        if (!$existing) {
            $guru->mapelKelas()->create([
                'mapel_id' => $mapelId,
                'kelas_id' => $pel['kelas_id'],
            ]);
        }
    }
}

            DB::commit();
            return redirect()->back()->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    public function guruupdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $guru = Guru::findOrFail($id);
            $guru->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // Update user email
            if ($guru->user) {
                $guru->user->update(['email' => $request->email]);
            }

            // Hapus mapel_kelas lama dan buat ulang
            $guru->mapelKelas()->delete();
            foreach ($request->pelajaran as $pel) {
    if (!empty($pel['nama']) && !empty($pel['kelas_id'])) {
        $mapelId = Mapel::where('nama_mapel', $pel['nama'])->value('id');

        // Cegah duplikat
        $existing = $guru->mapelKelas()
            ->where('mapel_id', $mapelId)
            ->where('kelas_id', $pel['kelas_id'])
            ->first();

        if (!$existing) {
            $guru->mapelKelas()->create([
                'mapel_id' => $mapelId,
                'kelas_id' => $pel['kelas_id'],
            ]);
        }
    }
}

            DB::commit();
            return redirect()->back()->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage());
        }
    }

    public function gurudestroy($id)
    {
        try {
            $guru = Guru::findOrFail($id);
            $guru->mapelKelas()->delete();
            $guru->user()->delete();
            $guru->delete();

            return redirect()->back()->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }

    public function guruexport()
    {
        return Excel::download(new GuruExport, 'data_guru.xlsx');
    }

    public function guruimport(Request $request)
    {
        try {
            Excel::import(new GuruImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data guru berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal impor data guru: ' . $e->getMessage());
        }
    }


    //siswa
   public function indexSiswa(Request $request)
{
    $search = $request->input('search');

    $siswas = Siswa::with(['kelas', 'user', 'orangtua']) 
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%");
            });
        })
        ->orderBy('nama')
        ->get();

    $kelas = Kelas::all();

    return view('admin.siswa.index', compact('siswas', 'kelas'));
}
//siswa
public function storeSiswa(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'nisn' => 'required|digits_between:8,10|unique:siswas,nisn',
        'kelas_id' => 'required',
        'email' => 'required|email|unique:users,email',
        'jenis_kelamin' => 'required',
        'nama_ortu' => 'required',
        'nomor_hp' => 'required',
    ]);

    \DB::beginTransaction();

    try {
        // 1. Buat akun user siswa
        $userSiswa = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'role' => 'siswa',
            'password' => Hash::make('smp5siswa'),
            'kelas_id' => $request->kelas_id,
        ]);

        // 2. Buat data siswa
        $siswa = Siswa::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'user_id' => $userSiswa->id,
        ]);

        // 3. Buat akun user orangtua (email dummy)
        $userOrtu = User::create([
            'name' => $request->nama_ortu,
            'email' => $request->nisn . '@ortu.local',
            'role' => 'orangtua',
            'password' => Hash::make('smp5orangtuasiswa'),
        ]);

        // 4. Buat data orangtua dan kaitkan ke siswa
        Orangtua::create([
            'nama' => $request->nama_ortu,
            'user_id' => $userOrtu->id,
            'nomor_hp' => $request->nomor_hp,
            'siswa_id' => $siswa->id,
        ]);

        \DB::commit();

        return redirect()->back()->with('success', 'Data siswa dan orang tua berhasil ditambahkan.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
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
    // Ambil data siswa yang akan diupdate
    $siswa = Siswa::findOrFail($id);

    // Validasi input
    $request->validate([
        'nama' => 'required',
        'nisn' => 'required|digits_between:8,10|unique:siswas,nisn,' . $siswa->id,
        'kelas_id' => 'required',
        'email' => 'required|email|unique:users,email,' . $siswa->user_id,
        'jenis_kelamin' => 'required',
        'nama_ortu' => 'required',
        'nomor_hp' => 'required',
    ]);

    // Update user
    $user = $siswa->user;
    $user->email = $request->email;
    $user->save();

    // Update orangtua
    $orangtua = $siswa->orangtua;
    $orangtua->nama = $request->nama_ortu;
    $orangtua->nomor_hp = $request->nomor_hp;
    $orangtua->save();

    // Update siswa
    $siswa->update([
        'nama' => $request->nama,
        'nisn' => $request->nisn,
        'kelas_id' => $request->kelas_id,
        'jenis_kelamin' => $request->jenis_kelamin,
    ]);

    return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
}

    // Menghapus data siswa
    public function destroySiswa($id)
    {
       $siswa = Siswa::with('user', 'orangtua')->findOrFail($id);

        // Hapus orangtua
        if ($siswa->orangtua) {
            $siswa->orangtua->delete();
        }

        // Hapus user
        if ($siswa->user) {
            $siswa->user->delete();
        }

        // Hapus siswa
        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }


//kelas
   public function indexkelas(Request $request)
{
    $search = $request->search;
  $kelas = Kelas::with('guru')->get(); // jika ada relasi ke guru
    $gurus = Guru::all(); // ambil semua guru
    $kelas = Kelas::withCount('siswas') // menghitung otomatis jumlah siswa
        ->when($search, function ($query, $search) {
            $query->where('nama_kelas', 'like', "%$search%")
                  ->orWhere('wali_kelas', 'like', "%$search%");
        })
        ->get();

    return view('admin.kelas.index', compact('kelas', 'search', 'gurus'));
}
    public function storekelas(Request $request)
    {
         $request->validate([
        'nama_kelas' => 'required|string',
        'wali_kelas' => 'required|exists:gurus,id', // pastikan ini ID guru
    ]);

    Kelas::create([
        'nama_kelas' => $request->nama_kelas,
        'wali_kelas' => $request->wali_kelas, // ini harus ID
    ]);

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function updatekelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroyKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil dihapus.');
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
//jadwal
     public function indexJadwal($kelas_id)
    {
        $kelas = Kelas::with('jadwals.mapel', 'jadwals.guru')->findOrFail($kelas_id);
        $mapels = Mapel::all();
        $gurus = Guru::all();
        $jadwals = $kelas->jadwals;

        return view('admin.kelas.jadwal', compact('kelas', 'mapels', 'gurus', 'jadwals'));
    }

    // Menyimpan jadwal baru
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id'  => 'required|exists:gurus,id',
            'hari'     => 'required|string',
            'jam'      => 'required|string',
            'tipe_ruangan' => 'required|in:online,offline',
            'ruangan'  => 'nullable|string',
        ]);

        Jadwal::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id'  => $request->guru_id,
            'hari'     => $request->hari,
            'jam'      => $request->jam,
            'tipe_ruangan' => $request->tipe_ruangan,
            'ruangan'  => $request->tipe_ruangan === 'online' ? $request->ruangan : ($request->ruangan ?? null),
        ]);

        return redirect()->route('admin.kelas.jadwal', $request->kelas_id)->with('success', 'Jadwal berhasil ditambahkan.');
    }
     // Tampilkan data jadwal untuk diedit 
      public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
            'hari' => 'required',
            'jam' => 'required',
            'tipe_ruangan' => 'required',
            'ruangan' => 'nullable|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->back()->with('success', 'Jadwal berhasil diupdate');
    }

    // ✅ Mengambil data untuk edit via AJAX
    public function getJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return response()->json($jadwal);
    }

    // Hapus jadwal
    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }
    
//pengumuman 
 public function pengumumanindex()
    {
        $pengumumen = Pengumuman::with('dibuat_oleh_user')->latest()->get();
        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_pengumuman' => 'required|date',
            'ditujukan_kepada' => 'required|in:semua,guru,siswa,orangtua',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
            'ditujukan_kepada' => $request->ditujukan_kepada,
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function pengumumanupdate(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_pengumuman' => 'required|date',
            'ditujukan_kepada' => 'required|in:semua,guru,siswa,orangtua',
        ]);

        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
            'ditujukan_kepada' => $request->ditujukan_kepada,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function pengumumandestroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}


