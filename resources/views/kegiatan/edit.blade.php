@extends('layouts.app')

@section('title', 'Edit Kegiatan')
@section('header_title', 'Edit Jadwal Kegiatan')
@section('header_subtitle', 'Perbarui waktu, lokasi, deskripsi, atau status pelaksanaan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Kegiatan</span>
        </a>
    </div>

    <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-4">
            <h3 class="text-lg font-bold text-slate-900">Perbarui Data Kegiatan</h3>
            <p class="text-xs text-slate-500">Sesuaikan data agenda yang dibutuhkan</p>
        </div>

        <div class="space-y-4">
            <!-- Nama Kegiatan -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Kegiatan <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Waktu Mulai -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal & Waktu Mulai <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal ? $kegiatan->tanggal->format('Y-m-d\TH:i') : '') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- Waktu Selesai -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal & Waktu Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Lokasi -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Status Kegiatan <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="akan_datang" {{ old('status', $kegiatan->status) === 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="berlangsung" {{ old('status', $kegiatan->status) === 'berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="selesai" {{ old('status', $kegiatan->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status', $kegiatan->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi Kegiatan -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Deskripsi Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="deskripsi" rows="4" required
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <!-- Banner Gambar -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Ganti Foto / Banner (Opsional)</label>
                <input type="file" name="banner" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-lg shadow-emerald-600/20 active:scale-95 transition-all">
                Perbarui Kegiatan
            </button>
        </div>
    </form>

</div>
@endsection
