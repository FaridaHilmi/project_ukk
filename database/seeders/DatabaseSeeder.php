<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Absensi;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // 1. SEEDER USERS
        // ============================================================
        $adminUser = User::create([
            'name'     => 'Administrator TU',
            'email'    => 'admin@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $guruUser = User::create([
            'name'     => 'Budi Santoso, S.Kom',
            'email'    => 'guru@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'guru',
        ]);

        $siswaUser1 = User::create([
            'name'     => 'Ahmad Fauzi',
            'email'    => 'siswa@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        $siswaUser2 = User::create([
            'name'     => 'Siti Aminah',
            'email'    => 'siti@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        $siswaUser3 = User::create([
            'name'     => 'Bintang Pratama',
            'email'    => 'bintang@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        $siswaUser4 = User::create([
            'name'     => 'Dewi Lestari',
            'email'    => 'dewi@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        $siswaUser5 = User::create([
            'name'     => 'Rudi Hermawan',
            'email'    => 'rudi@skinfa.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        // ============================================================
        // 2. SEEDER KELAS
        // ============================================================
        $kelas1 = Kelas::create([
            'nama_kelas' => 'X RPL 1',
            'jurusan'    => 'Rekayasa Perangkat Lunak',
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'X TKJ 1',
            'jurusan'    => 'Teknik Komputer dan Jaringan',
        ]);

        // ============================================================
        // 3. SEEDER GURU
        // ============================================================
        $guru = Guru::create([
            'user_id'   => $guruUser->id,
            'nip'       => '198501012010011001',
            'nama_guru' => $guruUser->name,
            'no_hp'     => '081234567890',
        ]);

        // ============================================================
        // 4. SEEDER MATA PELAJARAN
        // ============================================================
        $mapel1 = MataPelajaran::create([
            'kode_mapel' => 'PBO',
            'nama_mapel' => 'Pemrograman Berorientasi Objek',
        ]);

        $mapel2 = MataPelajaran::create([
            'kode_mapel' => 'WEB',
            'nama_mapel' => 'Pemrograman Web dan Perangkat Bergerak',
        ]);

        $mapel3 = MataPelajaran::create([
            'kode_mapel' => 'BASDAT',
            'nama_mapel' => 'Basis Data',
        ]);

        // ============================================================
        // 5. SEEDER SISWA (5 Data)
        // ============================================================
        $siswa1 = Siswa::create([
            'user_id'       => $siswaUser1->id,
            'kelas_id'      => $kelas1->id,
            'nis'           => '1001',
            'nisn'          => '0051234001',
            'nama_siswa'    => $siswaUser1->name,
            'jenis_kelamin' => 'L',
        ]);

        $siswa2 = Siswa::create([
            'user_id'       => $siswaUser2->id,
            'kelas_id'      => $kelas1->id,
            'nis'           => '1002',
            'nisn'          => '0051234002',
            'nama_siswa'    => $siswaUser2->name,
            'jenis_kelamin' => 'P',
        ]);

        $siswa3 = Siswa::create([
            'user_id'       => $siswaUser3->id,
            'kelas_id'      => $kelas1->id,
            'nis'           => '1003',
            'nisn'          => '0051234003',
            'nama_siswa'    => $siswaUser3->name,
            'jenis_kelamin' => 'L',
        ]);

        $siswa4 = Siswa::create([
            'user_id'       => $siswaUser4->id,
            'kelas_id'      => $kelas2->id,
            'nis'           => '1004',
            'nisn'          => '0051234004',
            'nama_siswa'    => $siswaUser4->name,
            'jenis_kelamin' => 'P',
        ]);

        $siswa5 = Siswa::create([
            'user_id'       => $siswaUser5->id,
            'kelas_id'      => $kelas2->id,
            'nis'           => '1005',
            'nisn'          => '0051234005',
            'nama_siswa'    => $siswaUser5->name,
            'jenis_kelamin' => 'L',
        ]);

        // ============================================================
        // 6. SEEDER NILAI (Sampel)
        // ============================================================
        // Siswa 1 (Ahmad Fauzi)
        Nilai::create([
            'siswa_id'          => $siswa1->id,
            'mata_pelajaran_id' => $mapel1->id,
            'guru_id'           => $guru->id,
            'nilai_tugas'       => 85,
            'nilai_uts'         => 80,
            'nilai_uas'         => 90,
        ]);
        Nilai::create([
            'siswa_id'          => $siswa1->id,
            'mata_pelajaran_id' => $mapel2->id,
            'guru_id'           => $guru->id,
            'nilai_tugas'       => 90,
            'nilai_uts'         => 85,
            'nilai_uas'         => 88,
        ]);

        // Siswa 2 (Siti Aminah)
        Nilai::create([
            'siswa_id'          => $siswa2->id,
            'mata_pelajaran_id' => $mapel1->id,
            'guru_id'           => $guru->id,
            'nilai_tugas'       => 75,
            'nilai_uts'         => 78,
            'nilai_uas'         => 80,
        ]);

        // ============================================================
        // 7. SEEDER ABSENSI (Sampel)
        // ============================================================
        $hariIni = Carbon::now()->format('Y-m-d');
        $kemarin = Carbon::yesterday()->format('Y-m-d');

        // Hari Ini
        Absensi::create(['siswa_id' => $siswa1->id, 'tanggal' => $hariIni, 'status' => 'hadir']);
        Absensi::create(['siswa_id' => $siswa2->id, 'tanggal' => $hariIni, 'status' => 'hadir']);
        Absensi::create(['siswa_id' => $siswa3->id, 'tanggal' => $hariIni, 'status' => 'sakit', 'keterangan' => 'Demam']);
        Absensi::create(['siswa_id' => $siswa4->id, 'tanggal' => $hariIni, 'status' => 'izin', 'keterangan' => 'Keperluan keluarga']);
        Absensi::create(['siswa_id' => $siswa5->id, 'tanggal' => $hariIni, 'status' => 'alpa']);

        // Kemarin
        Absensi::create(['siswa_id' => $siswa1->id, 'tanggal' => $kemarin, 'status' => 'hadir']);
        Absensi::create(['siswa_id' => $siswa2->id, 'tanggal' => $kemarin, 'status' => 'hadir']);
        Absensi::create(['siswa_id' => $siswa3->id, 'tanggal' => $kemarin, 'status' => 'hadir']);
    }
}