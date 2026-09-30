<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    // ================= ADMIN =================

    public function index()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa')->paginate(10);

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        // Email otomatis jika dikosongkan
        $request->merge([
            'email' => $request->filled('email')
                ? trim($request->email)
                : trim((string) $request->nis) . '@siswa.sch.id',
        ]);

        $data = $request->validate([
            'nama_siswa'    => 'required|string|max:255',
            'nis'           => 'required|string|max:30|unique:siswa,nis',
            'nisn'          => 'required|string|max:30|unique:siswa,nisn',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'email'         => 'required|email|unique:users,email',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['nama_siswa'],
                'email'    => $data['email'],
                'password' => Hash::make($data['nis']), // password awal = NIS
                'role'     => 'siswa',
            ]);

            Siswa::create([
                'user_id'       => $user->id,
                'kelas_id'      => $data['kelas_id'],
                'nis'           => $data['nis'],
                'nisn'          => $data['nisn'],
                'nama_siswa'    => $data['nama_siswa'],
                'jenis_kelamin' => $data['jenis_kelamin'],
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', "Siswa ditambahkan. Login: {$data['email']} / password awal: {$data['nis']}");
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nama_siswa'    => 'required|string|max:255',
            'nis'           => ['required', 'string', 'max:30', Rule::unique('siswa', 'nis')->ignore($siswa->id)],
            'nisn'          => ['required', 'string', 'max:30', Rule::unique('siswa', 'nisn')->ignore($siswa->id)],
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($siswa->user_id)],
            'password'      => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($data, $siswa) {
            $siswa->update([
                'kelas_id'      => $data['kelas_id'],
                'nis'           => $data['nis'],
                'nisn'          => $data['nisn'],
                'nama_siswa'    => $data['nama_siswa'],
                'jenis_kelamin' => $data['jenis_kelamin'],
            ]);

            $userData = ['name' => $data['nama_siswa'], 'email' => $data['email']];
            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }
            $siswa->user()->update($userData);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $user = $siswa->user;
            $siswa->delete();
            $user?->delete();
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // ================= PORTAL SISWA (view-only) =================

    public function portal()
    {
        // Hanya data milik user yang sedang login
        $siswa = Siswa::with(['kelas', 'nilai.mataPelajaran', 'absensi'])
            ->where('user_id', Auth::id())
            ->first();

        $nilais   = $siswa?->nilai ?? collect();
        $absensis = $siswa?->absensi ?? collect();

        return view('siswa.dashboard', compact('siswa', 'nilais', 'absensis'));
    }
}