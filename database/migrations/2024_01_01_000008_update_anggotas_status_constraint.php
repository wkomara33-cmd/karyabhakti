<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE anggotas DROP CONSTRAINT IF EXISTS anggotas_status_check;");
            DB::statement("ALTER TABLE anggotas ADD CONSTRAINT anggotas_status_check CHECK (status::text IN ('pending', 'interview', 'aktif', 'nonaktif', 'ditolak'));");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE anggotas DROP CONSTRAINT IF EXISTS anggotas_status_check;");
        }
    }
};
