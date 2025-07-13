<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
   public function index()
    {
        $user = Auth::user();

        // Cek role user untuk menentukan view mana yang dipakai
        if ($user->role === 'guru') {
            return view('guru.profil.index', compact('user'));
        }

        // Jika ada role lain, bisa arahkan ke view lain, atau tolak
        abort(403, 'Akses hanya untuk guru.');
    }
}