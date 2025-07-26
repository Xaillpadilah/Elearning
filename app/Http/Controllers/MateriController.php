<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin,guru');
    }

    public function index()
    {
        $user = auth()->user();
    $materis = Materi::with(['mapel', 'kelas', 'uploader'])->latest()->get();

    if ($user->role === 'guru') {
        // ambil mapel dan kelas berdasarkan relasi mengajar guru
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();
        $mapels = $guru->mapels ?? collect(); // atau mapel_guru
        $kelas = $guru->kelas ?? collect();   // atau kelas_guru
    } else {
        $mapels = \App\Models\Mapel::all();
        $kelas = \App\Models\Kelas::all();
    }

    return view('materi.index', compact('materis', 'mapels', 'kelas'));
}
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tipe_konten' => 'required|in:file,video,link',
            'file_upload' => 'nullable|file|max:10240',
            'link' => 'nullable|url',
            'deskripsi' => 'nullable|string',
        ]);

        $materi = new Materi();
        $materi->judul = $request->judul;
        $materi->mapel_id = $request->mapel_id;
        $materi->kelas_id = $request->kelas_id;
        $materi->tipe_konten = $request->tipe_konten;
        $materi->deskripsi = $request->deskripsi;
        $materi->uploaded_by = Auth::id();

        if (in_array($request->tipe_konten, ['file', 'video']) && $request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('materi', 'public');
            $materi->file_path = $path;
        }

        if ($request->tipe_konten === 'link') {
            $materi->link = $request->link;
        }

        $materi->save();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }
    public function kirim($id)
{
    $materi = Materi::findOrFail($id);
    $materi->status_kirim = true;
    $materi->save();

    return back()->with('success', 'Materi berhasil dikirim ke siswa.');
}

public function update(Request $request, $id)
{
    $materi = Materi::findOrFail($id);

    $request->validate([
        'judul' => 'required',
        'mapel_id' => 'required',
        'kelas_id' => 'required',
        'tipe_konten' => 'required',
        'deskripsi' => 'nullable',
        'file_upload' => 'nullable|file|max:20480',
        'link' => 'nullable|url',
    ]);

    $materi->judul = $request->judul;
    $materi->mapel_id = $request->mapel_id;
    $materi->kelas_id = $request->kelas_id;
    $materi->tipe_konten = $request->tipe_konten;
    $materi->deskripsi = $request->deskripsi;

    if ($request->hasFile('file_upload')) {
        $path = $request->file('file_upload')->store('materi', 'public');
        $materi->file_path = $path;
    }

    if ($request->tipe_konten === 'link') {
        $materi->link = $request->link;
    }

    $materi->save();

    return back()->with('success', 'Materi berhasil diperbarui.');
}
}
