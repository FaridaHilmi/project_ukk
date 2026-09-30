<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->orderBy('nama_guru')->paginate(10);

        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'email' => $request->filled('email')
                ? trim($request->email)
                : trim((string) $request->nip) . '@guru.sch.id',
        ]);

        $data = $request->validate([
            'nip'       => 'required|string|max:30|unique:guru,nip',
            'nama_guru' => 'required|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
            'email'     => 'required|email|unique:users,email',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['nama_guru'],
                'email'    => $data['email'],
                'password' => Hash::make($data['nip']), // password awal = NIP
                'role'     => 'guru',
            ]);

            Guru::create([
                'user_id'   => $user->id,
                'nip'       => $data['nip'],
                'nama_guru' => $data['nama_guru'],
                'no_hp'     => $data['no_hp'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', "Guru ditambahkan. Login: {$data['email']} / password awal: {$data['nip']}");
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nip'       => ['required', 'string', 'max:30', Rule::unique('guru', 'nip')->ignore($guru->id)],
            'nama_guru' => 'required|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($guru->user_id)],
            'password'  => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($data, $guru) {
            $guru->update([
                'nip'       => $data['nip'],
                'nama_guru' => $data['nama_guru'],
                'no_hp'     => $data['no_hp'] ?? null,
            ]);

            $userData = ['name' => $data['nama_guru'], 'email' => $data['email']];
            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }
            $guru->user()->update($userData);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            $user = $guru->user;
            $guru->delete();
            $user?->delete();
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}