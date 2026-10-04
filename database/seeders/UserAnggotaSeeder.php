<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class UserAnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya Bendahara untuk sistem pencatatan keuangan
        $bendaharaUser = User::firstOrCreate(
            ['email' => 'bendahara@karangtaruna.org'],
            [
                'name' => 'Bendahara',
                'password' => Hash::make('bendahara123'),
                'phone' => '085712345678',
            ]
        );
        $bendaharaUser->assignRole('Bendahara');

        Anggota::firstOrCreate(
            ['nik' => '3201012501000003'],
            [
                'user_id' => $bendaharaUser->id,
                'nama' => 'Bendahara',
                'alamat' => 'Jl. Mawar Melati No. 88, RT 02/RW 04',
                'no_hp' => '085712345678',
                'tanggal_lahir' => '2000-01-25',
                'jabatan' => 'Bendahara',
                'status' => 'aktif',
                'tanggal_bergabung' => '2021-03-10',
                'jenis_kelamin' => 'L',
            ]
        );
    }
}
