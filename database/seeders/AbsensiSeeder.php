<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use App\Models\Anggota;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatans = Kegiatan::all();
        $anggotas = Anggota::where('status', 'aktif')->get();

        foreach ($kegiatans as $kegiatan) {
            foreach ($anggotas as $index => $anggota) {
                if ($kegiatan->status === 'selesai') {
                    // Berikan variasi status kehadiran untuk kegiatan lampau
                    if ($index % 5 === 0) {
                        $status = 'izin';
                        $catatan = 'Izin ada keperluan mendadak keluarga';
                        $waktu = $kegiatan->tanggal->copy()->addMinutes(10);
                        $konfirmasi = 'tidak_hadir';
                    } elseif ($index % 7 === 0) {
                        $status = 'tidak_hadir';
                        $catatan = 'Tanpa keterangan';
                        $waktu = null;
                        $konfirmasi = 'tidak_hadir';
                    } else {
                        $status = 'hadir';
                        $catatan = 'Hadir tepat waktu';
                        $waktu = $kegiatan->tanggal->copy()->addMinutes(rand(5, 30));
                        $konfirmasi = 'hadir';
                    }

                    Absensi::firstOrCreate(
                        [
                            'kegiatan_id' => $kegiatan->id,
                            'anggota_id' => $anggota->id,
                        ],
                        [
                            'konfirmasi_kehadiran' => $konfirmasi,
                            'status_kehadiran' => $status,
                            'waktu_konfirmasi' => $kegiatan->tanggal->copy()->subDays(2),
                            'waktu_absensi' => $waktu,
                            'catatan' => $catatan,
                        ]
                    );
                } else {
                    // Kegiatan mendatang: sebagian sudah RSVP
                    $rsvp = match($index % 3) {
                        0 => 'hadir',
                        1 => 'tidak_hadir',
                        default => 'belum_konfirmasi',
                    };

                    Absensi::firstOrCreate(
                        [
                            'kegiatan_id' => $kegiatan->id,
                            'anggota_id' => $anggota->id,
                        ],
                        [
                            'konfirmasi_kehadiran' => $rsvp,
                            'status_kehadiran' => 'belum_absen',
                            'waktu_konfirmasi' => $rsvp !== 'belum_konfirmasi' ? Carbon::now()->subHours(rand(1, 48)) : null,
                            'waktu_absensi' => null,
                            'catatan' => $rsvp === 'tidak_hadir' ? 'Ada jadwal kuliah / kerja' : null,
                        ]
                    );
                }
            }
        }
    }
}
