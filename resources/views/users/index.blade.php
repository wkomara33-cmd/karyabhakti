@extends('layouts.app')

@section('title', 'Manajemen User & Akun Login')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Akun & Hak Akses</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola akun pengguna, hak akses peran (Admin / Pengurus / Anggota), dan tautan profil.</p>
        </div>

        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-emerald-600/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Akun Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('users.index', ['role' => 'all', 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('role', 'all') === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Role
            </a>
            @foreach($roles as $r)
            <a href="{{ route('users.index', ['role' => $r->name, 'search' => request('search')]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ request('role') === $r->name ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $r->name }}
            </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="flex items-center space-x-2">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <div class="relative w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, hp..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-xl hover:bg-slate-800 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-4">Kontak / No HP</th>
                        <th class="py-3.5 px-4">Role / Hak Akses</th>
                        <th class="py-3.5 px-4">Tautan Profil Anggota</th>
                        <th class="py-3.5 px-4">Terdaftar Sejak</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-6 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                <div>
                                    <p class="font-bold text-slate-900 text-xs">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                            {{ $user->phone ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @foreach($user->roles as $roleItem)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ in_array($roleItem->name, ['admin', 'Ketua', 'Sekretaris', 'Bendahara']) ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                                {{ $roleItem->name }}
                            </span>
                            @endforeach
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-xs">
                            @if($user->anggota)
                            <a href="{{ route('anggota.show', $user->anggota->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                {{ $user->anggota->nama }} ({{ $user->anggota->jabatan }})
                            </a>
                            @else
                            <span class="text-slate-400 italic">Belum ditautkan</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-400">
                            {{ $user->created_at->isoFormat('D MMM Y') }}
                        </td>
                        <td class="py-3.5 px-6 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit Akun">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun user {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-400">
                            Tidak ditemukan akun user yang sesuai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
