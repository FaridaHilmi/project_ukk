<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\NilaiController;

Route::get('/', fn () => redirect()->route('login'));

// Login TANPA middleware 'guest' (redirect multi-role ditangani AuthController).
// Middleware 'guest' bawaan Laravel me-redirect ke '/', dan '/' kembali ke login => loop.
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ADMIN / TU
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru  = \App\Models\Guru::count();
            $totalKelas = \App\Models\Kelas::count();
            $totalMapel = \App\Models\MataPelajaran::count();

            return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'totalMapel'));
        })->name('dashboard');

        Route::resource('siswa', SiswaController::class)->except('show');
        Route::resource('guru', GuruController::class)->except('show');
        // Kelas & Mata Pelajaran: ditambahkan di langkah berikutnya
    });

// GURU
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $guru        = \App\Models\Guru::where('user_id', Auth::id())->first();
            $jumlahNilai = $guru ? \App\Models\Nilai::where('guru_id', $guru->id)->count() : 0;

            return view('guru.dashboard', compact('guru', 'jumlahNilai'));
        })->name('dashboard');

        // Didefinisikan SEBELUM resource agar tidak tertabrak pola nilai/{nilai}
        Route::post('/nilai/hitung-preview', [NilaiController::class, 'hitungPreview'])
            ->name('nilai.hitung-preview');

        Route::resource('nilai', NilaiController::class);
    });

// SISWA (view-only)
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'portal'])->name('dashboard');
    });