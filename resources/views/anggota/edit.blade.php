@extends('layouts.app')

@section('title', 'Edit Data Anggota')
@section('header_title', 'Edit Data Anggota')
@section('header_subtitle', 'Perbarui informasi profil dan data keanggotaan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('anggota.show', $anggota->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Profil</span>
        </a>
    </div>

    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Biodata Anggota -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Biodata Pribadi</h3>
                    <p class="text-xs text-slate-500">Perbarui informasi identitas kependudukan dan kontak</p>
                </div>
                <img src="{{ $anggota->foto_url }}" alt="{{ $anggota->nama }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shadow-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $anggota->nik) }}" maxlength="16" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('Y-m-d') : '') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $anggota->email ?: ($anggota->user->email ?? '')) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- No HP / WhatsApp -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">No. HP / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <!-- Alamat Domisili -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="alamat" rows="2" required
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <!-- Foto Profil -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Ubah Foto Profil (Opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>
        </div>

        <!-- Keanggotaan & Jabatan -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-900">Posisi & Status Keanggotaan</h3>
                <p class="text-xs text-slate-500">Jabatan kepengurusan dan status keaktifan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Jabatan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jabatan / Sie <span class="text-rose-500">*</span></label>
                    <select name="jabatan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="Anggota" {{ old('jabatan', $anggota->jabatan) === 'Anggota' ? 'selected' : '' }}>Anggota</option>
                        <option value="Ketua" {{ old('jabatan', $anggota->jabatan) === 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ old('jabatan', $anggota->jabatan) === 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Sekretaris" {{ old('jabatan', $anggota->jabatan) === 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ old('jabatan', $anggota->jabatan) === 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="Koord. Sie Olahraga" {{ old('jabatan', $anggota->jabatan) === 'Koord. Sie Olahraga' ? 'selected' : '' }}>Koord. Sie Olahraga</option>
                        <option value="Koord. Sie Kreatif & Media" {{ old('jabatan', $anggota->jabatan) === 'Koord. Sie Kreatif & Media' ? 'selected' : '' }}>Koord. Sie Kreatif & Media</option>
                        <option value="Koord. Sie Humas & Kemitraan" {{ old('jabatan', $anggota->jabatan) === 'Koord. Sie Humas & Kemitraan' ? 'selected' : '' }}>Koord. Sie Humas & Kemitraan</option>
                        <option value="Koord. Sie Rohani & Sosial" {{ old('jabatan', $anggota->jabatan) === 'Koord. Sie Rohani & Sosial' ? 'selected' : '' }}>Koord. Sie Rohani & Sosial</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="pending" {{ old('status', $anggota->status) === 'pending' ? 'selected' : '' }}>Menunggu Peninjauan (Pending)</option>
                        <option value="interview" {{ old('status', $anggota->status) === 'interview' ? 'selected' : '' }}>Menunggu Wawancara (Interview)</option>
                        <option value="aktif" {{ old('status', $anggota->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $anggota->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="ditolak" {{ old('status', $anggota->status) === 'ditolak' ? 'selected' : '' }}>Ditolak (Arsip)</option>
                    </select>
                </div>

                <!-- Tanggal Bergabung -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', $anggota->tanggal_bergabung ? $anggota->tanggal_bergabung->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('anggota.show', $anggota->id) }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-lg shadow-emerald-600/20 active:scale-95 transition-all">
                Perbarui Data Anggota
            </button>
        </div>
    </form>

</div>
@endsection
