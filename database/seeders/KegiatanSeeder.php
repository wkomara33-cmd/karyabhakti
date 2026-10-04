<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        $kegiatans = [
            [
                'nama_kegiatan' => 'Kerja Bakti Lingkungan & Penghijauan RW 04',
                'deskripsi' => 'Aksi bersih-bersih saluran air, pemangkasan rumput liar, dan penanaman 50 bibit pohon tabebuya di sepanjang jalan utama RW 04 bersama seluruh pemuda dan warga.',
                'tanggal' => Carbon::now()->subDays(14)->setTime(7, 30),
                'tanggal_selesai' => Carbon::now()->subDays(14)->setTime(11, 30),
                'lokasi' => 'Lapangan Utama RW 04 Sukamaju',
                'status' => 'selesai',
                'created_by' => $admin->id,
            ],
            [
                'nama_kegiatan' => 'Rapat Koordinasi Bulanan & Evaluasi Program Kerja',
                'deskripsi' => 'Pembahasan laporan pertanggungjawaban kas bulan lalu, persiapan turnamen olahraga kemerdekaan, dan penyusunan panitia peringatan HUT Karang Taruna.',
                'tanggal' => Carbon::now()->subDays(4)->setTime(19, 30),
                'tanggal_selesai' => Carbon::now()->subDays(4)->setTime(22, 00),
                'lokasi' => 'Balai Pertemuan Warga RW 04',
                'status' => 'selesai',
                'created_by' => $admin->id,
            ],
            [
                'nama_kegiatan' => 'Workshop Digital Marketing & Desain Konten Pemuda',
                'deskripsi' => 'Pelatihan praktis pembuatan konten promosi usaha mikro dan optimalisasi media sosial bagi pemuda-pemudi Karang Taruna oleh narasumber praktisi digital agency.',
                'tanggal' => Carbon::now()->addDays(5)->setTime(9, 00),
                'tanggal_selesai' => Carbon::now()->addDays(5)->setTime(15, 00),
                'lokasi' => 'Aula Serbaguna Kelurahan Sukamaju',
                'status' => 'akan_datang',
                'created_by' => $admin->id,
            ],
            [
                'nama_kegiatan' => 'Turnamen Bola Voli Antar-RT Piala Bhakti Pemuda',
                'deskripsi' => 'Kompetisi olahraga voli persahabatan antar pemuda RT se-RW 04 guna mempererat tali silaturahmi, sportivitas, dan menjaring bibit atlet berbakat.',
                'tanggal' => Carbon::now()->addDays(12)->setTime(15, 30),
                'tanggal_selesai' => Carbon::now()->addDays(14)->setTime(18, 00),
                'lokasi' => 'Lapangan Voli Karang Taruna Karya Bhakti',
                'status' => 'akan_datang',
                'created_by' => $admin->id,
            ],
            [
                'nama_kegiatan' => 'Bakti Sosial & Santunan Yatim Piatu',
                'deskripsi' => 'Penyaluran 75 paket sembako dan santunan dana pendidikan untuk anak yatim dan lansia prasejahtera di lingkungan sekitar.',
                'tanggal' => Carbon::now()->addDays(20)->setTime(8, 00),
                'tanggal_selesai' => Carbon::now()->addDays(20)->setTime(12, 00),
                'lokasi' => 'Masjid Jami Al-Ikhlas RW 04',
                'status' => 'akan_datang',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($kegiatans as $keg) {
            Kegiatan::create($keg);
        }
    }
}
