<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Absensi;
use App\Mail\UndanganWawancaraMail;
use App\Mail\PendaftaranDisetujuiMail;
use App\Mail\PendaftaranDitolakMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar anggota dengan fitur Search & Filter Status / Jabatan
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status', 'all'),
            'jabatan' => $request->input('jabatan', 'all'),
        ];

        $anggotas = Anggota::filter($filters)
            ->with('user')
            ->orderByRaw("
                CASE status 
                    WHEN 'pending' THEN 1 
                    WHEN 'interview' THEN 2 
                    WHEN 'aktif' THEN 3 
                    WHEN 'nonaktif' THEN 4 
                    WHEN 'ditolak' THEN 5 
                    ELSE 6 
                END ASC
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Anggota::count(),
            'pending' => Anggota::where('status', 'pending')->count(),
            'interview' => Anggota::where('status', 'interview')->count(),
            'aktif' => Anggota::where('status', 'aktif')->count(),
            'nonaktif' => Anggota::where('status', 'nonaktif')->count(),
            'ditolak' => Anggota::where('status', 'ditolak')->count(),
        ];

        $jabatanList = Anggota::select('jabatan')->whereNotNull('jabatan')->distinct()->pluck('jabatan');

        return view('anggota.index', compact('anggotas', 'filters', 'stats', 'jabatanList'));
    }

    /**
     * Form tambah anggota baru secara manual oleh Admin
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Simpan data anggota baru oleh Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:anggotas,email', 'unique:users,email'],
            'nik' => ['required', 'digits:16', 'unique:anggotas,nik'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'jabatan' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:pending,interview,aktif,nonaktif,ditolak'],
            'tanggal_bergabung' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            
            // Opsi pembuatan akun login
            'create_user' => ['nullable', 'boolean'],
            'password' => ['nullable', 'required_if:create_user,1', 'min:6'],
            'role' => ['nullable', 'string', 'in:admin,Anggota,Ketua,Sekretaris,Bendahara'],
        ], [
            'nik.digits' => 'NIK harus berjumlah 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
        ]);

        $userId = null;

        // Jika dicentang buat akun user
        if ($request->boolean('create_user')) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['no_hp'],
            ]);

            $role = $validated['role'] ?? 'Anggota';
            $user->assignRole($role);
            $userId = $user->id;
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('avatars/anggota', 'public');
        }

        $anggota = Anggota::create([
            'user_id' => $userId,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jabatan' => $validated['jabatan'],
            'status' => $validated['status'],
            'tanggal_bergabung' => $validated['tanggal_bergabung'] ?? ($validated['status'] === 'aktif' ? now() : null),
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail profil anggota, verifikasi wawancara, dan riwayat kehadiran
     */
    public function show(Anggota $anggota)
    {
        $anggota->load(['user.roles', 'absensis.kegiatan']);

        $riwayatAbsensi = $anggota->absensis()
            ->with('kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalKegiatanSelesai = Kegiatan::where('status', 'selesai')->count();
        $hadirCount = $anggota->absensis()->where('status_kehadiran', 'hadir')->count();
        $izinCount = $anggota->absensis()->where('status_kehadiran', 'izin')->count();
        $tidakHadirCount = $anggota->absensis()->where('status_kehadiran', 'tidak_hadir')->count();

        return view('anggota.show', compact(
            'anggota',
            'riwayatAbsensi',
            'totalKegiatanSelesai',
            'hadirCount',
            'izinCount',
            'tidakHadirCount'
        ));
    }

    /**
     * Tahap 1 Verifikasi: Panggil Wawancara (Kirim email jadwal & ubah status jadi 'interview')
     */
    public function panggilWawancara(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'tanggal_wawancara' => ['required', 'date', 'after:now'],
            'lokasi_wawancara' => ['required', 'string', 'max:255'],
            'catatan_wawancara' => ['nullable', 'string'],
        ], [
            'tanggal_wawancara.after' => 'Jadwal wawancara harus berada di masa mendatang.',
            'lokasi_wawancara.required' => 'Lokasi wawancara wajib diisi.',
        ]);

        $anggota->update([
            'tanggal_wawancara' => $validated['tanggal_wawancara'],
            'lokasi_wawancara' => $validated['lokasi_wawancara'],
            'catatan_wawancara' => $validated['catatan_wawancara'] ?? null,
            'status' => 'interview', // Menunggu Wawancara
        ]);

        // Otomatis kirim email undangan wawancara
        if ($anggota->email) {
            try {
                Mail::to($anggota->email)->send(new UndanganWawancaraMail($anggota));
                $emailNote = "Email undangan wawancara berhasil dikirim ke {$anggota->email}.";
            } catch (\Throwable $e) {
                Log::error("Gagal mengirim email wawancara ke {$anggota->email}: " . $e->getMessage());
                $emailNote = "Jadwal tersimpan, namun pengiriman email mengalami kendala.";
            }
        } else {
            $emailNote = "Jadwal tersimpan (anggota tidak memiliki email terdaftar).";
        }

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', "Undangan wawancara berhasil diproses! Status pendaftar kini 'Menunggu Wawancara'. {$emailNote}");
    }

    /**
     * Tahap 2 Verifikasi: Setujui Pendaftar (Generate User, Status Aktif, Kirim Email Kredensial)
     */
    public function setujuiPendaftaran(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'jabatan' => ['nullable', 'string', 'max:100'],
        ]);

        // 1. Tentukan email pendaftar
        $email = $anggota->email;
        if (!$email) {
            return back()->with('error', 'Pendaftar tidak memiliki alamat email. Silakan lengkapi email terlebih dahulu.');
        }

        // 2. Generate temporary password yang aman dan mudah dibaca
        $generatedPassword = 'KTKB-' . rand(1000, 9999);

        // 3. Buat atau perbarui akun User
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $anggota->nama,
                'email' => $email,
                'password' => Hash::make($generatedPassword),
                'phone' => $anggota->no_hp,
            ]);
            $user->assignRole('Anggota');
        } else {
            $user->update([
                'password' => Hash::make($generatedPassword),
            ]);
            if (!$user->hasRole('Anggota') && !$user->isAdmin()) {
                $user->assignRole('Anggota');
            }
        }

        // 4. Update data Anggota menjadi Aktif
        $anggota->update([
            'user_id' => $user->id,
            'status' => 'aktif',
            'jabatan' => $validated['jabatan'] ?? ($anggota->jabatan ?: 'Anggota'),
            'tanggal_bergabung' => $anggota->tanggal_bergabung ?? now(),
        ]);

        // 5. Hubungkan anggota dengan kegiatan yang sedang/akan berlangsung agar bisa absen
        $kegiatans = Kegiatan::whereIn('status', ['akan_datang', 'berlangsung'])->get();
        foreach ($kegiatans as $keg) {
            Absensi::firstOrCreate(
                ['kegiatan_id' => $keg->id, 'anggota_id' => $anggota->id],
                ['konfirmasi_kehadiran' => 'belum_konfirmasi', 'status_kehadiran' => 'belum_absen']
            );
        }

        // 6. Kirim email ucapan selamat & akun login
        try {
            Mail::to($email)->send(new PendaftaranDisetujuiMail($anggota, $email, $generatedPassword));
            $emailNote = "Akun login telah dibuat dan informasi akun resmi dikirim ke {$email}.";
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim email aktivasi ke {$email}: " . $e->getMessage());
            $emailNote = "Akun login berhasil dibuat (Password Sementara: {$generatedPassword}), namun pengiriman email mengalami kendala.";
        }

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', "Calon anggota berhasil disetujui dan berstatus Aktif! {$emailNote}");
    }

    /**
     * Tahap 2 Verifikasi: Tolak Pendaftar (Status Ditolak, Arsipkan, Kirim Email Pemberitahuan)
     */
    public function tolakPendaftaran(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'alasan_penolakan' => ['nullable', 'string'],
        ]);

        $alasan = $validated['alasan_penolakan'] ?? null;

        // Status diubah menjadi ditolak, data tetap diarsipkan di DB
        $anggota->update([
            'status' => 'ditolak',
            'catatan_wawancara' => $alasan ? "Alasan Penolakan: " . $alasan : $anggota->catatan_wawancara,
        ]);

        // Kirim email pemberitahuan
        if ($anggota->email) {
            try {
                Mail::to($anggota->email)->send(new PendaftaranDitolakMail($anggota, $alasan));
                $emailNote = "Email pemberitahuan telah dikirim ke {$anggota->email}.";
            } catch (\Throwable $e) {
                Log::error("Gagal mengirim email penolakan ke {$anggota->email}: " . $e->getMessage());
                $emailNote = "Status diperbarui, namun pengiriman email mengalami kendala.";
            }
        } else {
            $emailNote = "Data telah diarsipkan.";
        }

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', "Pendaftaran calon anggota ditolak dan data tersimpan rapi sebagai arsip. {$emailNote}");
    }

    /**
     * Nonaktifkan atau Aktifkan kembali anggota yang sudah terdaftar
     */
    public function toggleStatus(Anggota $anggota)
    {
        $newStatus = $anggota->status === 'aktif' ? 'nonaktif' : 'aktif';
        $anggota->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan kembali' : 'dinonaktifkan';

        return back()->with('success', "Status anggota {$anggota->nama} berhasil {$statusText}.");
    }

    /**
     * Form edit anggota
     */
    public function edit(Anggota $anggota)
    {
        $anggota->load('user');
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update data anggota
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('anggotas')->ignore($anggota->id)],
            'nik' => ['required', 'digits:16', Rule::unique('anggotas')->ignore($anggota->id)],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'jabatan' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:pending,interview,aktif,nonaktif,ditolak'],
            'tanggal_bergabung' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($anggota->foto && Storage::disk('public')->exists($anggota->foto)) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validated['foto'] = $request->file('foto')->store('avatars/anggota', 'public');
        }

        $anggota->update($validated);

        // Update data di user jika ada
        if ($anggota->user) {
            $anggota->user->update([
                'name' => $validated['nama'],
                'phone' => $validated['no_hp'],
                'email' => $validated['email'] ?? $anggota->user->email,
            ]);
        }

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Hapus anggota
     */
    public function destroy(Anggota $anggota)
    {
        if ($anggota->foto && Storage::disk('public')->exists($anggota->foto)) {
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
