<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Daftar semua guru (Admin).
     */
    public function index()
    {
        $gurus = Guru::with('user')->orderBy('nama_guru')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Form tambah guru baru.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan guru baru beserta akun user-nya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'nip'       => 'required|string|unique:guru,nip',
            'nama_guru' => 'required|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        // 2. Buat data detail guru
        Guru::create([
            'user_id'   => $user->id,
            'nip'       => $request->nip,
            'nama_guru' => $request->nama_guru,
            'no_hp'     => $request->no_hp,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Form edit data guru.
     */
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update data guru.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip'       => 'required|string|unique:guru,nip,' . $guru->id,
            'nama_guru' => 'required|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
        ]);

        $guru->update($request->only(['nip', 'nama_guru', 'no_hp']));

        // Update nama di tabel users juga
        $guru->user->update(['name' => $request->nama_guru]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Hapus data guru (akun user ikut terhapus via cascade).
     */
    public function destroy(Guru $guru)
    {
        $guru->user()->delete(); // hapus user → guru ikut cascade
        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus!');
    }
}