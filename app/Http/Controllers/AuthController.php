<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function dashboardRoute(?string $role): ?string
    {
        return match (strtolower(trim((string) $role))) {
            'admin' => 'admin.dashboard',
            'guru'  => 'guru.dashboard',
            'siswa' => 'siswa.dashboard',
            default => null,
        };
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            $route = $this->dashboardRoute(Auth::user()->role);

            if ($route) {
                return redirect()->route($route);
            }

            // Role tidak dikenali: logout untuk memutus loop
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $route = $this->dashboardRoute(Auth::user()->role);

            if ($route) {
                return redirect()->route($route);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Role tidak terdaftar!']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}