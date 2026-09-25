<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'no_hp',
    ];

    // ============================================================
    // RELASI
    // ============================================================

    /**
     * Guru dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Guru memberikan banyak Nilai
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'guru_id');
    }

    /**
     * Guru mencatat banyak Absensi (opsional, jika guru_id ditambahkan kembali)
     */
    // public function absensi()
    // {
    //     return $this->hasMany(Absensi::class, 'guru_id');
    // }
}