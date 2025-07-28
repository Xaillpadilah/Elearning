<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Tugas;

class SoalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
            'pertanyaan' => 'required|string',
            'jawaban_benar' => 'required|string',
            'pilihan' => 'nullable|string',
        ]);

        $soal = new Soal();
        $soal->tugas_id = $request->tugas_id;
        $soal->pertanyaan = $request->pertanyaan;
        $soal->jawaban_benar = $request->jawaban_benar;
        $soal->pilihan = $request->pilihan ? json_encode(array_map('trim', explode(',', $request->pilihan))) : null;
        $soal->save();

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}