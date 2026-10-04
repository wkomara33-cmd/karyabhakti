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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();
            $table->foreignId('anggota_id')->constrained('anggotas')->cascadeOnDelete();
            $table->enum('konfirmasi_kehadiran', ['hadir', 'tidak_hadir', 'belum_konfirmasi'])->default('belum_konfirmasi');
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'izin', 'belum_absen'])->default('belum_absen');
            $table->dateTime('waktu_konfirmasi')->nullable();
            $table->dateTime('waktu_absensi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['kegiatan_id', 'anggota_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
