<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kegiatan;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Halaman Publik Utama (Landing Page)
     */
    public function landing()
    {
        $kegiatanTerbaru = Kegiatan::whereIn('status', ['akan_datang', 'berlangsung'])
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        $pengumumanTerbaru = Pengumuman::where('is_aktif', true)
            ->orderByRaw("CASE prioritas WHEN 'mendesak' THEN 1 WHEN 'penting' THEN 2 ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $totalAnggotaAktif = Anggota::where('status', 'aktif')->count();
        $totalKegiatanSelesai = Kegiatan::where('status', 'selesai')->count();

        return view('landing', compact(
            'kegiatanTerbaru',
            'pengumumanTerbaru',
            'totalAnggotaAktif',
            'totalKegiatanSelesai'
        ));
    }

    /**
     * Halaman Form Pendaftaran Mandiri
     */
    public function showForm()
    {
        return view('pendaftaran.create');
    }

    /**
     * Proses Submit Form Pendaftaran Calon Anggota
     */
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:anggotas,nik'],
            'email' => ['required', 'email', 'max:255', 'unique:anggotas,email', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alasan_bergabung' => ['required', 'string', 'min:10'],
        ], [
            'nik.digits' => 'Nomor Induk Kependudukan (NIK) harus terdiri dari tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'alasan_bergabung.min' => 'Mohon jelaskan alasan Anda bergabung minimal 10 karakter.',
        ]);

        $anggota = Anggota::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alasan_bergabung' => $validated['alasan_bergabung'],
            'jabatan' => 'Anggota',
            'status' => 'pending', // Menunggu Peninjauan
            'tanggal_bergabung' => null,
        ]);

        return redirect()->route('pendaftaran.sukses', $anggota->id);
    }

    /**
     * Tampilan Konfirmasi Sukses Pendaftaran
     */
    public function sukses(Anggota $anggota)
    {
        return view('pendaftaran.sukses', compact('anggota'));
    }
}
