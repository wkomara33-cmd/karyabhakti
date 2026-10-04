@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', 'Papan Pengumuman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Papan Informasi & Pengumuman</h1>
            <p class="text-sm text-slate-500 mt-1">Pemberitahuan resmi, agenda rapat, dan informasi penting Karang Taruna.</p>
        </div>

        @if(auth()->user()->isAdmin())
        <div>
            <a href="{{ route('pengumuman.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-emerald-600/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Pengumuman Baru
            </a>
        </div>
        @endif
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('pengumuman.index', ['prioritas' => 'all', 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('prioritas', 'all') === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'mendesak', 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('prioritas') === 'mendesak' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                🚨 Mendesak
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'penting', 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('prioritas') === 'penting' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                ⚡ Penting
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'biasa', 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('prioritas') === 'biasa' ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                📌 Informasi Biasa
            </a>
        </div>

        <form method="GET" action="{{ route('pengumuman.index') }}" class="flex items-center space-x-2">
            @if(request('prioritas'))
                <input type="hidden" name="prioritas" value="{{ request('prioritas') }}">
            @endif
            <div class="relative w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-xl hover:bg-slate-800 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Announcement Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pengumumans as $p)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $p->prioritas_badge }}">
                        {{ ucfirst($p->prioritas) }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $p->created_at->diffForHumans() }}</span>
                </div>

                <div>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                        <a href="{{ route('pengumuman.show', $p->id) }}">{{ $p->judul }}</a>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                        {{ $p->konten }}
                    </p>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs">
                <div class="flex items-center space-x-2 text-slate-500">
                    <span class="font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">{{ $p->kategori }}</span>
                    <span>Oleh {{ $p->user->name ?? 'Admin' }}</span>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('pengumuman.show', $p->id) }}" class="font-semibold text-emerald-600 hover:text-emerald-700">
                        Baca &rarr;
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-100 p-8">
            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <p class="font-bold text-slate-700">Belum ada pengumuman yang sesuai</p>
            <p class="text-xs text-slate-400 mt-1">Coba ganti filter prioritas atau kata kunci pencarian Anda.</p>
        </div>
        @endforelse
    </div>

    @if($pengumumans->hasPages())
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
        {{ $pengumumans->links() }}
    </div>
    @endif
</div>
@endsection
