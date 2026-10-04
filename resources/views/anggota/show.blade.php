@extends('layouts.app')

@section('title', 'Detail Data - ' . $anggota->nama)
@section('header_title', 'Detail Profil & Verifikasi')
@section('header_subtitle', 'Informasi biodata lengkap, alur verifikasi wawancara, dan rekapitulasi kehadiran')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation Breadcrumb / Action -->
    <div class="flex items-center justify-between">
        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Anggota</span>
        </a>
        <div class="flex items-center gap-2">
            @if(in_array($anggota->status, ['aktif', 'nonaktif']))
            <form action="{{ route('anggota.toggleStatus', $anggota->id) }}" method="POST" onsubmit="return confirm('Ubah status keaktifan anggota ini?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold {{ $anggota->status === 'aktif' ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' }} transition-colors">
                    {{ $anggota->status === 'aktif' ? 'Nonaktifkan Anggota' : 'Aktifkan Kembali' }}
                </button>
            </form>
            @endif

            <a href="{{ route('anggota.edit', $anggota->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Data</span>
            </a>
        </div>
    </div>

    <!-- Header Identity Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <img src="{{ $anggota->foto_url }}" alt="{{ $anggota->nama }}" 
                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl object-cover ring-4 ring-emerald-500/20 shadow-md shrink-0">
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $anggota->jabatan !== 'Anggota' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-slate-100 text-slate-700' }}">
                        {{ $anggota->jabatan ?: 'Anggota' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold border {{ $anggota->status_badge_class }}">
                        <span>{{ $anggota->status_label }}</span>
                    </span>
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $anggota->nama }}</h1>
                <p class="text-xs text-slate-500 font-medium">
                    NIK: <span class="font-mono text-slate-800 font-semibold">{{ $anggota->nik }}</span> • Usia: {{ $anggota->usia }} Tahun ({{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }})
                </p>
                <p class="text-xs text-emerald-700 font-medium">
                    ✉ {{ $anggota->email ?: ($anggota->user->email ?? 'Tidak ada email') }} • 📞 {{ $anggota->no_hp }}
                </p>
            </div>
        </div>

        @if(in_array($anggota->status, ['aktif', 'nonaktif']))
        <!-- Attendance Performance Badge for active members -->
        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 shrink-0">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center font-black text-2xl shadow-md shadow-emerald-500/20">
                {{ $anggota->tingkat_kehadiran }}%
            </div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Tingkat Kehadiran</p>
                <p class="text-xs font-bold text-slate-800 mt-0.5">{{ $hadirCount }} dari {{ $totalKegiatanSelesai }} kegiatan selesai</p>
            </div>
        </div>
        @endif
    </div>

    <!-- ======================================================== -->
    <!-- WORKFLOW TAHAP 1: PANGGIL WAWANCARA (STATUS: PENDING) -->
    <!-- ======================================================== -->
    @if($anggota->status === 'pending')
    <div class="bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-white rounded-3xl p-6 sm:p-8 border-2 border-amber-300 shadow-sm space-y-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black text-lg shadow-md shadow-amber-500/30">
                1
            </div>
            <div>
                <h3 class="text-lg font-black text-amber-950">Tahap 1 Verifikasi: Panggil Wawancara Tatap Muka</h3>
                <p class="text-xs text-amber-800 mt-0.5">Pendaftar baru ini menunggu peninjauan pengurus. Tentukan jadwal dan lokasi wawancara, lalu sistem akan otomatis mengirim email undangan.</p>
            </div>
        </div>

        <form action="{{ route('anggota.panggilWawancara', $anggota->id) }}" method="POST" class="pt-2 space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jadwal Tanggal & Waktu Wawancara <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local" name="tanggal_wawancara" required
                           value="{{ old('tanggal_wawancara', now()->addDays(2)->format('Y-m-d\T14:00')) }}"
                           class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Lokasi Wawancara Offline <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi_wawancara" required
                           value="{{ old('lokasi_wawancara', 'Sekretariat Karang Taruna Karya Bhakti (Balai Warga RW 04)') }}"
                           class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Catatan / Instruksi Khusus bagi Calon Anggota (Opsional)
                </label>
                <input type="text" name="catatan_wawancara" 
                       value="{{ old('catatan_wawancara', 'Membawa fotokopi KTP dan berpakaian rapi.') }}"
                       class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white"
                       placeholder="Contoh: Membawa fotokopi KTP...">
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-md shadow-amber-500/30 hover:shadow-amber-500/40 active:scale-95 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Kirim Undangan & Panggil Wawancara</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- WORKFLOW TAHAP 2: HASIL WAWANCARA (STATUS: INTERVIEW) -->
    <!-- ======================================================== -->
    @if($anggota->status === 'interview')
    <div class="bg-gradient-to-r from-blue-500/10 via-blue-500/5 to-white rounded-3xl p-6 sm:p-8 border-2 border-blue-300 shadow-sm space-y-6" x-data="{ decision: null }">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-lg shadow-md shadow-blue-600/30">
                2
            </div>
            <div>
                <h3 class="text-lg font-black text-blue-950">Tahap 2 Verifikasi: Putusan Hasil Wawancara</h3>
                <p class="text-xs text-blue-800 mt-0.5">Wawancara telah dijadwalkan. Setelah sesi tatap muka selesai, tentukan keputusan: <strong>Setujui</strong> (otomatis buat akun login & kirim email resmi) atau <strong>Tolak</strong> (arsipkan).</p>
            </div>
        </div>

        <!-- Detail Jadwal Wawancara Terkirim -->
        <div class="bg-white rounded-2xl p-4 border border-blue-100 text-xs flex flex-wrap gap-6 items-center">
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Jadwal Wawancara</span>
                <span class="font-bold text-slate-800 text-sm">{{ $anggota->tanggal_wawancara ? $anggota->tanggal_wawancara->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Lokasi</span>
                <span class="font-bold text-slate-800 text-sm">{{ $anggota->lokasi_wawancara ?? '-' }}</span>
            </div>
            @if($anggota->catatan_wawancara)
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Catatan</span>
                <span class="text-slate-700">{{ $anggota->catatan_wawancara }}</span>
            </div>
            @endif
        </div>

        <!-- Buttons to Choose Decision -->
        <div class="flex flex-wrap items-center gap-4">
            <button type="button" @click="decision = 'setujui'" 
                    :class="decision === 'setujui' ? 'ring-4 ring-emerald-400' : ''"
                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md shadow-emerald-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Keputusan: Setujui Jadi Anggota</span>
            </button>

            <button type="button" @click="decision = 'tolak'" 
                    :class="decision === 'tolak' ? 'ring-4 ring-rose-400' : ''"
                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md shadow-rose-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>Keputusan: Tolak Pendaftaran</span>
            </button>
        </div>

        <!-- Sub-Form: SETUJUI -->
        <div x-show="decision === 'setujui'" x-transition class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-emerald-100 pb-2">
                <h4 class="font-extrabold text-sm text-emerald-900">Konfirmasi Persetujuan Calon Anggota</h4>
                <button type="button" @click="decision = null" class="text-xs text-slate-400 hover:text-slate-600">✕ Tutup</button>
            </div>
            <p class="text-xs text-slate-600">
                Dengan menyetujui, sistem akan:
                <br>• Mengubah status menjadi <strong>"Aktif"</strong>.
                <br>• Menghasilkan akun login (User) dengan email <strong>{{ $anggota->email }}</strong> dan password acak sementara.
                <br>• Mengirimkan email ucapan selamat beserta informasi akun login ke pendaftar.
            </p>

            <form action="{{ route('anggota.setujui', $anggota->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="max-w-xs">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tentukan Jabatan / Divisi
                    </label>
                    <input type="text" name="jabatan" value="Anggota" required
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/30 transition-all">
                        Ya, Setujui & Buat Akun Resmi
                    </button>
                </div>
            </form>
        </div>

        <!-- Sub-Form: TOLAK -->
        <div x-show="decision === 'tolak'" x-transition class="p-5 rounded-2xl bg-white border border-rose-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-rose-100 pb-2">
                <h4 class="font-extrabold text-sm text-rose-900">Konfirmasi Penolakan Pendaftaran</h4>
                <button type="button" @click="decision = null" class="text-xs text-slate-400 hover:text-slate-600">✕ Tutup</button>
            </div>
            <p class="text-xs text-slate-600">
                Status akan diubah menjadi <strong>"Ditolak"</strong>. Data tetap tersimpan aman di database sebagai arsip, dan sistem akan mengirimkan email pemberitahuan yang sopan kepada calon anggota.
            </p>

            <form action="{{ route('anggota.tolak', $anggota->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alasan Penolakan / Catatan Internal (Opsional, dicantumkan dalam email)
                    </label>
                    <textarea name="alasan_penolakan" rows="2"
                              placeholder="Contoh: Kuota kepengurusan divisi saat ini telah terpenuhi, disarankan mendaftar pada kegiatan kepemudaan berikutnya."
                              class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md shadow-rose-600/30 transition-all">
                        Ya, Tolak & Arsipkan
                    </button>
                </div>
            </form>
        </div>

    </div>
    @endif

    <!-- 2 Column Layout: Details & History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Full Biodata & User Account (1 Column) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Informasi Biodata</h3>
                
                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">Email</p>
                        <p class="font-semibold text-emerald-700 text-sm mt-0.5">{{ $anggota->email ?: ($anggota->user->email ?? '-') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">No. HP / WhatsApp</p>
                        <p class="font-semibold text-slate-800 text-sm mt-0.5">{{ $anggota->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">Tanggal Lahir</p>
                        <p class="font-semibold text-slate-800 mt-0.5">{{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->isoFormat('D MMMM Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">Tanggal Bergabung</p>
                        <p class="font-semibold text-slate-800 mt-0.5">{{ $anggota->tanggal_bergabung ? $anggota->tanggal_bergabung->isoFormat('D MMMM Y') : 'Belum resmi aktif' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">Alamat Lengkap</p>
                        <p class="font-medium text-slate-700 mt-0.5 leading-relaxed">{{ $anggota->alamat }}</p>
                    </div>

                    @if($anggota->alasan_bergabung)
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-400 uppercase tracking-wider text-[10px] font-bold">Alasan Ingin Bergabung</p>
                        <p class="font-medium text-slate-700 mt-1 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">
                            {{ $anggota->alasan_bergabung }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Akun Pengguna Terkait -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Akun Login Portal</h3>
                
                @if($anggota->user)
                <div class="space-y-2.5 text-xs">
                    <div class="p-3 rounded-2xl bg-emerald-50/80 border border-emerald-100 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-emerald-900">Akun Terhubung ✓</span>
                            <span class="text-[10px] uppercase font-bold text-emerald-600 bg-white px-2 py-0.5 rounded-full border border-emerald-200">
                                {{ $anggota->user->roles->pluck('name')->first() ?? 'User' }}
                            </span>
                        </div>
                        <p class="text-emerald-700 text-[11px] font-mono">{{ $anggota->user->email }}</p>
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Pengguna dapat masuk ke portal sistem untuk melakukan RSVP kegiatan dan melihat informasi pengumuman.
                    </div>
                </div>
                @else
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <p class="text-xs text-slate-500">Belum memiliki akun login sistem.</p>
                    @if($anggota->status === 'aktif')
                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="inline-block text-xs font-bold text-emerald-600 hover:underline">
                        + Buat Akun Login Manual
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Riwayat Kehadiran Kegiatan (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Summary Stats Bar -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Hadir</p>
                    <h4 class="text-xl font-black text-emerald-600 mt-1">{{ $hadirCount }}</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Izin / Sakit</p>
                    <h4 class="text-xl font-black text-amber-500 mt-1">{{ $izinCount }}</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tidak Hadir</p>
                    <h4 class="text-xl font-black text-rose-500 mt-1">{{ $tidakHadirCount }}</h4>
                </div>
            </div>

            <!-- Attendance History Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Riwayat Kehadiran Kegiatan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar rekapitulasi keikutsertaan pada agenda Karang Taruna</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-5">Nama Kegiatan</th>
                                <th class="py-3 px-5">Tanggal</th>
                                <th class="py-3 px-5 text-center">RSVP Mandiri</th>
                                <th class="py-3 px-5 text-center">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayatAbsensi as $absensi)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 px-5 font-semibold text-slate-900">
                                    <a href="{{ route('kegiatan.show', $absensi->kegiatan_id) }}" class="hover:text-emerald-600 transition-colors">
                                        {{ $absensi->kegiatan->nama_kegiatan ?? 'Kegiatan #' . $absensi->kegiatan_id }}
                                    </a>
                                </td>
                                <td class="py-3 px-5 whitespace-nowrap text-slate-500">
                                    {{ $absensi->kegiatan ? $absensi->kegiatan->tanggal->isoFormat('D MMM Y') : '-' }}
                                </td>
                                <td class="py-3 px-5 text-center whitespace-nowrap">
                                    @if($absensi->konfirmasi_kehadiran === 'hadir')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Akan Hadir</span>
                                    @elseif($absensi->konfirmasi_kehadiran === 'tidak_hadir')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Tidak Hadir</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Belum Konfirmasi</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-center whitespace-nowrap">
                                    @if($absensi->status_kehadiran === 'hadir')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">✓ Hadir</span>
                                    @elseif($absensi->status_kehadiran === 'izin')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Izin</span>
                                    @elseif($absensi->status_kehadiran === 'tidak_hadir')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">✕ Tidak Hadir</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">Belum Absen</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    Belum ada catatan riwayat kegiatan untuk anggota ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riwayatAbsensi->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $riwayatAbsensi->links() }}
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
