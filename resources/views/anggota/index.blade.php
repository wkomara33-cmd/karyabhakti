@extends('layouts.app')

@section('title', 'Kelola Anggota & Pendaftar')
@section('header_title', 'Kelola Anggota & Pendaftar')
@section('header_subtitle', 'Verifikasi pendaftar baru, jadwal wawancara, dan data anggota resmi Karang Taruna')

@section('content')
<div class="space-y-6">
    
    <!-- Stats Summary Row -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <a href="{{ route('anggota.index') }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'all' ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-white border-slate-100 hover:border-slate-300 text-slate-800' }}">
            <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'all' ? 'text-slate-300' : 'text-slate-400' }}">Total Data</p>
            <h4 class="text-xl font-black mt-1">{{ $stats['total'] }}</h4>
        </a>

        <!-- Pending (Menunggu Peninjauan) -->
        <a href="{{ route('anggota.index', ['status' => 'pending']) }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'pending' ? 'bg-amber-500 text-white border-amber-500 shadow-md' : 'bg-white border-slate-100 hover:border-amber-300 text-slate-800' }}">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'pending' ? 'text-amber-100' : 'text-amber-600' }}">Peninjauan</p>
                @if($stats['pending'] > 0)
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                @endif
            </div>
            <h4 class="text-xl font-black mt-1 {{ $filters['status'] === 'pending' ? 'text-white' : 'text-amber-600' }}">{{ $stats['pending'] }}</h4>
        </a>

        <!-- Interview (Menunggu Wawancara) -->
        <a href="{{ route('anggota.index', ['status' => 'interview']) }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'interview' ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white border-slate-100 hover:border-blue-300 text-slate-800' }}">
            <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'interview' ? 'text-blue-100' : 'text-blue-600' }}">Wawancara</p>
            <h4 class="text-xl font-black mt-1 {{ $filters['status'] === 'interview' ? 'text-white' : 'text-blue-600' }}">{{ $stats['interview'] }}</h4>
        </a>

        <!-- Aktif -->
        <a href="{{ route('anggota.index', ['status' => 'aktif']) }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'aktif' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white border-slate-100 hover:border-emerald-300 text-slate-800' }}">
            <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'aktif' ? 'text-emerald-100' : 'text-emerald-600' }}">Anggota Aktif</p>
            <h4 class="text-xl font-black mt-1 {{ $filters['status'] === 'aktif' ? 'text-white' : 'text-emerald-600' }}">{{ $stats['aktif'] }}</h4>
        </a>

        <!-- Nonaktif -->
        <a href="{{ route('anggota.index', ['status' => 'nonaktif']) }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'nonaktif' ? 'bg-slate-700 text-white border-slate-700 shadow-md' : 'bg-white border-slate-100 hover:border-slate-300 text-slate-800' }}">
            <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'nonaktif' ? 'text-slate-300' : 'text-slate-400' }}">Nonaktif</p>
            <h4 class="text-xl font-black mt-1 {{ $filters['status'] === 'nonaktif' ? 'text-white' : 'text-slate-600' }}">{{ $stats['nonaktif'] }}</h4>
        </a>

        <!-- Ditolak / Arsip -->
        <a href="{{ route('anggota.index', ['status' => 'ditolak']) }}" 
           class="p-4 rounded-2xl border transition-all {{ $filters['status'] === 'ditolak' ? 'bg-rose-600 text-white border-rose-600 shadow-md' : 'bg-white border-slate-100 hover:border-rose-300 text-slate-800' }}">
            <p class="text-[10px] font-bold uppercase tracking-wider {{ $filters['status'] === 'ditolak' ? 'text-rose-100' : 'text-rose-600' }}">Ditolak / Arsip</p>
            <h4 class="text-xl font-black mt-1 {{ $filters['status'] === 'ditolak' ? 'text-white' : 'text-rose-600' }}">{{ $stats['ditolak'] }}</h4>
        </a>
    </div>

    <!-- Filter and Search Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Search & Filters Form -->
            <form action="{{ route('anggota.index') }}" method="GET" class="flex-1 flex flex-wrap items-center gap-3">
                
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[240px]">
                    <input type="text" name="search" value="{{ $filters['search'] }}" 
                           placeholder="Cari nama, NIK, email, No HP, atau alamat..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()"
                        class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Menunggu Peninjauan ({{ $stats['pending'] }})</option>
                    <option value="interview" {{ $filters['status'] === 'interview' ? 'selected' : '' }}>Menunggu Wawancara ({{ $stats['interview'] }})</option>
                    <option value="aktif" {{ $filters['status'] === 'aktif' ? 'selected' : '' }}>Aktif ({{ $stats['aktif'] }})</option>
                    <option value="nonaktif" {{ $filters['status'] === 'nonaktif' ? 'selected' : '' }}>Nonaktif ({{ $stats['nonaktif'] }})</option>
                    <option value="ditolak" {{ $filters['status'] === 'ditolak' ? 'selected' : '' }}>Ditolak ({{ $stats['ditolak'] }})</option>
                </select>

                <!-- Jabatan Filter -->
                <select name="jabatan" onchange="this.form.submit()"
                        class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="all" {{ $filters['jabatan'] === 'all' ? 'selected' : '' }}>Semua Jabatan</option>
                    @foreach($jabatanList as $jbtn)
                    <option value="{{ $jbtn }}" {{ $filters['jabatan'] === $jbtn ? 'selected' : '' }}>{{ $jbtn }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs transition-all">
                    Filter
                </button>

                @if(!empty($filters['search']) || $filters['status'] !== 'all' || $filters['jabatan'] !== 'all')
                <a href="{{ route('anggota.index') }}" class="px-3 py-2 text-xs font-semibold text-rose-600 hover:underline">
                    Reset
                </a>
                @endif

            </form>

            <!-- Add Button -->
            <a href="{{ route('anggota.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 active:scale-95 transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Input Manual Anggota</span>
            </a>

        </div>
    </div>

    <!-- Anggota Table List -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="py-4 px-5">Calon / Anggota</th>
                        <th class="py-4 px-5">Kontak & NIK</th>
                        <th class="py-4 px-5">Jabatan</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5 text-center">Kehadiran</th>
                        <th class="py-4 px-5 text-right">Tindakan / Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($anggotas as $anggota)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Profile & Name -->
                        <td class="py-4 px-5 whitespace-nowrap">
                            <div class="flex items-center space-x-3.5">
                                <img src="{{ $anggota->foto_url }}" alt="{{ $anggota->nama }}" 
                                     class="w-10 h-10 rounded-2xl object-cover border border-slate-200 shrink-0">
                                <div>
                                    <a href="{{ route('anggota.show', $anggota->id) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                                        <span>{{ $anggota->nama }}</span>
                                        @if($anggota->status === 'pending')
                                        <span class="w-2 h-2 rounded-full bg-amber-500" title="Pendaftar Baru"></span>
                                        @elseif($anggota->status === 'interview')
                                        <span class="w-2 h-2 rounded-full bg-blue-500" title="Siap Wawancara"></span>
                                        @endif
                                    </a>
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                        <span>{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        <span>•</span>
                                        <span>{{ $anggota->usia }} thn</span>
                                        <span>•</span>
                                        <span>Daftar: {{ $anggota->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- NIK & Kontak -->
                        <td class="py-4 px-5 whitespace-nowrap">
                            <div class="font-semibold text-slate-800 font-mono text-xs">{{ $anggota->nik }}</div>
                            <div class="text-[11px] text-emerald-700 font-medium mt-0.5">{{ $anggota->email ?: ($anggota->user->email ?? '-') }}</div>
                            <div class="text-[11px] text-slate-500">{{ $anggota->no_hp }}</div>
                        </td>

                        <!-- Jabatan -->
                        <td class="py-4 px-5 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $anggota->jabatan !== 'Anggota' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $anggota->jabatan ?: 'Anggota' }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold border {{ $anggota->status_badge_class }}">
                                @if($anggota->status === 'pending')
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                @elseif($anggota->status === 'interview')
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                @elseif($anggota->status === 'aktif')
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                @elseif($anggota->status === 'ditolak')
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                @endif
                                <span>{{ $anggota->status_label }}</span>
                            </span>
                        </td>

                        <!-- Attendance Meter -->
                        <td class="py-4 px-5 text-center whitespace-nowrap">
                            @if(in_array($anggota->status, ['aktif', 'nonaktif']))
                            <div class="inline-flex items-center gap-1.5">
                                <div class="w-12 bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $anggota->tingkat_kehadiran }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700">{{ $anggota->tingkat_kehadiran }}%</span>
                            </div>
                            @else
                            <span class="text-[11px] text-slate-400 italic">Belum aktif</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                
                                <!-- Primary Action: Verifikasi atau Detail -->
                                @if($anggota->status === 'pending')
                                <a href="{{ route('anggota.show', $anggota->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm shadow-amber-500/30 transition-all">
                                    <span>Panggil Wawancara</span>
                                    &rarr;
                                </a>
                                @elseif($anggota->status === 'interview')
                                <a href="{{ route('anggota.show', $anggota->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm shadow-blue-600/30 transition-all">
                                    <span>Tentukan Hasil</span>
                                    &rarr;
                                </a>
                                @else
                                <a href="{{ route('anggota.show', $anggota->id) }}" 
                                   title="Lihat Profil Lengkap"
                                   class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @endif

                                <!-- Toggle Aktif/Nonaktif for active/inactive members -->
                                @if(in_array($anggota->status, ['aktif', 'nonaktif']))
                                <form action="{{ route('anggota.toggleStatus', $anggota->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status aktif anggota ini?')">
                                    @csrf
                                    <button type="submit" 
                                            title="{{ $anggota->status === 'aktif' ? 'Nonaktifkan Anggota' : 'Aktifkan Kembali Anggota' }}"
                                            class="p-2 rounded-xl {{ $anggota->status === 'aktif' ? 'bg-amber-50 hover:bg-amber-100 text-amber-700' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }} transition-colors">
                                        @if($anggota->status === 'aktif')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('anggota.edit', $anggota->id) }}" 
                                   title="Edit Data"
                                   class="p-2 rounded-xl bg-slate-100 hover:bg-sky-50 hover:text-sky-600 text-slate-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            title="Hapus Data"
                                            class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            Tidak ada data anggota atau pendaftar yang sesuai kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($anggotas->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $anggotas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
