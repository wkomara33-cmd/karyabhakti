<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Anggota;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Tampilkan daftar kegiatan
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');

        $query = Kegiatan::query()->withCount([
            'absensis as total_rsvpd' => fn($q) => $q->where('konfirmasi_kehadiran', 'hadir'),
            'absensis as total_hadir' => fn($q) => $q->where('status_kehadiran', 'hadir'),
        ]);

        if ($status !== 'all' && in_array($status, ['akan_datang', 'berlangsung', 'selesai', 'dibatalkan'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $kegiatans = $query->orderBy('tanggal', 'desc')->paginate(9)->withQueryString();

        $stats = [
            'total' => Kegiatan::count(),
            'akan_datang' => Kegiatan::where('status', 'akan_datang')->count(),
            'berlangsung' => Kegiatan::where('status', 'berlangsung')->count(),
            'selesai' => Kegiatan::where('status', 'selesai')->count(),
        ];

        return view('kegiatan.index', compact('kegiatans', 'stats', 'status', 'search'));
    }

    /**
     * Form tambah kegiatan
     */
    public function create()
    {
        return view('kegiatan.create');
    }

    /**
     * Simpan kegiatan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal'],
            'lokasi' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:akan_datang,berlangsung,selesai,dibatalkan'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners/kegiatan', 'public');
        }

        $validated['created_by'] = Auth::id();

        $kegiatan = Kegiatan::create($validated);

        // Secara otomatis buat entri absensi default untuk semua anggota yang aktif
        $anggotaAktif = Anggota::where('status', 'aktif')->get();
        foreach ($anggotaAktif as $anggota) {
            Absensi::firstOrCreate(
                [
                    'kegiatan_id' => $kegiatan->id,
                    'anggota_id' => $anggota->id,
                ],
                [
                    'konfirmasi_kehadiran' => 'belum_konfirmasi',
                    'status_kehadiran' => 'belum_absen',
                ]
            );
        }

        return redirect()->route('kegiatan.show', $kegiatan->id)
            ->with('success', 'Jadwal kegiatan berhasil dibuat dan daftar absensi telah disiapkan.');
    }

    /**
     * Tampilkan detail kegiatan dan form absensi
     */
    public function show(Kegiatan $kegiatan, Request $request)
    {
        // Pastikan entri absensi lengkap untuk semua anggota aktif
        $anggotaAktif = Anggota::where('status', 'aktif')->get();
        foreach ($anggotaAktif as $anggota) {
            Absensi::firstOrCreate(
                [
                    'kegiatan_id' => $kegiatan->id,
                    'anggota_id' => $anggota->id,
                ],
                [
                    'konfirmasi_kehadiran' => 'belum_konfirmasi',
                    'status_kehadiran' => 'belum_absen',
                ]
            );
        }

        $filterStatus = $request->input('filter_status', 'all');
        $filterRsvp = $request->input('filter_rsvp', 'all');
        $search = $request->input('search');

        $absensiQuery = $kegiatan->absensis()->with('anggota');

        if ($filterStatus !== 'all') {
            $absensiQuery->where('status_kehadiran', $filterStatus);
        }
        if ($filterRsvp !== 'all') {
            $absensiQuery->where('konfirmasi_kehadiran', $filterRsvp);
        }
        if ($search) {
            $absensiQuery->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $absensis = $absensiQuery->join('anggotas', 'absensis.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama', 'asc')
            ->select('absensis.*')
            ->get();

        // RSVP user login saat ini (jika login sebagai anggota)
        $userAnggota = Auth::user()->anggota;
        $userAbsensi = null;
        if ($userAnggota) {
            $userAbsensi = Absensi::where('kegiatan_id', $kegiatan->id)
                ->where('anggota_id', $userAnggota->id)
                ->first();
        }

        return view('kegiatan.show', compact('kegiatan', 'absensis', 'userAbsensi', 'filterStatus', 'filterRsvp', 'search'));
    }

    /**
     * Form edit kegiatan
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update data kegiatan
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal'],
            'lokasi' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:akan_datang,berlangsung,selesai,dibatalkan'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        if ($request->hasFile('banner')) {
            if ($kegiatan->banner && Storage::disk('public')->exists($kegiatan->banner)) {
                Storage::disk('public')->delete($kegiatan->banner);
            }
            $validated['banner'] = $request->file('banner')->store('banners/kegiatan', 'public');
        }

        $kegiatan->update($validated);

        return redirect()->route('kegiatan.show', $kegiatan->id)
            ->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus kegiatan
     */
    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->banner && Storage::disk('public')->exists($kegiatan->banner)) {
            Storage::disk('public')->delete($kegiatan->banner);
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
