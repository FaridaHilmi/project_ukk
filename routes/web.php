<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\NilaiController;

// ============================================================
// Route Publik — Redirect root ke login
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// Route Auth — Login & Logout
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================================================
// Route Admin / TU
// Hanya role 'admin' yang dapat mengakses
// ============================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', function () {
            $totalSiswa      = \App\Models\Siswa::count();
            $totalGuru       = \App\Models\Guru::count();
            $totalKelas      = \App\Models\Kelas::count();
            $totalMapel      = \App\Models\MataPelajaran::count();

            return view('admin.dashboard', compact(
                'totalSiswa', 'totalGuru', 'totalKelas', 'totalMapel'
            ));
        })->name('dashboard');

        // Manajemen Data Siswa
        Route::resource('siswa', SiswaController::class);

        // Manajemen Data Guru
        Route::resource('guru', GuruController::class);
    });

// ============================================================
// Route Guru
// Hanya role 'guru' yang dapat mengakses
// ============================================================
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        // Dashboard Guru
        Route::get('/dashboard', function () {
            $guru   = \App\Models\Guru::where('user_id', Auth::id())->first();
            $jumlahNilai = $guru
                ? \App\Models\Nilai::where('guru_id', $guru->id)->count()
                : 0;

            return view('guru.dashboard', compact('guru', 'jumlahNilai'));
        })->name('dashboard');

        // Input & Kelola Nilai
        Route::resource('nilai', NilaiController::class);

        // Endpoint AJAX preview kalkulasi nilai akhir
        Route::post('/nilai/hitung-preview', [NilaiController::class, 'hitungPreview'])
            ->name('nilai.hitung-preview');
    });

// ============================================================
// Route Siswa
// Hanya role 'siswa' yang dapat mengakses
// ============================================================
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard / Portal Siswa
        Route::get('/dashboard', [SiswaController::class, 'portal'])->name('dashboard');
    });