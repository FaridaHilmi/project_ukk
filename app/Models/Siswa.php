<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nis',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
    ];

    // ============================================================
    // RELASI
    // ============================================================

    /**
     * Siswa dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Siswa terdaftar di satu Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Siswa memiliki banyak Nilai
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    /**
     * Siswa memiliki banyak Absensi
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}