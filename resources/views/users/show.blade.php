@extends('layouts.app')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('users.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Detail Akun Pengguna</h1>
            <p class="text-xs text-slate-500">{{ $user->email }}</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6">
        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-2xl object-cover border-4 border-emerald-50 shadow-md shrink-0">

        <div class="flex-1 space-y-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ $user->email }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($user->roles as $role)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        {{ $role->name }}
                    </span>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">No. HP</p>
                    <p class="text-slate-800 font-medium">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Bergabung Sejak</p>
                    <p class="text-slate-800 font-medium">{{ $user->created_at->isoFormat('D MMMM Y') }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50 transition-colors shadow-sm flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit</span>
            </a>
        </div>
    </div>

    <!-- Linked Member Profile -->
    @if($user->anggota)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Profil Anggota Tertaut</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">NIK</p>
                <p class="text-slate-800 font-medium">{{ $user->anggota->nik }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Jabatan</p>
                <p class="text-slate-800 font-medium">{{ $user->anggota->jabatan }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Status</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->anggota->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($user->anggota->status) }}
                </span>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Alamat</p>
                <p class="text-slate-800 font-medium">{{ $user->anggota->alamat }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Tanggal Lahir</p>
                <p class="text-slate-800 font-medium">{{ $user->anggota->tanggal_lahir->isoFormat('D MMMM Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Tanggal Bergabung</p>
                <p class="text-slate-800 font-medium">{{ $user->anggota->tanggal_bergabung->isoFormat('D MMMM Y') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('anggota.show', $user->anggota->id) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat profil anggota lengkap &rarr;</span>
            </a>
        </div>
    </div>
    @else
    <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 text-sm text-amber-700">
        <strong>Catatan:</strong> Akun ini belum ditautkan ke profil anggota manapun. Edit akun untuk menautkan ke profil anggota yang ada.
    </div>
    @endif
</div>
@endsection
