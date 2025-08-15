<?php


namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JawabanTugas;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\GuruMapelKelas;
class MateriSiswaController extends Controller
{
    public function showByMapel($mapel_id)
    {
        $user = Auth::user();

        // Cek hanya siswa yang boleh akses
        if ($user->role !== 'siswa') {
            abort(403, 'Hanya siswa yang dapat mengakses materi.');
        }

        // Pastikan mapel ditemukan
        $mapel = \App\Models\Mapel::findOrFail($mapel_id);

        // Ambil materi sesuai mapel, kelas user, dan status terkirim
        $materis = \App\Models\Materi::with(['mapel', 'kelas', 'uploader'])
            ->where('mapel_id', $mapel_id)
            ->where('kelas_id', $user->kelas_id)
            ->where('status_kirim', 'terkirim')
            ->get();

        // Kirim ke view
        return view('siswa.mapel.detail', compact('materis', 'mapel'));
    }


    public function show($id)
    {

        $user = Auth::user();

        // Ambil data siswa dari relasi user
        $siswa = $user->siswa;

        if (!$siswa || !$siswa->kelas_id) {
            abort(403, 'Data siswa atau kelas tidak ditemukan.');
        }

        // Ambil semua mapel untuk sidebar
        $mapels = Mapel::with('guru')->get();

        // Ambil mapel yang sedang dibuka
        $mapel = Mapel::with('guru')->findOrFail($id);

        // Ambil materi sesuai mapel dan kelas siswa
        $materis = Materi::with(['relasi.mapel', 'relasi.guru'])
            ->where('mapel_id', $id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('status_kirim', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        // Group berdasarkan Nama Mapel - Nama Guru


        // Tambahan debug jika kosong
        if ($materis->isEmpty()) {
            \Log::info("Tidak ada materi ditemukan untuk mapel_id={$id}, kelas_id={$siswa->kelas_id}");
        }

        // Ambil tugas sesuai mapel dan kelas
       $tugas = Tugas::with(['mapel', 'guru', 'soals'])
    ->where('mapel_id', $id)
    ->where('kelas_id', $siswa->kelas_id)
    ->orderBy('tanggal_deadline', 'asc')
    ->get();

       // Ambil ujian sesuai mapel dan kelas
$ujians = Ujian::with(['guruMapelKelas.mapel', 'guruMapelKelas.guru', 'soals'])
    ->whereHas('guruMapelKelas', function ($query) use ($id, $siswa) {
        $query->where('mapel_id', $id)
              ->where('kelas_id', $siswa->kelas_id);
    })
    ->orderBy('tanggal', 'asc')
    ->get();
    
        $materis = Materi::all();
        $tugas = Tugas::all();
        $ujians = Ujian::all(); 
    
    foreach ($ujians as $ujian) {
        if ($ujian->acak_soal && $ujian->soals->isNotEmpty()) {
            $shuffled = $ujian->soals->toArray();
            for ($i = count($shuffled) - 1; $i > 0; $i--) {
                $j = random_int(0, $i);
                $temp = $shuffled[$i];
                $shuffled[$i] = $shuffled[$j];
                $shuffled[$j] = $temp;
            }
            
           $ujian->soals = $ujian->soals->shuffle();
        }
          // Timer: Set waktu mulai hanya jika belum diset
    $sessionKey = 'ujian_start_time_' . $ujian->id;
    if (!session()->has($sessionKey)) {
        session([$sessionKey => now()]);
    }
    }
        return view('siswa.mapel.detail', compact('mapel', 'mapels', 'materis', 'tugas', 'ujians'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
            'file_jawaban' => 'required|file|max:10240', 
        ]);

        $path = $request->file('file_jawaban')->store('jawaban', 'public');

        JawabanTugas::create([
            'tugas_id' => $request->tugas_id,
            'siswa_id' => Auth::id(),
            'file_jawaban' => $path,
        ]);

        return back()->with('success', 'Jawaban berhasil dikirim.');
    }
    public function getGuruAttribute()
    {
        $relasi = GuruMapelKelas::with('guru')
            ->where('mapel_id', $this->mapel_id)
            ->where('kelas_id', $this->kelas_id)
            ->first();

        return $relasi?->guru?->nama ?? '-';
    }
}