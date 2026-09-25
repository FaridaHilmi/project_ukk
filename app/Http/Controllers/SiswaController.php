<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Daftar semua siswa (Admin).
     */
    public function index()
    {
        $siswas = Siswa::with(['user', 'kelas'])->orderBy('nama_siswa')->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Form tambah siswa baru.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * Simpan siswa baru beserta akun user-nya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'kelas_id'      => 'required|exists:kelas,id',
            'nis'           => 'required|string|unique:siswa,nis',
            'nisn'          => 'required|string|unique:siswa,nisn',
            'nama_siswa'    => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        // 2. Buat data siswa & tautkan ke user
        Siswa::create([
            'user_id'       => $user->id,
            'kelas_id'      => $request->kelas_id,
            'nis'           => $request->nis,
            'nisn'          => $request->nisn,
            'nama_siswa'    => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Form edit data siswa.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'kelas_id'      => 'required|exists:kelas,id',
            'nis'           => 'required|string|unique:siswa,nis,' . $siswa->id,
            'nisn'          => 'required|string|unique:siswa,nisn,' . $siswa->id,
            'nama_siswa'    => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $siswa->update($request->only([
            'kelas_id', 'nis', 'nisn', 'nama_siswa', 'jenis_kelamin',
        ]));

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Hapus data siswa (akun user ikut terhapus via cascade).
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->user()->delete(); // hapus user → siswa ikut cascade
        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    /**
     * Dashboard Portal Siswa — melihat profil dan rekap nilai sendiri.
     */
    public function portal()
    {
        $siswa  = Siswa::with(['kelas', 'nilai.mataPelajaran'])
            ->where('user_id', Auth::id())
            ->first();

        $nilais   = $siswa?->nilai ?? collect();
        $absensis = $siswa?->absensi ?? collect();

        return view('siswa.dashboard', compact('siswa', 'nilais', 'absensis'));
    }
}