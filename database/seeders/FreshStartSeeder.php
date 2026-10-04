<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Anggota;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FreshStartSeeder extends Seeder
{
    public function run(): void
    {
        // ================================================================
        // 1. Hapus semua data — urutan sesuai foreign key (child dulu)
        // ================================================================
        DB::table('keuangans')->delete();
        DB::table('absensis')->delete();
        DB::table('kegiatans')->delete();
        DB::table('pengumumans')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('anggotas')->delete();
        DB::table('users')->delete();

        // ================================================================
        // 2. Reset role & permission (biarkan tetap ada)
        // ================================================================
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat roles jika belum ada
        $roles = ['admin', 'Ketua', 'Sekretaris', 'Bendahara', 'Anggota'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r, 'guard_name' => 'web']);
        }

        // ================================================================
        // 3. Buat hanya 1 akun admin untuk login
        // ================================================================
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@karangtaruna.org',
            'password' => Hash::make('password'),
            'phone'    => '081234567890',
        ]);
        $admin->assignRole('admin');

        $this->command->info('✓ Semua data dummy berhasil dihapus.');
        $this->command->info('✓ Akun admin dibuat ulang:');
        $this->command->info('  Email    : admin@karangtaruna.org');
        $this->command->info('  Password : password');
        $this->command->info('  Silakan ubah password setelah login pertama.');
    }
}
