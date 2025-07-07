<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors(['message' => 'Email atau password salah.']);
    }

    // Login secara resmi ke sistem Laravel
    Auth::login($user);

    // Optional: simpan role ke session (boleh dihapus kalau tidak dipakai)
    Session::put('user_role', $user->role);

    // Redirect berdasarkan role
    return match ($user->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'guru'     => redirect()->route('guru.dashboard'),
        'siswa'    => redirect()->route('siswa.dashboard'),
        'orangtua' => redirect()->route('orangtua.dashboard'),
        default    => redirect()->route('login')->withErrors(['message' => 'Role tidak dikenali.']),
    };
}
}

