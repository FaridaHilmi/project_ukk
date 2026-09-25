<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     * Jika sudah login, redirect langsung ke dashboard sesuai role.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Proses login menggunakan email + password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->onlyInput('email');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil keluar dari sistem.');
    }

    /**
     * Redirect ke dashboard sesuai role user yang sedang login.
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'guru'   => redirect()->route('guru.dashboard'),
            'siswa'  => redirect()->route('siswa.dashboard'),
            default  => redirect()->route('login'),
        };
    }
}