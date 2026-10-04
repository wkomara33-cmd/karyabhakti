<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Anggota permissions
            'anggota.view',
            'anggota.create',
            'anggota.edit',
            'anggota.delete',
            
            // Kegiatan permissions
            'kegiatan.view',
            'kegiatan.create',
            'kegiatan.edit',
            'kegiatan.delete',
            'kegiatan.rsvp',
            'kegiatan.absen',
            
            // Keuangan permissions
            'keuangan.view',
            'keuangan.create',
            'keuangan.edit',
            'keuangan.delete',
            'keuangan.export',
            
            // Pengumuman permissions
            'pengumuman.view',
            'pengumuman.create',
            'pengumuman.edit',
            'pengumuman.delete',

            // User management
            'users.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $ketuaRole = Role::firstOrCreate(['name' => 'Ketua', 'guard_name' => 'web']);
        $ketuaRole->syncPermissions(Permission::all());

        $sekretarisRole = Role::firstOrCreate(['name' => 'Sekretaris', 'guard_name' => 'web']);
        $sekretarisRole->syncPermissions([
            'anggota.view', 'anggota.create', 'anggota.edit',
            'kegiatan.view', 'kegiatan.create', 'kegiatan.edit', 'kegiatan.absen', 'kegiatan.rsvp',
            'pengumuman.view', 'pengumuman.create', 'pengumuman.edit', 'pengumuman.delete',
            'keuangan.view',
        ]);

        $bendaharaRole = Role::firstOrCreate(['name' => 'Bendahara', 'guard_name' => 'web']);
        $bendaharaRole->syncPermissions([
            'anggota.view',
            'kegiatan.view', 'kegiatan.rsvp',
            'keuangan.view', 'keuangan.create', 'keuangan.edit', 'keuangan.delete', 'keuangan.export',
            'pengumuman.view',
        ]);

        $anggotaRole = Role::firstOrCreate(['name' => 'Anggota', 'guard_name' => 'web']);
        $anggotaRole->syncPermissions([
            'anggota.view',
            'kegiatan.view',
            'kegiatan.rsvp',
            'keuangan.view',
            'pengumuman.view',
        ]);
    }
}
