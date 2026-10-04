@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', $pengumuman->judul)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back & Action -->
    <div class="flex items-center justify-between">
        <a href="{{ route('pengumuman.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center space-x-2 text-xs font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Pengumuman</span>
        </a>

        @if(auth()->user()->isAdmin())
        <div class="flex items-center space-x-2">
            <a href="{{ route('pengumuman.edit', $pengumuman->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50 transition-colors shadow-sm flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit</span>
            </a>
            <form action="{{ route('pengumuman.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-rose-600 text-white text-xs font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-sm flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Announcement Content Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-10 space-y-6">
        <div class="border-b border-slate-100 pb-6 space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $pengumuman->prioritas_badge }}">
                    {{ ucfirst($pengumuman->prioritas) }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                    {{ $pengumuman->kategori }}
                </span>
                @if(!$pengumuman->is_aktif)
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                    Draft (Nonaktif)
                </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                {{ $pengumuman->judul }}
            </h1>

            <div class="flex items-center space-x-3 text-xs text-slate-400">
                <div class="flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Diterbitkan oleh: <strong class="text-slate-700 font-semibold">{{ $pengumuman->user->name ?? 'Pengurus Karang Taruna' }}</strong></span>
                </div>
                <span>&bull;</span>
                <div class="flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $pengumuman->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</span>
                </div>
            </div>
        </div>

        <!-- Body Text -->
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base whitespace-pre-line">
            {{ $pengumuman->konten }}
        </div>

        <!-- Attachment Download If Available -->
        @if($pengumuman->lampiran)
        <div class="mt-8 pt-6 border-t border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Lampiran Dokumen / Berkas</h3>
            <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="inline-flex items-center p-4 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Unduh Berkas Lampiran</p>
                    <p class="text-xs text-slate-400">Klik untuk membuka berkas atau mendownload file lampiran</p>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
