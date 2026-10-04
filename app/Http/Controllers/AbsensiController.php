<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    /**
     * Anggota melakukan konfirmasi kehadiran (RSVP)
     */
    public function rsvp(Request $request, Kegiatan $kegiatan)
    {
        $user = Auth::user();
        $anggota = $user->anggota;

        if (!$anggota) {
            return back()->with('error', 'Akun Anda belum terhubung dengan data profil anggota.');
        }

        $validated = $request->validate([
            'konfirmasi_kehadiran' => ['required', 'in:hadir,tidak_hadir'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        Absensi::updateOrCreate(
            [
                'kegiatan_id' => $kegiatan->id,
                'anggota_id' => $anggota->id,
            ],
            [
                'konfirmasi_kehadiran' => $validated['konfirmasi_kehadiran'],
                'waktu_konfirmasi' => now(),
                'catatan' => $validated['catatan'] ?? null,
            ]
        );

        $statusText = $validated['konfirmasi_kehadiran'] === 'hadir' ? 'Akan Hadir' : 'Tidak Bisa Hadir';

        return back()->with('success', "Konfirmasi kehadiran berhasil dicatat: {$statusText}.");
    }

    /**
     * Admin melakukan update status absensi manual untuk 1 anggota
     */
    public function updateStatus(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status_kehadiran' => ['required', 'in:hadir,tidak_hadir,izin,belum_absen'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $absensi->update([
            'status_kehadiran' => $validated['status_kehadiran'],
            'waktu_absensi' => in_array($validated['status_kehadiran'], ['hadir', 'izin']) ? now() : null,
            'catatan' => $validated['catatan'] ?? $absensi->catatan,
        ]);

        return back()->with('success', "Status absensi {$absensi->anggota->nama} berhasil diubah menjadi " . ucfirst(str_replace('_', ' ', $validated['status_kehadiran'])) . ".");
    }

    /**
     * Admin batch update seluruh absensi kegiatan sekaligus
     */
    public function batchUpdate(Request $request, Kegiatan $kegiatan)
    {
        $attendances = $request->input('attendances', []);

        foreach ($attendances as $absensiId => $data) {
            $absensi = Absensi::where('id', $absensiId)
                ->where('kegiatan_id', $kegiatan->id)
                ->first();

            if ($absensi && isset($data['status_kehadiran'])) {
                $status = $data['status_kehadiran'];
                $catatan = $data['catatan'] ?? null;

                $absensi->update([
                    'status_kehadiran' => $status,
                    'waktu_absensi' => in_array($status, ['hadir', 'izin']) ? ($absensi->waktu_absensi ?? now()) : null,
                    'catatan' => $catatan,
                ]);
            }
        }

        return back()->with('success', 'Semua status absensi berhasil diperbarui secara serentak.');
    }

    /**
     * Export Rekap Kehadiran Kegiatan ke PDF
     */
    public function exportPdf(Kegiatan $kegiatan)
    {
        $kegiatan->load(['absensis.anggota' => function ($q) {
            $q->orderBy('nama', 'asc');
        }]);

        $absensis = $kegiatan->absensis->sortBy('anggota.nama');

        $stats = [
            'total_anggota' => $absensis->count(),
            'hadir' => $absensis->where('status_kehadiran', 'hadir')->count(),
            'izin' => $absensis->where('status_kehadiran', 'izin')->count(),
            'tidak_hadir' => $absensis->where('status_kehadiran', 'tidak_hadir')->count(),
            'belum_absen' => $absensis->where('status_kehadiran', 'belum_absen')->count(),
            'rsvp_hadir' => $absensis->where('konfirmasi_kehadiran', 'hadir')->count(),
        ];

        $pdf = Pdf::loadView('pdf.rekap-absensi', compact('kegiatan', 'absensis', 'stats'))
            ->setPaper('a4', 'portrait');

        $fileName = 'rekap-absensi-' . \Illuminate\Support\Str::slug($kegiatan->nama_kegiatan) . '-' . date('Ymd') . '.pdf';

        return $pdf->stream($fileName);
    }
}
