<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Pemakaian: ->middleware('role:admin') atau ->middleware('role:admin,guru')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Normalisasi KEDUA sisi supaya "Admin" == "admin" (sumber loop sebelumnya)
        $userRole = strtolower(trim((string) Auth::user()->role));
        $allowed  = array_map(fn ($r) => strtolower(trim($r)), $roles);

        if (in_array($userRole, $allowed, true)) {
            return $next($request);
        }

        $redirectRoute = match ($userRole) {
            'admin' => 'admin.dashboard',
            'guru'  => 'guru.dashboard',
            'siswa' => 'siswa.dashboard',
            default => null,
        };

        // Role tidak dikenali -> logout bersih
        if (!$redirectRoute) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Role akun Anda tidak valid.');
        }

        // Pengaman anti-loop: jangan redirect ke halaman yang sama
        if ($request->routeIs($redirectRoute)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return redirect()->route($redirectRoute)
            ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
    }
}