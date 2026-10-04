<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah tipe kolom status menjadi varchar dan tanggal_bergabung menjadi nullable jika menggunakan pgsql
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE anggotas ALTER COLUMN status TYPE VARCHAR(50) USING status::text;");
            DB::statement("ALTER TABLE anggotas ALTER COLUMN status SET DEFAULT 'pending';");
            DB::statement("ALTER TABLE anggotas ALTER COLUMN tanggal_bergabung DROP NOT NULL;");
        }

        // 2. Tambah kolom baru untuk alur pendaftaran dan wawancara
        Schema::table('anggotas', function (Blueprint $table) {
            if (!Schema::hasColumn('anggotas', 'email')) {
                $table->string('email')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('anggotas', 'alasan_bergabung')) {
                $table->text('alasan_bergabung')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('anggotas', 'tanggal_wawancara')) {
                $table->dateTime('tanggal_wawancara')->nullable()->after('status');
            }
            if (!Schema::hasColumn('anggotas', 'lokasi_wawancara')) {
                $table->string('lokasi_wawancara')->nullable()->after('tanggal_wawancara');
            }
            if (!Schema::hasColumn('anggotas', 'catatan_wawancara')) {
                $table->text('catatan_wawancara')->nullable()->after('lokasi_wawancara');
            }
        });

        // 3. Update existing anggotas agar kolom email terisi dari tabel users jika ada
        DB::statement("UPDATE anggotas SET email = users.email FROM users WHERE anggotas.user_id = users.id AND (anggotas.email IS NULL OR anggotas.email = '');");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'alasan_bergabung',
                'tanggal_wawancara',
                'lokasi_wawancara',
                'catatan_wawancara',
            ]);
        });
    }
};
