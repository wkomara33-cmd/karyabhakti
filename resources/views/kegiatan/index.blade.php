@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', 'Jadwal Kegiatan & Absensi')
@section('header_title', 'Jadwal Kegiatan & Agenda')
@section('header_subtitle', 'Pantau jadwal kegiatan Karang Taruna dan konfirmasi kehadiran Anda')

@section('content')
<div class="space-y-6">

    <!-- Action & Status Filters Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Filters & Search Form -->
            <form action="{{ route('kegiatan.index') }}" method="GET" class="flex-1 flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[240px]">
                    <input type="text" name="search" value="{{ $search }}" 
                           placeholder="Cari nama kegiatan atau lokasi..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <select name="status" onchange="this.form.submit()"
                        class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="akan_datang" {{ $status === 'akan_datang' ? 'selected' : '' }}>Akan Datang ({{ $stats['akan_datang'] }})</option>
                    <option value="berlangsung" {{ $status === 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung ({{ $stats['berlangsung'] }})</option>
                    <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai ({{ $stats['selesai'] }})</option>
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs transition-all">
                    Filter
                </button>

                @if(!empty($search) || $status !== 'all')
                <a href="{{ route('kegiatan.index') }}" class="px-3 py-2 text-xs font-semibold text-rose-600 hover:underline">
                    Reset
                </a>
                @endif
            </form>

            @if(auth()->user()->isAdmin())
            <!-- Create Button -->
            <a href="{{ route('kegiatan.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 active:scale-95 transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Jadwal Kegiatan</span>
            </a>
            @endif

        </div>
    </div>

    <!-- Kegiatan Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kegiatans as $keg)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
            
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between gap-2">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $keg->status_badge_class }}">
                        {{ $keg->status_label }}
                    </span>
                    <span class="text-xs font-semibold text-slate-500">
                        {{ $keg->tanggal->isoFormat('D MMM Y') }}
                    </span>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-emerald-600 transition-colors line-clamp-2 leading-snug">
                        <a href="{{ route('kegiatan.show', $keg->id) }}">{{ $keg->nama_kegiatan }}</a>
                    </h3>
                    <p class="mt-2 text-xs text-slate-600 line-clamp-3 leading-relaxed">
                        {{ $keg->deskripsi }}
                    </p>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-50 text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400">🕒</span>
                        <span class="font-medium">{{ $keg->tanggal->isoFormat('HH:mm') }} WIB @if($keg->tanggal_selesai) s/d {{ $keg->tanggal_selesai->isoFormat('HH:mm') }} WIB @endif</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400">📍</span>
                        <span class="font-medium line-clamp-1">{{ $keg->lokasi }}</span>
                    </div>
                </div>

                <!-- Stats summary bar -->
                <div class="pt-2 flex items-center justify-between text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl">
                    <span>RSVP Hadir: <strong class="text-emerald-600">{{ $keg->total_rsvpd }}</strong></span>
                    <span>Presensi Hadir: <strong class="text-sky-600">{{ $keg->total_hadir }}</strong></span>
                </div>
            </div>

            <!-- Card Bottom Action -->
            <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('kegiatan.show', $keg->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    <span>Lihat Detail & Presensi</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-1">
                    <a href="{{ route('kegiatan.edit', $keg->id) }}" title="Edit Kegiatan" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-sky-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
                @endif
            </div>

        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-100">
            <p class="text-slate-400 font-semibold text-sm">Tidak ada jadwal kegiatan yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $kegiatans->links() }}
    </div>

</div>
@endsection
