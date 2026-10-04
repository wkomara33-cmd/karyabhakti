<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;
use App\Models\User;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        $pengumumans = [
            [
                'judul' => 'Pemberitahuan Wajib Rapat Koordinasi Persiapan Turnamen Voli',
                'konten' => "Diberitahukan kepada seluruh pengurus dan anggota Karang Taruna Karya Bhakti bahwa rapat koordinasi final pembentukan panitia pelaksana Turnamen Bola Voli akan dilaksanakan pada:\n\n📅 Hari/Tanggal: Sabtu Malam, Pukul 19.30 WIB\n📍 Lokasi: Balai Pertemuan RW 04\n\nKehadiran seluruh anggota sangat diharapkan demi kelancaran dan kesuksesan agenda akbar kita. Mohon hadir tepat waktu.",
                'kategori' => 'Rapat & Organisasi',
                'prioritas' => 'mendesak',
                'is_aktif' => true,
                'user_id' => $admin->id,
            ],
            [
                'judul' => 'Pendaftaran Peserta Workshop Digital Marketing Telah Dibuka',
                'konten' => "Kabar gembira! Bagi rekan-rekan pemuda yang memiliki rintisan usaha atau ingin mengasah skill pembuatan konten promosi di media sosial, segera daftarkan diri pada Workshop Digital Marketing Karang Taruna. Kuota terbatas untuk 30 peserta pertama.",
                'kategori' => 'Pelatihan & Pengembangan',
                'prioritas' => 'penting',
                'is_aktif' => true,
                'user_id' => $admin->id,
            ],
            [
                'judul' => 'Pengingat Pembayaran Iuran Wajib Bulanan Periode Berjalan',
                'konten' => "Mengingatkan kembali kepada seluruh rekan anggota untuk menyelesaikan iuran kas bulanan sebesar Rp 15.000,- yang dapat disetorkan langsung ke Bendahara atau melalui transfer qris bendahara. Terima kasih atas partisipasi aktif rekan-rekan.",
                'kategori' => 'Keuangan & Kas',
                'prioritas' => 'biasa',
                'is_aktif' => true,
                'user_id' => $admin->id,
            ],
        ];

        foreach ($pengumumans as $p) {
            Pengumuman::create($p);
        }
    }
}
