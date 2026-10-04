<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Quick demo login switcher
     */
    public function demoLogin($role)
    {
        $email = match($role) {
            'admin' => 'admin@karangtaruna.org',
            'bendahara' => 'bendahara@karangtaruna.org',
            'sekretaris' => 'sekretaris@karangtaruna.org',
            'anggota' => 'anggota1@karangtaruna.org',
            default => 'admin@karangtaruna.org',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai ' . $user->name . ' (' . ucfirst($role) . ')');
        }

        return redirect()->route('login')->with('error', 'User demo tidak ditemukan.');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
