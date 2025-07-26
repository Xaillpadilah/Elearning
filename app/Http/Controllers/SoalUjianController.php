<?php

namespace App\Http\Controllers;

use App\Models\SoalUjian;
use Illuminate\Http\Request;

class SoalUjianController extends Controller
{
    public function index($ujian_id)
    {
        $soalUjians = SoalUjian::where('ujian_id', $ujian_id)->get();
        return view('guru.ujian.index', compact('soalUjians', 'ujian_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
        ]);

        SoalUjian::create($request->all());

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $soal = SoalUjian::findOrFail($id);
        $soal->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}
