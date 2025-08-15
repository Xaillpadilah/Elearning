<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\User;
use App\Models\Orangtua;
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
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $input = $credentials['email'];

        // 1. Coba login sebagai Admin atau user umum via email
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $input, 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                return $this->redirectByRole(Auth::user());
            }
        }

        // 2. Coba login sebagai Guru via NIP
        $guru = Guru::where('nik', $input)->first();
        if ($guru && $guru->user && Hash::check($credentials['password'], $guru->user->password)) {
            Auth::login($guru->user);
            $request->session()->regenerate();
            return $this->redirectByRole($guru->user);
        }

        // 3. Coba login sebagai Siswa via NISN
        $siswa = Siswa::where('nisn', $input)->first();
        if ($siswa && $siswa->user && Hash::check($credentials['password'], $siswa->user->password)) {
            Auth::login($siswa->user);
            $request->session()->regenerate();
            return $this->redirectByRole($siswa->user);
        }

        // 4. Coba login sebagai Orang Tua via NISN anak
        $ortu = Orangtua::with('siswa', 'user')
            ->whereHas('siswa', function ($query) use ($input) {
                $query->where('nisn', $input);
            })
            ->first();

        if ($ortu && $ortu->user && Hash::check($credentials['password'], $ortu->user->password)) {
            Auth::login($ortu->user);
            $request->session()->regenerate();
            return redirect()->route('orangtua.dashboard');
        }

        // Jika semuanya gagal
        throw ValidationException::withMessages([
            'email' => ['Email / NISN / NIK atau password salah.'],
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect berdasarkan role user.
     */
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
