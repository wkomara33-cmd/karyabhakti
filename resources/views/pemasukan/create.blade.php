@extends('layouts.keuangan')

@section('title', 'Tambah Pemasukan')
@section('header_title', 'Tambah Pemasukan')
@section('header_subtitle', 'Catat data pemasukan baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pemasukan.index') }}"
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Pemasukan</h1>
            <p class="text-xs text-slate-500">Iuran anggota, donasi warga, sponsorship, dan sejenisnya</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('pemasukan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @error('tanggal')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="jumlah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jumlah (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-slate-400">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" min="1" step="1"
                               placeholder="Contoh: 50000" value="{{ old('jumlah') }}" required
                               class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    @error('jumlah')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="kategori" id="kategori" list="kategori_list"
                       placeholder="Pilih atau ketik kategori..." value="{{ old('kategori') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <datalist id="kategori_list">
                    <option value="Iuran Bulanan Anggota">
                    <option value="Donasi Warga">
                    <option value="Sponsorship Kegiatan">
                    <option value="Sumbangan Sukarela">
                    <option value="Hasil Usaha Organisasi">
                    <option value="Bantuan Pemerintah">
                    <option value="Lain-lain">
                </datalist>
                @error('kategori')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Keterangan <span class="text-rose-500">*</span>
                </label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          placeholder="Tuliskan keterangan detail..." required
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('keterangan') }}</textarea>
                @error('keterangan')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Bukti / Nota (Opsional)
                </label>
                <input type="file" name="bukti_transaksi" accept="image/*,application/pdf"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-xs text-slate-400 mt-1">JPG, PNG, atau PDF. Maks 3MB.</p>
                @error('bukti_transaksi')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('pemasukan.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-emerald-600/20">
                    Simpan Pemasukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
