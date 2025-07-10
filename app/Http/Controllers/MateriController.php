<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
class MateriController extends Controller
{
      public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $materi = Materi::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%$search%")
                         ->orWhere('mapel', 'like', "%$search%")
                         ->orWhere('kelas', 'like', "%$search%");
        })->latest()->get();

        // ✅ View tetap diarahkan ke folder mapel
        return view('admin.mapel.index', compact('materi', 'user', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'file'  => 'required|file|mimes:pdf,docx,ppt,pptx',
        ]);

        $path = $request->file('file')->store('materi', 'public');

        Materi::create([
            'judul' => $request->judul,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'file'  => $path,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('admin.mapel')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $materi->update([
            'judul' => $request->judul,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.mapel')->with('success', 'Materi berhasil diperbarui.');
    }

    public function import(Request $request)
    {
        // Tambahkan jika kamu menggunakan Excel
    }

    public function export()
    {
        // Tambahkan jika kamu menggunakan Excel
    }

    // Optional: mapel dummy list
    public function mapel()
    {
        $user = auth()->user();
        $daftarMapel = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris'];
        return view('admin.mapel.index', compact('user', 'daftarMapel'));
    }
}