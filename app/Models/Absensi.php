<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ============================================================
    // RELASI
    // ============================================================

    /**
     * Absensi dimiliki oleh satu Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // ============================================================
    // SCOPES — Query helper
    // ============================================================

    /**
     * Filter absensi berdasarkan status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Filter absensi pada tanggal tertentu
     */
    public function scopeTanggal($query, string $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    /**
     * Filter absensi dalam rentang bulan tertentu
     */
    public function scopeBulan($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)
                     ->whereYear('tanggal', $tahun);
    }
}
