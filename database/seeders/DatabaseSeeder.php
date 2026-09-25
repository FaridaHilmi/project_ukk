<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'nama_lengkap' => 'Administrator Utama',
            'role' => 'admin',
        ]);

        // 2. Buat Akun Guru + Otomatis Tautkan ke Tabel Guru
        $userGuru = User::create([
            'username' => 'guru1',
            'password' => bcrypt('guru123'),
            'nama_lengkap' => 'Apt. Budi Santoso, S.Farm',
            'role' => 'guru',
        ]);

        Guru::create([
            'nip' => '198501012010011001',
            'nama_guru' => $userGuru->nama_lengkap,
            'mapel' => 'Farmakologi',
            'telp' => '081234567890',
            'user_id' => $userGuru->user_id, // Terhubung otomatis!
        ]);

        // 3. Buat Akun Siswa + Otomatis Tautkan ke Tabel Siswa
        $userSiswa = User::create([
            'username' => 'siswa1',
            'password' => bcrypt('siswa123'),
            'nama_lengkap' => 'Siti Rahma',
            'role' => 'siswa',
        ]);

        Siswa::create([
            'nisn' => '0051234567',
            'nama_siswa' => $userSiswa->nama_lengkap,
            'kelas' => 'XII Farmasi 1',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Merdeka No. 12',
            'user_id' => $userSiswa->user_id, // Terhubung otomatis!
        ]);
    }
}