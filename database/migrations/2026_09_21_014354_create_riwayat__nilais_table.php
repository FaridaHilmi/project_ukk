<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('riwayat_nilai', function (Blueprint $table) {
        $table->id('riwayat_id');
        $table->unsignedBigInteger('siswa_id');
        $table->unsignedBigInteger('guru_id');
        $table->unsignedBigInteger('mapel_id');
        $table->string('semester');
        $table->string('tahun_ajaran');
        $table->decimal('nilai', 5, 2);
        $table->text('keterangan')->nullable();
        
        // Relasi
        $table->foreign('siswa_id')->references('siswa_id')->on('siswa')->onDelete('cascade');
        $table->foreign('guru_id')->references('guru_id')->on('guru')->onDelete('cascade');
        $table->foreign('mapel_id')->references('mapel_id')->on('mata_pelajaran')->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat__nilais');
    }
};
