@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', $kegiatan->nama_kegiatan)

@section('content')
<div class="space-y-6">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center space-x-2">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium">
        {{ session('error') }}
    </div>
    @endif

    <!-- Header Back & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('kegiatan.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center space-x-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $kegiatan->status_badge_class }}">
                        {{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}
                    </span>
                    <span class="text-xs text-slate-400">Dibuat oleh {{ $kegiatan->pembuat->name ?? 'Admin' }}</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $kegiatan->nama_kegiatan }}</h1>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('absensi.exportPdf', $kegiatan->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold rounded-xl hover:bg-rose-100 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF Absensi
            </a>
            <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Kegiatan
            </a>
            <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini? Semua data absensi terkait akan ikut terhapus.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white text-sm font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-sm shadow-rose-600/20">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Main Detail & Stats Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Event Detail (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                @if($kegiatan->banner)
                <div class="w-full h-56 bg-slate-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $kegiatan->banner) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 mb-2">Deskripsi Kegiatan</h2>
                        <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $kegiatan->deskripsi }}</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-400">Waktu Pelaksanaan</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $kegiatan->tanggal->isoFormat('dddd, D MMMM Y') }}</p>
                                <p class="text-xs text-slate-500">Pukul {{ $kegiatan->tanggal->format('H:i') }} WIB@if($kegiatan->tanggal_selesai) s/d {{ $kegiatan->tanggal_selesai->format('H:i') }} WIB@endif</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-400">Lokasi Acara</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $kegiatan->lokasi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RSVP Anggota -->
            @if(auth()->user()->anggota)
            <div class="bg-gradient-to-br from-emerald-900 to-slate-900 text-white rounded-2xl p-6 shadow-xl">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-1">Konfirmasi Kehadiran Anda</p>
                        <h3 class="text-lg font-bold">Apakah Anda akan hadir di kegiatan ini?</h3>
                        <p class="text-sm text-slate-300 mt-1">
                            Status saat ini:
                            <strong class="text-emerald-300">{{ $userAbsensi ? ucfirst(str_replace('_', ' ', $userAbsensi->konfirmasi_kehadiran)) : 'Belum Konfirmasi' }}</strong>
                        </p>
                    </div>
                    <form action="{{ route('absensi.rsvp', $kegiatan->id) }}" method="POST" class="flex flex-wrap gap-3">
                        @csrf
                        <button type="submit" name="konfirmasi_kehadiran" value="hadir" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm transition-all shadow-lg shadow-emerald-500/30 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Saya Akan Hadir</span>
                        </button>
                        <button type="submit" name="konfirmasi_kehadiran" value="tidak_hadir" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold text-sm transition-all flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>Tidak Bisa Hadir</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Stats Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Ringkasan Kehadiran</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-center">
                        <p class="text-2xl font-extrabold text-emerald-700">{{ $kegiatan->jumlah_hadir }}</p>
                        <p class="text-xs font-semibold text-emerald-800 mt-1">Hadir Fisik</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-100 text-center">
                        <p class="text-2xl font-extrabold text-amber-700">{{ $kegiatan->jumlah_izin }}</p>
                        <p class="text-xs font-semibold text-amber-800 mt-1">Izin / Sakit</p>
                    </div>
                    <div class="p-3 rounded-xl bg-rose-50 border border-rose-100 text-center">
                        <p class="text-2xl font-extrabold text-rose-700">{{ $kegiatan->jumlah_tidak_hadir }}</p>
                        <p class="text-xs font-semibold text-rose-800 mt-1">Tidak Hadir</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 text-center">
                        <p class="text-2xl font-extrabold text-blue-700">{{ $kegiatan->jumlah_rsvp_hadir }}</p>
                        <p class="text-xs font-semibold text-blue-800 mt-1">RSVP Hadir</p>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold text-slate-600">
                        <span>Partisipasi</span>
                        <span>{{ $kegiatan->persentase_kehadiran }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full" style="width: {{ $kegiatan->persentase_kehadiran }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ q: '{{ $search ?? '' }}' }">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Absensi Anggota</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $absensis->count() }} anggota terdaftar</p>
            </div>

            <!-- Filter -->
            <form method="GET" action="{{ route('kegiatan.show', $kegiatan->id) }}" class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari anggota..." class="pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 w-44">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <select name="filter_status" class="text-xs rounded-xl border border-slate-200 py-1.5 px-2.5 focus:ring-2 focus:ring-emerald-500">
                    <option value="all" {{ ($filterStatus ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="hadir" {{ ($filterStatus ?? '') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ ($filterStatus ?? '') === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="tidak_hadir" {{ ($filterStatus ?? '') === 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="belum_absen" {{ ($filterStatus ?? '') === 'belum_absen' ? 'selected' : '' }}>Belum Absen</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-xl hover:bg-slate-800 transition-colors">Filter</button>
                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-200 transition-colors">Reset</a>
            </form>
        </div>

        @if(auth()->user()->isAdmin())
        <form action="{{ route('absensi.batchUpdate', $kegiatan->id) }}" method="POST">
            @csrf
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <th class="py-3 px-5">Anggota</th>
                        <th class="py-3 px-4">Jabatan</th>
                        <th class="py-3 px-4">RSVP</th>
                        <th class="py-3 px-4">Status Absensi</th>
                        <th class="py-3 px-4">Waktu Absensi</th>
                        <th class="py-3 px-5">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensis as $absensi)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3 px-5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ mb_substr($absensi->anggota->nama ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 text-xs">{{ $absensi->anggota->nama ?? '-' }}</p>
                                    <p class="text-xs text-slate-400">{{ $absensi->anggota->nik ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-600">{{ $absensi->anggota->jabatan ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $absensi->konfirmasi_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $absensi->konfirmasi_kehadiran)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if(auth()->user()->isAdmin())
                            <select name="attendances[{{ $absensi->id }}][status_kehadiran]" class="text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-2 focus:ring-emerald-500">
                                <option value="belum_absen" {{ $absensi->status_kehadiran == 'belum_absen' ? 'selected' : '' }}>⚪ Belum Absen</option>
                                <option value="hadir" {{ $absensi->status_kehadiran == 'hadir' ? 'selected' : '' }}>🟢 Hadir</option>
                                <option value="izin" {{ $absensi->status_kehadiran == 'izin' ? 'selected' : '' }}>🟡 Izin</option>
                                <option value="tidak_hadir" {{ $absensi->status_kehadiran == 'tidak_hadir' ? 'selected' : '' }}>🔴 Tidak Hadir</option>
                            </select>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $absensi->status_kehadiran_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $absensi->status_kehadiran)) }}
                            </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-500">
                            {{ $absensi->waktu_absensi ? $absensi->waktu_absensi->isoFormat('D MMM, HH:mm') : '-' }}
                        </td>
                        <td class="py-3 px-5">
                            @if(auth()->user()->isAdmin())
                            <input type="text" name="attendances[{{ $absensi->id }}][catatan]" value="{{ $absensi->catatan }}" placeholder="Catatan..." class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-2 focus:ring-emerald-500">
                            @else
                            <span class="text-xs text-slate-500">{{ $absensi->catatan ?? '-' }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-10 text-slate-400 text-sm">Tidak ada data absensi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(auth()->user()->isAdmin() && $absensis->count() > 0)
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-500">Simpan perubahan status absensi setelah selesai mengedit.</span>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-emerald-600/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Semua Perubahan Absensi
            </button>
        </div>
        </form>
        @endif
    </div>
</div>
@endsection
