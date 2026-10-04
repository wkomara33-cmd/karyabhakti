@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', 'Profil & Riwayat Saya')
@section('header_title', 'Profil Saya')
@section('header_subtitle', 'Informasi akun pribadi, biodata anggota, dan rekap riwayat kehadiran kegiatan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <!-- Top Identity Card -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl object-cover ring-4 ring-emerald-400/40 shadow-lg shrink-0">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 text-xs font-bold uppercase tracking-wider">
                    <span>{{ $anggota->jabatan ?? $user->roles->pluck('name')->first() }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $user->name }}</h1>
                <p class="text-xs sm:text-sm text-emerald-200/90 font-medium">
                    ✉ {{ $user->email }} • 📞 {{ $user->phone ?? ($anggota->no_hp ?? '-') }}
                </p>
                @if($anggota)
                <p class="text-xs text-slate-300">
                    NIK: <span class="font-mono text-white">{{ $anggota->nik }}</span> • Bergabung sejak {{ $anggota->tanggal_bergabung ? $anggota->tanggal_bergabung->isoFormat('D MMMM Y') : '-' }}
                </p>
                @endif
            </div>
        </div>

        @if($anggota)
        <!-- Attendance Stats Badge -->
        <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shrink-0">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/30 text-emerald-300 flex items-center justify-center font-black text-2xl">
                {{ $anggota->tingkat_kehadiran }}%
            </div>
            <div>
                <h4 class="text-xs font-semibold text-emerald-200 uppercase tracking-wider">Tingkat Kehadiran</h4>
                <p class="text-xs text-white/90 font-bold">{{ $totalHadir }} dari {{ $totalKegiatanSelesai }} kegiatan selesai</p>
            </div>
        </div>
        @endif
    </div>

    <!-- 2 Column Layout: Details & History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Data Pribadi & Update Forms -->
        <div class="space-y-6">
            
            @if($anggota)
            <!-- Biodata Anggota Box -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                    <span>Biodata Anggota Resmi</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $anggota->status_badge_class }}">{{ $anggota->status_label }}</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">NIK</span>
                        <span class="font-bold text-slate-800 font-mono text-sm">{{ $anggota->nik }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Jenis Kelamin</span>
                        <span class="font-semibold text-slate-800">{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} ({{ $anggota->usia }} tahun)</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Tanggal Lahir</span>
                        <span class="font-semibold text-slate-800">{{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->isoFormat('D MMMM Y') : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">Alamat Domisili</span>
                        <span class="font-medium text-slate-700 leading-relaxed">{{ $anggota->alamat }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Edit Profil Akun -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-100 pb-3">Perbarui Kontak</h3>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">No. Handphone / WA</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? ($anggota->no_hp ?? '')) }}" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Avatar</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Ganti Password -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-100 pb-3">Ganti Kata Sandi</h3>
                
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Password Baru</label>
                        <input type="password" name="password" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition-all">
                        Perbarui Kata Sandi
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Riwayat Kehadiran Anggota (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            
            @if($anggota)
            <!-- Quick Summary KPI -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Hadir</p>
                    <h4 class="text-xl font-black text-emerald-600 mt-1">{{ $totalHadir }}</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Izin / Sakit</p>
                    <h4 class="text-xl font-black text-amber-500 mt-1">{{ $totalIzin }}</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tidak Hadir</p>
                    <h4 class="text-xl font-black text-rose-500 mt-1">{{ $totalTidakHadir }}</h4>
                </div>
            </div>

            <!-- Riwayat Kehadiran Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Riwayat Kehadiran Kegiatan Anda</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Catatan partisipasi Anda pada setiap agenda yang diselenggarakan Karang Taruna</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-5">Nama Kegiatan</th>
                                <th class="py-3 px-5">Tanggal</th>
                                <th class="py-3 px-5 text-center">Konfirmasi RSVP</th>
                                <th class="py-3 px-5 text-center">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayatAbsensi as $absensi)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    <a href="{{ route('kegiatan.show', $absensi->kegiatan_id) }}" class="hover:text-emerald-600 transition-colors">
                                        {{ $absensi->kegiatan->nama_kegiatan ?? 'Kegiatan #' . $absensi->kegiatan_id }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-slate-500">
                                    {{ $absensi->kegiatan ? $absensi->kegiatan->tanggal->isoFormat('D MMMM Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                    @if($absensi->konfirmasi_kehadiran === 'hadir')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">✓ Akan Hadir</span>
                                    @elseif($absensi->konfirmasi_kehadiran === 'tidak_hadir')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">✕ Tidak Hadir</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Belum Konfirmasi</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                    @if($absensi->status_kehadiran === 'hadir')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">✓ Hadir</span>
                                    @elseif($absensi->status_kehadiran === 'izin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Izin</span>
                                    @elseif($absensi->status_kehadiran === 'tidak_hadir')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Tidak Hadir</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">Belum Absen</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    Belum ada catatan riwayat kegiatan untuk akun Anda.
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
            @endif

        </div>

    </div>

</div>
@endsection
