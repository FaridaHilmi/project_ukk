<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
    ];

    protected $casts = [
        'nilai_tugas'  => 'decimal:2',
        'nilai_uts'    => 'decimal:2',
        'nilai_uas'    => 'decimal:2',
        'nilai_akhir'  => 'decimal:2',
    ];

    // ============================================================
    // BOOT — Kalkulasi otomatis nilai_akhir
    // ============================================================

    protected static function boot()
    {
        parent::boot();

        // Hitung nilai_akhir otomatis sebelum disimpan (Create & Update)
        static::saving(function ($nilai) {
            $nilai->nilai_akhir = self::hitungNilaiAkhir(
                $nilai->nilai_tugas,
                $nilai->nilai_uts,
                $nilai->nilai_uas
            );
        });
    }

    // ============================================================
    // KALKULASI
    // ============================================================

    /**
     * Hitung nilai akhir dengan bobot:
     *  30% Nilai Tugas + 30% Nilai UTS + 40% Nilai UAS
     *
     * @param  float $tugas
     * @param  float $uts
     * @param  float $uas
     * @return float
     */
    public static function hitungNilaiAkhir(float $tugas, float $uts, float $uas): float
    {
        return round(($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40), 2);
    }

    // ============================================================
    // RELASI
    // ============================================================

    /**
     * Nilai dimiliki oleh satu Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Nilai dimiliki oleh satu Mata Pelajaran
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Nilai diinput oleh satu Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}