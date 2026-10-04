@extends('layouts.app')

@section('title', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('pengumuman.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat Pengumuman Baru</h1>
            <p class="text-xs text-slate-500">Kirim informasi penting ke seluruh anggota Karang Taruna.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Contoh: Rapat Koordinasi Persiapan HUT RI Ke-81" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('judul')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori & Prioritas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="kategori" id="kategori" list="kategori_list" placeholder="Pilih atau ketik (Rapat, Kegiatan, Iuran, dll)" value="{{ old('kategori') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <datalist id="kategori_list">
                        <option value="Rapat & Pertemuan">
                        <option value="Agenda Kegiatan">
                        <option value="Sosial & Kemasyarakatan">
                        <option value="Iuran & Donasi">
                        <option value="Informasi Internal">
                    </datalist>
                    @error('kategori')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prioritas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tingkat Prioritas <span class="text-rose-500">*</span></label>
                    <select name="prioritas" id="prioritas" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="biasa" {{ old('prioritas') === 'biasa' ? 'selected' : '' }}>📌 Biasa (Pemberitahuan Rutin)</option>
                        <option value="penting" {{ old('prioritas') === 'penting' ? 'selected' : '' }}>⚡ Penting (Harap Diperhatikan)</option>
                        <option value="mendesak" {{ old('prioritas') === 'mendesak' ? 'selected' : '' }}>🚨 Mendesak (Wajib Segera Respon)</option>
                    </select>
                    @error('prioritas')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Konten -->
            <div>
                <label for="konten" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Konten Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="konten" id="konten" rows="6" placeholder="Tulis rincian pesan pengumuman..." required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none leading-relaxed">{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Lampiran File -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lampiran Berkas / Foto (Opsional)</label>
                <input type="file" name="lampiran" accept="image/*,application/pdf,.doc,.docx" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-xs text-slate-400 mt-1">Mendukung PDF, Gambar, Dokumen Word. Maksimal 5MB.</p>
                @error('lampiran')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif / Publikasi Checkbox -->
            <div class="pt-2">
                <label class="inline-flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', '1') ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm font-semibold text-slate-800">Publikasikan sekarang (langsung terlihat oleh anggota)</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('pengumuman.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-600/20">
                    Terbitkan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
