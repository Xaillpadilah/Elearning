<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Video;
use App\Models\Penilaian;
use App\Models\Pengumuman;
class SiswaController extends Controller
{
    // Halaman Dashboard Siswa
    public function index()
    {
        $user = Auth::user();
        $mapels = \App\Models\Mapel::with('guru')->get();

        $pengumumen = Pengumuman::with('dibuat_oleh_user')
            ->whereIn('ditujukan_kepada', ['siswa', 'semua'])
            ->latest()
            ->take(5) // tampilkan 5 pengumuman terbaru
            ->get();

        return view('siswa.siswadashboard', compact('mapels', 'pengumumen'));
    }

    // Halaman Daftar Semua Mata Pelajaran
    public function mapel()
    {

        $siswa = Auth::user();
        $mapels = Mapel::all(); // Ambil semua mapel
        $mapels = Mapel::with('guru')->get(); // ← tambahkan 'guru'
        return view('siswa.mapel.index', compact('mapels'));
    }

    // Halaman Detail Mata Pelajaran + Materi berdasarkan kelas siswa
    public function show($id)
    {

        $siswa = Auth::user();
        $mapel = Mapel::with('guru')->findOrFail($id); // ← tambahkan 'guru'
        $mapels = Mapel::with('guru')->get();          // ← tambahkan 'guru'
        $mapel = Mapel::findOrFail($id);     // Ambil mapel berdasarkan ID
        $mapels = Mapel::all();              // Ambil semua mapel (untuk sidebar, dll)

        $siswa = Auth::user();               // Ambil user yang sedang login (siswa)
        $kelasId = $siswa->kelas_id ?? null; // Ambil kelas_id dari siswa

        // Ambil materi berdasarkan mapel_id & kelas_id
        $materis = Materi::where('mapel_id', $id)
            ->when($kelasId, function ($query, $kelasId) {
                return $query->where('kelas_id', $kelasId);
            })
            ->latest()
            ->get();

        return view('siswa.mapel.index', compact('mapel', 'mapels', 'materis'));
    }
    public function materi($id)
    {
        $siswa = Auth::user(); // Jika ingin pakai data user (bisa dipakai di view)

        // Ambil semua mata pelajaran beserta gurunya (untuk sidebar/list)
        $mapels = Mapel::with('guru')->get();

        // Ambil materi berdasarkan ID mapel yang diklik
        $materis = Materi::where('mapel_id', $id)->get();

        // Ambil data mapel aktif yang sedang diklik, beserta gurunya
        $mapelAktif = Mapel::with('guru')->find($id);

        return view('siswa.mapel.index', compact('materis', 'mapels', 'mapelAktif', 'siswa'));
    }
    public function tugas($id)
    {

        // tampilkan tugas berdasarkan mapel_id
    }

    public function ujian($id)
    {
        // tampilkan ujian berdasarkan mapel_id
    }

    public function video($id)
    {
        // tampilkan video berdasarkan mapel_id
    }
    public function boot(): void
    {

        $siswa = Auth::user();
        View::composer('siswa.*', function ($view) {
            $view->with('mapels', Mapel::all());
        });
    }
    public function absensi()
    {

        // Ambil data absensi siswa
        $absensi = []; // ganti dengan data dari model jika sudah ada

        return view('siswa.absensi.index', compact('absensi'));
    }

    public function materiByMapel($id)
    {
        $user = auth()->user();

        // Pastikan user punya kelas_id
        if (!$user->kelas_id) {
            return back()->with('error', 'Akun ini belum terhubung dengan kelas manapun.');
        }

        $siswaKelasId = $user->kelas_id;
        $mapel = \App\Models\Mapel::findOrFail($id);

        $materis = \App\Models\Materi::with('uploader')
            ->where('status_kirim', true)
            ->where('mapel_id', $id)
            ->where('kelas_id', $siswaKelasId)
            ->get();

        return view('siswa.materi.index', compact('mapel', 'materis'));
    }
    public function nilai()
    {
        $user = auth()->user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        // Ambil semua nilai yang dimiliki siswa ini
        $penilaians = Penilaian::with(['mapel', 'guru'])
            ->where('siswa_id', $siswa->id)
            ->get();

        $mapels = \App\Models\Mapel::all();

        return view('siswa.nilai.index', compact('penilaians', 'siswa', 'mapels'));
    }

    public function showByMapel($id)
    {
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            abort(403, 'Hanya siswa yang dapat mengakses materi.');
        }

        $mapel = Mapel::findOrFail($id);
        $siswa = $user->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        $kelasId = $siswa->kelas_id;

        // Validasi mapel tersedia untuk kelas
        $mapelValid = $mapel->guruMapelKelas()->where('kelas_id', $kelasId)->exists();

        if (!$mapelValid) {
            abort(403, 'Mapel ini tidak tersedia untuk kelas Anda.');
        }

        $materis = Materi::with('uploader')
            ->where('mapel_id', $id)
            ->where('status_kirim', 'terkirim')
            ->get();

        return view('siswa.materi.index', compact('mapel', 'materis'));
    }
}



