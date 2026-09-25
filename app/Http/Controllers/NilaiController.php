<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Tampilkan daftar semua nilai yang diinput oleh guru yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->firstOrFail();

        $nilais = Nilai::with(['siswa', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->latest()
            ->get();

        return view('guru.nilai.index', compact('guru', 'nilais'));
    }

    /**
     * Tampilkan form input nilai baru.
     */
    public function create()
    {
        $guru          = Guru::where('user_id', Auth::id())->firstOrFail();
        $siswas        = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('guru.nilai.create', compact('guru', 'siswas', 'mataPelajaran'));
    }

    /**
     * Simpan nilai baru ke database.
     * nilai_akhir dihitung otomatis oleh Model (boot saving hook).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'         => 'required|exists:siswa,id',
            'mata_pelajaran_id'=> 'required|exists:mata_pelajaran,id',
            'nilai_tugas'      => 'required|numeric|min:0|max:100',
            'nilai_uts'        => 'required|numeric|min:0|max:100',
            'nilai_uas'        => 'required|numeric|min:0|max:100',
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // nilai_akhir akan dihitung otomatis di Model::boot() → saving hook
        Nilai::create([
            'siswa_id'          => $validated['siswa_id'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'guru_id'           => $guru->id,
            'nilai_tugas'       => $validated['nilai_tugas'],
            'nilai_uts'         => $validated['nilai_uts'],
            'nilai_uas'         => $validated['nilai_uas'],
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Tampilkan form edit nilai.
     */
    public function edit(Nilai $nilai)
    {
        $siswas        = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('guru.nilai.edit', compact('nilai', 'siswas', 'mataPelajaran'));
    }

    /**
     * Update nilai di database.
     * nilai_akhir dihitung ulang otomatis oleh Model (boot saving hook).
     */
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'siswa_id'          => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'nilai_tugas'       => 'required|numeric|min:0|max:100',
            'nilai_uts'         => 'required|numeric|min:0|max:100',
            'nilai_uas'         => 'required|numeric|min:0|max:100',
        ]);

        // nilai_akhir akan dihitung ulang otomatis di Model::boot() → saving hook
        $nilai->update([
            'siswa_id'          => $validated['siswa_id'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'nilai_tugas'       => $validated['nilai_tugas'],
            'nilai_uts'         => $validated['nilai_uts'],
            'nilai_uas'         => $validated['nilai_uas'],
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui!');
    }

    /**
     * Hapus data nilai.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus!');
    }

    /**
     * Preview kalkulasi nilai_akhir secara real-time (AJAX/API endpoint).
     * Formula: 30% Tugas + 30% UTS + 40% UAS
     */
    public function hitungPreview(Request $request)
    {
        $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts'   => 'required|numeric|min:0|max:100',
            'nilai_uas'   => 'required|numeric|min:0|max:100',
        ]);

        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $request->nilai_tugas,
            $request->nilai_uts,
            $request->nilai_uas
        );

        return response()->json([
            'nilai_akhir' => $nilaiAkhir,
            'predikat'    => $this->getPredikat($nilaiAkhir),
        ]);
    }

    /**
     * Tentukan predikat berdasarkan nilai akhir.
     */
    private function getPredikat(float $nilai): string
    {
        return match (true) {
            $nilai >= 90 => 'A (Sangat Baik)',
            $nilai >= 80 => 'B (Baik)',
            $nilai >= 70 => 'C (Cukup)',
            $nilai >= 60 => 'D (Kurang)',
            default      => 'E (Sangat Kurang)',
        };
    }
}