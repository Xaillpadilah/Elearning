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
use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\JawabanUjian;
class SiswaController extends Controller
{
    // Halaman Dashboard Siswa
    public function index()
{
    $user = Auth::user();
    $siswa = Siswa::where('user_id', $user->id)->first();

    $mapels = Mapel::with('guru')->get();
    $mapel = $mapels->first(); // ambil mapel pertama untuk ditampilkan default

    $materis = [];
    $tugas = [];
    $ujians = [];

    if ($mapel && $siswa && $siswa->kelas_id) {
        $materis = Materi::where('mapel_id', $mapel->id)
            ->where('kelas_id', $siswa->kelas_id)
            ->get();

        $tugas = Tugas::where('mapel_id', $mapel->id)
            ->where('kelas_id', $siswa->kelas_id)
            ->get();

        
    }

    $pengumumen = Pengumuman::with('dibuat_oleh_user')
        ->whereIn('ditujukan_kepada', ['siswa', 'semua'])
        ->latest()
        ->take(5)
        ->get();

    $jumlahAbsensi = $siswa ? Absensi::where('siswa_id', $siswa->id)->count() : 0;
    $jumlahUjian = 0;

    $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');

    $jadwalHariIni = [];

    if ($siswa && $siswa->kelas_id) {
        $jadwalHariIni = Jadwal::with(['mapel', 'guru'])
            ->where('hari', $hariIni)
            ->where('kelas_id', $siswa->kelas_id)
            ->get();
    }

    return view('siswa.siswadashboard', compact(
        'siswa',
        'pengumumen',
        'jumlahAbsensi',
        'jumlahUjian',
        'jadwalHariIni',
        'mapels',
        'mapel',
        'materis',
        'tugas',
     
        'hariIni'
    ));
}
    // Halaman Daftar Semua Mata Pelajaran
    public function absensi()
    {

        // Ambil data absensi siswa
        $absensi = []; // ganti dengan data dari model jika sudah ada

        return view('siswa.absensi.index', compact('absensi'));
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

    public function materi($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        $mapels = Mapel::all(); // untuk sidebar jika diperlukan
        $mapel = Mapel::findOrFail($id);

        // Ambil materi hanya yang dikirim oleh guru dan sesuai kelas siswa
        $materis = Materi::where('mapel_id', $id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('status_kirim', 'terkirim')
            ->get();

        return view('siswa.materi.index', compact('materis', 'mapels', 'mapel'));
    }
    public function tugas($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        $mapel = Mapel::findOrFail($id);
        $tugas = Tugas::where('mapel_id', $id)
            ->where('kelas_id', $siswa->kelas_id)
            ->get();

        $mapels = Mapel::all();

        return view('siswa.tugas', compact('tugas', 'mapel', 'mapels'));
    }

    public function ujian($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        $mapel = Mapel::findOrFail($id);
        $ujian = Ujian::where('mapel_id', $id)
            ->where('kelas_id', $siswa->kelas_id)
            ->get();

        $mapels = Mapel::all();

        return view('siswa.ujian', compact('ujian', 'mapel', 'mapels'));
    }
    public function storeUjianJawaban(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'file_jawaban' => 'required|file|mimes:pdf,docx,doc,zip|max:10240'
        ]);

        $path = $request->file('file_jawaban')->store('jawaban_ujian', 'public');

        JawabanUjian::create([
            'ujian_id' => $request->ujian_id,
            'user_id' => Auth::id(),
            'file_path' => $path,
        ]);

        return back()->with('success', 'Jawaban berhasil dikirim.');
    }
    public function profil()
    {
        $user = Auth::user();

        // Ambil data siswa yang terhubung dengan user
        $siswa = $user->siswa()->with('kelas')->first();

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        return view('siswa.profil', compact('user', 'siswa'));
    }
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('foto')) {
            // Simpan file foto ke dalam storage/app/public/foto_profil
            $path = $request->file('foto')->store('foto_profil', 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diperbarui.');
    }
 public function jawabanPilihanGandaStore(Request $request)
{
    $ujianId = $request->ujian_id;
    $siswaId = auth()->id(); // sesuaikan jika pakai guard lain

    // Cek apakah siswa sudah pernah menjawab ujian ini
    $sudahJawab = JawabanUjian::where('ujian_id', $ujianId)
        ->where('user_id', $siswaId)
        ->exists();

    if ($sudahJawab) {
        return back()->with('error', 'Anda sudah mengerjakan ujian ini.');
    }

    // Validasi input
    $request->validate([
        'ujian_id' => 'required|exists:ujians,id',
        'jawaban' => 'required|array',
    ]);

    $ujian = Ujian::with('soals')->findOrFail($ujianId);
    $jawabanSiswa = $request->input('jawaban');

    $jumlahSoal = $ujian->soals->count();
    $jawabanBenar = 0;

    // Simpan jawaban siswa per soal
    foreach ($ujian->soals as $soal) {
        $jawaban = $jawabanSiswa[$soal->id] ?? null;

        if ($jawaban && $jawaban == $soal->kunci_jawaban) {
            $jawabanBenar++;
        }

        JawabanUjian::create([
            'ujian_id' => $ujian->id,
            'user_id' => $siswaId,
            'soal_id' => $soal->id,
            'jawaban' => $jawaban,
            'skor' => null,
        ]);
    }

    // Hitung skor akhir
    $skor = $jumlahSoal > 0 ? round(($jawabanBenar / $jumlahSoal) * 100) : 0;

    // Simpan skor total di baris khusus
    JawabanUjian::create([
        'ujian_id' => $ujian->id,
        'user_id' => $siswaId,
        'soal_id' => null,
        'jawaban' => null,
        'skor' => $skor,
    ]);

    return redirect()->back()->with('success', 'Jawaban berhasil dikirim!');
}
public function kerjakanUjian($ujianId, $soalKe = 1)
{
    $ujian = Ujian::with(['soalUjian'])->findOrFail($ujianId);

    $soalTotal = $ujian->soalUjian->count();
    $soal = $ujian->soalUjian->skip($soalKe - 1)->take(1)->first();

    if (!$soal) {
        return redirect()->route('siswa.ujian.selesai', $ujianId);
    }

    return view('siswa.ujian.kerjakan', compact('ujian', 'soal', 'soalKe', 'soalTotal'));
}
}



