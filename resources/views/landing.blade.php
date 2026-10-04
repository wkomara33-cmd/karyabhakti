<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karang Taruna Karya Bhakti - Wadah Kepemudaan & Pengabdian Masyarakat</title>
    
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Navigation Bar -->
    <header class="fixed top-0 inset-x-0 z-50 glass-nav border-b border-slate-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-emerald-400 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-600/30 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block font-black text-lg text-slate-900 tracking-tight leading-none group-hover:text-emerald-600 transition-colors">KARANG TARUNA</span>
                        <span class="text-xs font-bold text-emerald-600 tracking-wider uppercase">Karya Bhakti</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                    <a href="#tentang" class="hover:text-emerald-600 transition-colors">Tentang Kami</a>
                    <a href="#kegiatan" class="hover:text-emerald-600 transition-colors">Kegiatan</a>
                    <a href="#pengumuman" class="hover:text-emerald-600 transition-colors">Pengumuman</a>
                    <a href="#alur" class="hover:text-emerald-600 transition-colors">Alur Bergabung</a>
                </nav>

                <!-- Action CTA Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition-all">
                        Masuk Dashboard &rarr;
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-slate-100 transition-colors">
                        Masuk Portal
                    </a>
                    <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-xs shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        <span>Daftar Jadi Anggota</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="sm:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="#tentang" @click="mobileMenuOpen = false" class="block py-2 text-sm font-semibold text-slate-700 hover:text-emerald-600">Tentang Kami</a>
            <a href="#kegiatan" @click="mobileMenuOpen = false" class="block py-2 text-sm font-semibold text-slate-700 hover:text-emerald-600">Kegiatan</a>
            <a href="#pengumuman" @click="mobileMenuOpen = false" class="block py-2 text-sm font-semibold text-slate-700 hover:text-emerald-600">Pengumuman</a>
            <a href="#alur" @click="mobileMenuOpen = false" class="block py-2 text-sm font-semibold text-slate-700 hover:text-emerald-600">Alur Bergabung</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs">
                    Masuk Dashboard
                </a>
                @else
                <a href="{{ route('pendaftaran.create') }}" class="w-full text-center py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md">
                    Daftar Jadi Anggota
                </a>
                <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                    Masuk Portal
                </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-32 overflow-hidden bg-gradient-to-b from-emerald-50/60 via-white to-slate-50">
        <!-- Background Glow Accent -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-emerald-400/20 to-teal-300/20 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-300/60 text-emerald-800 text-xs font-bold uppercase tracking-wider shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Wadah Pemuda Berkarya & Berbakti</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Bersama Pemuda, <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Bangun Lingkungan Mandiri</span> & Berdaya.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
                    Karang Taruna Karya Bhakti adalah wadah generasi muda untuk menyalurkan kreativitas, gotong royong, dan kepedulian sosial demi kemajuan masyarakat yang harmonis dan berprestasi.
                </p>

                <!-- CTA Action Group -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('pendaftaran.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-600/30 hover:shadow-emerald-600/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        <span>Daftar Jadi Anggota</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#alur" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-sm border border-slate-200 shadow-sm transition-all">
                        <span>Lihat Alur Pendaftaran</span>
                    </a>
                </div>

                <!-- Stats Counters -->
                <div class="pt-10 grid grid-cols-2 sm:grid-cols-3 gap-6 max-w-2xl mx-auto border-t border-slate-200/80">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/60 shadow-sm">
                        <div class="text-3xl font-black text-emerald-600">{{ $totalAnggotaAktif }}</div>
                        <div class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Anggota Aktif</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/60 shadow-sm">
                        <div class="text-3xl font-black text-teal-600">{{ $totalKegiatanSelesai }}</div>
                        <div class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Kegiatan Terlaksana</div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/60 shadow-sm">
                        <div class="text-3xl font-black text-slate-900">100%</div>
                        <div class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Transparansi Kas</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Alur Pendaftaran Section (Sesuai SOP) -->
    <section id="alur" class="py-20 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Panduan Pendaftaran</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-3">Alur Menjadi Anggota Resmi</h2>
                <p class="text-sm text-slate-500 mt-2">Proses penerimaan anggota berlangsung transparan melalui seleksi berkas dan wawancara offline.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                
                <!-- Step 1 -->
                <div class="relative bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center shadow-md shadow-emerald-600/30 mb-5">
                            01
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Isi Formulir Online</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Calon anggota mengisi formulir pendaftaran dengan NIK, kontak, alamat, dan alasan bergabung. Tanpa perlu login.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t border-slate-200 text-[11px] font-semibold text-amber-700 bg-amber-50 px-3 py-1.5 rounded-xl">
                        Status: Menunggu Peninjauan
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-black text-lg flex items-center justify-center shadow-md shadow-blue-600/30 mb-5">
                            02
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Peninjauan & Undangan</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Pengurus meninjau berkas pendaftar dan menetapkan jadwal serta lokasi wawancara. Undangan dikirim otomatis ke email Anda.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t border-slate-200 text-[11px] font-semibold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-xl">
                        Status: Menunggu Wawancara
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white font-black text-lg flex items-center justify-center shadow-md shadow-purple-600/30 mb-5">
                            03
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Sesi Wawancara Offline</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Wawancara tatap muka dengan pengurus di sekretariat untuk mengenal minat, komitmen, dan divisi yang diminati.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t border-slate-200 text-[11px] font-semibold text-purple-700 bg-purple-50 px-3 py-1.5 rounded-xl">
                        Keputusan: Setujui / Tolak
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white font-black text-lg flex items-center justify-center shadow-md shadow-emerald-500/30 mb-5">
                            04
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Aktivasi Akun Portal</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Bila disetujui, akun login digenerate otomatis dan dikirim via email. Anda resmi menjadi anggota dan dapat mengikuti kegiatan.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t border-slate-200 text-[11px] font-semibold text-emerald-800 bg-emerald-100 px-3 py-1.5 rounded-xl">
                        Status: Anggota Aktif ✓
                    </div>
                </div>

            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm shadow-lg shadow-emerald-600/30 transition-all">
                    <span>Mulai Pendaftaran Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Kegiatan Terkini Section -->
    <section id="kegiatan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Agenda Bersama</span>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Kegiatan Mendatang</h2>
                    <p class="text-xs text-slate-500 mt-1">Kegiatan-kegiatan aktif yang diselenggarakan oleh pemuda Karang Taruna</p>
                </div>
                <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    Login untuk RSVP Kehadiran &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($kegiatanTerbaru as $keg)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $keg->status_badge_class }}">
                                {{ $keg->status_label }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500">
                                📅 {{ $keg->tanggal->isoFormat('D MMM Y') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $keg->nama_kegiatan }}</h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ $keg->deskripsi }}</p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">📍 {{ $keg->lokasi }}</span>
                        <span class="font-bold text-emerald-600">{{ $keg->tanggal->format('H:i') }} WIB</span>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200">
                    <p class="text-sm text-slate-500">Belum ada jadwal kegiatan mendatang saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Pengumuman Terkini Section -->
    <section id="pengumuman" class="py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Informasi Resmi</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Pengumuman Terbaru</h2>
                <p class="text-xs text-slate-500 mt-1">Berita, imbauan, dan informasi resmi dari kepengurusan Karang Taruna</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($pengumumanTerbaru as $png)
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $png->prioritas_badge_class }}">
                                {{ ucfirst($png->prioritas) }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $png->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-base font-bold text-slate-900">{{ $png->judul }}</h4>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($png->konten), 120) }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 text-xs font-semibold text-emerald-700">
                        Kategori: {{ $png->kategori }}
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10 bg-slate-50 rounded-3xl border border-slate-200">
                    <p class="text-sm text-slate-500">Belum ada pengumuman publik terbaru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-white pt-16 pb-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-slate-800">
                
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-500 flex items-center justify-center font-black text-slate-950">
                            KT
                        </div>
                        <span class="font-extrabold text-lg tracking-tight">Karang Taruna Karya Bhakti</span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                        Organisasi sosial wadah pembinaan dan pengembangan generasi muda yang bergerak di bidang kesejahteraan sosial, keagamaan, olahraga, dan seni budaya.
                    </p>
                </div>

                <div class="space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Navigasi</h5>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#tentang" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#kegiatan" class="hover:text-white transition-colors">Kegiatan Pemuda</a></li>
                        <li><a href="#pengumuman" class="hover:text-white transition-colors">Pengumuman</a></li>
                        <li><a href="{{ route('pendaftaran.create') }}" class="hover:text-white transition-colors">Daftar Anggota</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Sekretariat</h5>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Balai Warga RW 04, Kelurahan Sukamaju<br>
                        Kecamatan Sukakarya, Kota Bekasi<br>
                        Email: info@karyabhakti.org
                    </p>
                </div>

            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Karang Taruna Karya Bhakti. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="hover:text-slate-300">Masuk Pengurus & Anggota</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
