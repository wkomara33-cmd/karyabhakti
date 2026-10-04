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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->string('kategori');
            $table->text('keterangan');
            $table->decimal('saldo_setelahnya', 15, 2)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('bukti_transaksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
