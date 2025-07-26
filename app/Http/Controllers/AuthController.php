<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login untuk semua role.
     */
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'string'], 
        'password' => ['required', 'string'],
    ]);

    $input = $credentials['email'];

    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        // Login berdasarkan email (admin, guru, siswa)
        if (Auth::attempt(['email' => $input, 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }
    } else {
        // Login orang tua berdasarkan NISN anak
        $siswa = \App\Models\Siswa::where('nisn', $input)->first();
        if ($siswa && $siswa->orangtua) {
            // Autentikasi orangtua
            $orangtua = $siswa->orangtua;

            if (Hash::check($credentials['password'], $orangtua->password)) {
                Auth::login($orangtua);
                $request->session()->regenerate();
                return redirect()->route('orangtua.dashboard');
            }
        }
    }

    throw ValidationException::withMessages([
        'email' => ['Email / NISN atau password salah.'],
    ]);
}
public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

private function redirectByRole($user)
{
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'guru':
            return redirect()->route('guru.dashboard');
        case 'siswa':
            return redirect()->route('siswa.siswadashboard');
        case 'orangtua':
            return redirect()->route('orangtua.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Peran pengguna tidak dikenali.']);
    }
}
}
