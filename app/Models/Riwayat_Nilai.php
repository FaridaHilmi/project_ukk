<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model RiwayatNilai — Disimpan untuk kompatibilitas migration lama.
 * Jika tidak digunakan, migration ini dapat dihapus secara manual.
 *
 * @deprecated Tabel ini tidak termasuk dalam spesifikasi sistem saat ini.
 */
class RiwayatNilai extends Model
{
    use HasFactory;

    protected $table = 'riwayat_nilai';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'mata_pelajaran_id',
        'semester',
        'tahun_ajaran',
        'nilai',
        'keterangan',
    ];

    // ============================================================
    // RELASI
    // ============================================================

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}
