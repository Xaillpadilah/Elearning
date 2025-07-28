<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\JawabanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class TugasSiswaController extends Controller
{


    public function index(Request $request)
    {
        $siswa = Auth::user();
        $kelasId = $siswa->kelas_id;

        $tugasList = Tugas::with('relasi.mapel')
            ->whereHas('relasi', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            })
            ->select('id', 'judul', 'deskripsi', 'jenis', 'tanggal_deadline', 'file_path', 'guru_mapel_kelas_id', 'created_at', 'updated_at', 'dikirim')
            ->get();

        $tugas = null;
        $soal = null;

        if ($request->has('kerjakan')) {
            $tugas = Tugas::findOrFail($request->kerjakan);

            if ($tugas->soal) {
                $soal = collect(json_decode($tugas->soal, true))->shuffle()->values()->all(); // acak soal
            }
        }

        return view('siswa.tugas.index', compact('tugasList', 'tugas', 'soal'));
    }

    public function submit(Request $request, $id)
    {
        $siswa = Auth::user();
        $tugas = Tugas::findOrFail($id);

        if ($tugas->jenis === 'kuis') {
            $jawabanUser = $request->input('jawaban');
            $soal = collect(json_decode($tugas->soal, true));
            $skor = 0;

            foreach ($soal as $index => $item) {
                if (isset($jawabanUser[$index]) && strtolower(trim($jawabanUser[$index])) === strtolower(trim($item['jawaban']))) {
                    $skor += 1;
                }
            }

            JawabanTugas::create([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'jawaban' => json_encode($jawabanUser),
                'skor' => $skor,
            ]);

            return redirect()->route('siswa.tugas.index')->with('success', "Jawaban dikirim! Skor Anda: $skor");
        }

        if ($request->hasFile('file_jawaban')) {
            $path = $request->file('file_jawaban')->store('jawaban_siswa', 'public');

            JawabanTugas::create([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'file_jawaban' => $path,
            ]);

            return redirect()->route('siswa.tugas.index')->with('success', 'Jawaban berhasil diupload!');
        }

        return back()->with('error', 'Gagal mengirim jawaban.');
    }
}