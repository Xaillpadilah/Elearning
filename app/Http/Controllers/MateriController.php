<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MateriImport;
use App\Exports\MateriExport;
use App\Models\Guru;

class MateriController extends Controller
{  public function index(Request $request)
    {
        $search = $request->input('search');

        $gurus = Guru::with('mapels')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->get();

        return view('admin.mapel.index', [
            'gurus' => $gurus,
            'search' => $search,
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'mapel' => 'required',
            'kelas' => 'required',
            'file'  => 'required|file|mimes:pdf,doc,docx,zip',
        ]);

        $path = $request->file('file')->store('materi');

        Materi::create([
            'judul'       => $request->judul,
            'mapel'       => $request->mapel,
            'kelas'       => $request->kelas,
            'file'        => $path,
            'uploaded_by' => auth()->id(),
            'uploaded_at' => now(),
        ]);

        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'nullable',
            'mapel' => 'nullable',
            'kelas' => 'nullable',
            'file'  => 'nullable|file|mimes:pdf,doc,docx,zip',
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($materi->file);
            $materi->file = $request->file('file')->store('materi');
        }

        $materi->judul = $request->judul ?? $materi->judul;
        $materi->mapel = $request->mapel ?? $materi->mapel;
        $materi->kelas = $request->kelas ?? $materi->kelas;
        $materi->save();

        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,csv']);
        Excel::import(new MateriImport, $request->file('file'));
        return back()->with('success', 'Data materi berhasil diimpor.');
    }

    public function export()
    {
        return Excel::download(new MateriExport, 'materi.xlsx');
    }
}
