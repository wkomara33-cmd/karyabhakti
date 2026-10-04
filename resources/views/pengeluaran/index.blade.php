@extends('layouts.keuangan')

@section('title', 'Pengeluaran')
@section('header_title', 'Pengeluaran')
@section('header_subtitle', 'Daftar seluruh data pengeluaran organisasi')

@section('header_actions')
@if(auth()->user()->isAdmin())
<a href="{{ route('pengeluaran.create') }}"
   class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
    Tambah Pengeluaran
</a>
@endif
@endsection

@section('content')
<div class="space-y-6">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-gradient-to-br from-rose-600 to-pink-700 text-white rounded-2xl p-6 shadow-lg">
            <p class="text-xs font-bold uppercase tracking-widest text-rose-100 mb-3">Total Pengeluaran Keseluruhan</p>
            <p class="text-3xl font-black">Rp {{ number_format($totalAll, 0, ',', '.') }}</p>
            <p class="text-xs text-rose-100 mt-2">Akumulasi semua pengeluaran</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">
                @if($startDate || $endDate) Periode Terpilih @else Total Keseluruhan @endif
            </p>
            <p class="text-3xl font-black text-rose-600">Rp {{ number_format($totalPeriode, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-2">
                @if($startDate && $endDate) {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }} – {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}
                @elseif($startDate) Mulai {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }}
                @elseif($endDate) Sampai {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}
                @else Semua periode @endif
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('pengeluaran.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:outline-none">
                    <option value="all">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ $kategori === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Keterangan</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Ketik kata kunci..."
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter
                </button>
                <a href="{{ route('pengeluaran.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="py-3.5 px-5">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4 text-right">Jumlah</th>
                        <th class="py-3.5 px-4">Dicatat Oleh</th>
                        @if(auth()->user()->isAdmin())
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $item)
                    <tr class="hover:bg-rose-50/30 transition-colors">
                        <td class="py-3.5 px-5 text-xs font-semibold text-slate-700 whitespace-nowrap">
                            {{ $item->tanggal->isoFormat('D MMM Y') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-200">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-700 max-w-xs">
                            <p class="line-clamp-2">{{ $item->keterangan }}</p>
                            @if($item->bukti_transaksi)
                            <a href="{{ asset('storage/' . $item->bukti_transaksi) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-[10px] text-rose-600 hover:text-rose-700 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Lihat Bukti
                            </a>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <span class="font-black text-sm text-rose-600">
                                - Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $item->user->name ?? 'Sistem' }}
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="py-3.5 px-5 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pengeluaran.edit', $item->id) }}"
                                   class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data pengeluaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="py-12 text-center text-slate-400">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            <p class="font-semibold text-slate-500">Belum ada data pengeluaran</p>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('pengeluaran.create') }}" class="mt-2 inline-block text-xs text-rose-600 font-semibold hover:underline">+ Tambah sekarang</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">{{ $data->links() }}</div>
        @endif
    </div>

</div>
@endsection
