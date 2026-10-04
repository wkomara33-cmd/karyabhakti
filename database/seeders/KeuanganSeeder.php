<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;
use App\Models\User;
use Carbon\Carbon;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $bendahara = User::where('email', 'bendahara@karangtaruna.org')->first() ?? User::first();

        $transaksiData = [
            [
                'tipe' => 'pemasukan',
                'tanggal' => Carbon::now(),
                'jumlah' => 5600000,
                'kategori' => 'Dana Kas Masuk',
                'keterangan' => 'Saldo awal Karang Taruna',
            ],
        ];

        foreach ($transaksiData as $tx) {
            $tx['user_id'] = $bendahara->id;
            Keuangan::create($tx);
        }
    }
}
