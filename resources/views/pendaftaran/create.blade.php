<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Calon Anggota - Karang Taruna Karya Bhakti</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-emerald-50/40 to-slate-100 min-h-screen text-slate-800 py-10 px-4 sm:px-6">

    <div class="max-w-3xl mx-auto space-y-8">
        
        <!-- Header & Brand -->
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Halaman Utama</span>
            </a>
            
            <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                Sudah punya akun? Masuk &rarr;
            </a>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
            
            <!-- Hero Title Banner inside Card -->
            <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-700 p-8 text-white">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider text-emerald-100 border border-white/20">
                        Pendaftaran Terbuka
                    </span>
                    <span class="text-xs text-emerald-100">Tahap 1: Formulir Online</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Formulir Pendaftaran Calon Anggota</h1>
                <p class="text-xs sm:text-sm text-emerald-100 mt-2 leading-relaxed">
                    Lengkapi formulir biodata di bawah ini secara cermat. Setelah disubmit, pengurus akan meninjau berkas Anda dan mengirimkan jadwal wawancara tatap muka ke email terdaftar.
                </p>
            </div>

            <!-- Form Body -->
            <form action="{{ route('pendaftaran.store') }}" method="POST" class="p-6 sm:p-10 space-y-6">
                @csrf

                <!-- Error Flash Alert -->
                @if (isset($errors) && $errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    <div class="font-bold mb-1">Perhatian! Mohon periksa kembali input Anda:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Section: Data Pribadi -->
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">1</span>
                        <span>Identitas Pribadi</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                   placeholder="Contoh: Muhammad Rizky Pratama"
                                   class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                            @error('nama')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                                   placeholder="16 digit angka sesuai KTP/KK"
                                   class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all font-mono">
                            <p class="text-[11px] text-slate-400 mt-1">Harus tepat 16 digit angka.</p>
                            @error('nik')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-semibold text-slate-700">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-semibold text-slate-700">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                   class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                            @error('tanggal_lahir')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP / WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                No. Handphone / WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                            @error('no_hp')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Kontak & Alamat -->
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">2</span>
                        <span>Email & Domisili</span>
                    </h3>

                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="namaanda@gmail.com"
                                   class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                            <p class="text-[11px] text-slate-500 mt-1">
                                Pastikan email aktif! Jadwal wawancara & akun login resmi akan dikirim ke email ini.
                            </p>
                            @error('email')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Domisili Lengkap (RT/RW) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="alamat" rows="2" required
                                      placeholder="Contoh: Jl. Pemuda Bhakti No. 15, RT 02/RW 04, Kelurahan Sukamaju"
                                      class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Motivasi / Alasan -->
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">3</span>
                        <span>Motivasi & Komitmen</span>
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alasan Ingin Bergabung dengan Karang Taruna Karya Bhakti <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="alasan_bergabung" rows="4" required
                                  placeholder="Ceritakan alasan Anda ingin bergabung, minat kegiatan yang ingin Anda ikuti (misal: olahraga, kebersihan lingkungan, media & kreatif, atau sosial kemanusiaan), serta kontribusi yang ingin Anda berikan..."
                                  class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">{{ old('alasan_bergabung') }}</textarea>
                        @error('alasan_bergabung')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Info Box Disclaimer -->
                <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-xs text-emerald-900 space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-emerald-800">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Informasi Alur Selanjutnya</span>
                    </div>
                    <p class="text-emerald-800/90 leading-relaxed">
                        Dengan menekan tombol submit, data Anda akan disimpan dengan status <strong>"Menunggu Peninjauan"</strong>. Pengurus akan menghubungi Anda dan mengirimkan jadwal wawancara tatap muka ke alamat email di atas.
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-center text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-600/30 hover:shadow-emerald-600/40 active:scale-95 transition-all">
                        <span>Kirim Pendaftaran Saya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>
</html>
