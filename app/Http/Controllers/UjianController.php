<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use App\Models\GuruMapelKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SoalUjian;
class UjianController extends Controller
{

   public function index()
{
    $user = Auth::user();

    // Ambil guru yang login
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();

    // Ambil data ujian berdasarkan guru yang login
    $ujians = Ujian::with(['soals', 'guruMapelKelas.kelas', 'guruMapelKelas.mapel'])
        ->whereHas('guruMapelKelas', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })
        ->get();

    // Ambil data relasi kelas dan mapel milik guru
    $relasi = \App\Models\GuruMapelKelas::with(['kelas', 'mapel'])
        ->where('guru_id', $guru->id)
        ->get();

    return view('guru.ujian.index', compact('ujians', 'relasi'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tipe_ujian' => 'required|in:pilihan_ganda,essai,campuran',
            'file_soal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
        ]);

        if ($request->hasFile('file_soal')) {
            $validated['file_soal'] = $request->file('file_soal')->store('soal', 'public');
        }

        $validated['acak_soal'] = $request->has('acak_soal');

        Ujian::create($validated);

        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tipe_ujian' => 'required|in:pilihan_ganda,essai,campuran',
            'file_soal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
        ]);

        if ($request->hasFile('file_soal')) {
            if ($ujian->file_soal) {
                Storage::disk('public')->delete($ujian->file_soal);
            }
            $validated['file_soal'] = $request->file('file_soal')->store('soal', 'public');
        }

        $validated['acak_soal'] = $request->has('acak_soal');

        $ujian->update($validated);

        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil diupdate!');
    }

    public function kirim($id)
    {
        $ujian = Ujian::findOrFail($id);



        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil dikirim!');
    }

    public function destroy($id)
    {
        $ujian = Ujian::findOrFail($id);

        if ($ujian->file_soal && Storage::disk('public')->exists($ujian->file_soal)) {
            Storage::disk('public')->delete($ujian->file_soal);
        }

        $ujian->delete();

        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil dihapus!');
    }
    public function tampilkanSoal($ujian_id)
    {
        // Menampilkan soal berdasarkan id ujian
        $soals = SoalUjian::where('ujian_id', $ujian_id)->orderBy('nomor')->get();

        return view('guru.soal.index', compact('soals', 'ujian_id'));
    }
    public function show($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $soals = $ujian->soals;

        return view('guru.ujian.soal', compact('ujian', 'soals'));
    }
    public function soalUjian($id)
    {
        $user = Auth::user();
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();
        $ujian = \App\Models\Ujian::findOrFail($id);

        // Ambil semua soal dari tabel soal_ujians berdasarkan ujian_id
        $soals = SoalUjian::where('ujian_id', $id)->get();

        return view('guru.ujian.soal', compact('ujian', 'guru', 'soals'));
    }
}