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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi');
            $table->dateTime('tanggal');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('lokasi');
            $table->enum('status', ['akan_datang', 'berlangsung', 'selesai', 'dibatalkan'])->default('akan_datang');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
