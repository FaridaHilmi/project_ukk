<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage di route: ->middleware('role:admin')
     *                 ->middleware('role:admin,guru')   ← multi-role
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan mengakses route ini
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Izinkan jika role user ada dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Role tidak sesuai → redirect ke dashboard masing-masing dengan pesan error
        $redirectRoute = match ($userRole) {
            'admin'  => 'admin.dashboard',
            'guru'   => 'guru.dashboard',
            'siswa'  => 'siswa.dashboard',
            default  => 'login',
        };

        return redirect()->route($redirectRoute)
            ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
    }
}