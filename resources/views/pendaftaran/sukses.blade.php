<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil Diterima - Karang Taruna Karya Bhakti</title>
    
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
<body class="bg-gradient-to-br from-slate-50 via-emerald-50/50 to-slate-100 min-h-screen text-slate-800 flex items-center justify-center py-12 px-4 sm:px-6">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-2xl shadow-emerald-950/10 border border-slate-200/80 overflow-hidden text-center">
        
        <!-- Header Success Animation / Graphic -->
        <div class="bg-gradient-to-b from-emerald-600 to-teal-700 p-8 text-white relative">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-emerald-900/30 ring-4 ring-white/30">
                ✓
            </div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight mt-4">Pendaftaran Berhasil Diterima!</h1>
            <p class="text-xs sm:text-sm text-emerald-100 mt-1 max-w-md mx-auto">
                Terima kasih telah mendaftar sebagai calon anggota Karang Taruna Karya Bhakti.
            </p>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            
            <!-- Status Badge Notice -->
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-left space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-800">Status Saat Ini</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-amber-200/80 text-amber-900">
                        Menunggu Peninjauan (Pending)
                    </span>
                </div>
                <p class="text-xs text-amber-800/90 leading-relaxed mt-1">
                    Data pendaftaran Anda telah tersimpan di sistem kami. Pengurus akan segera meninjau berkas Anda untuk penjadwalan wawancara.
                </p>
            </div>

            <!-- Receipt Summary -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 text-left space-y-2.5 text-xs">
                <div class="flex justify-between items-center pb-2 border-b border-slate-200/60 font-semibold text-slate-500">
                    <span>Ringkasan Data Pendaftar</span>
                    <span class="font-mono text-slate-400">#KTKB-{{ str_pad($anggota->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Lengkap</span>
                    <span class="font-bold text-slate-900">{{ $anggota->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">NIK</span>
                    <span class="font-mono text-slate-800">{{ $anggota->nik }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Email Terdaftar</span>
                    <span class="font-bold text-emerald-700">{{ $anggota->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">No. HP / WhatsApp</span>
                    <span class="font-medium text-slate-800">{{ $anggota->no_hp }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Waktu Mendaftar</span>
                    <span class="font-medium text-slate-800">{{ $anggota->created_at->isoFormat('D MMMM Y • HH:mm') }} WIB</span>
                </div>
            </div>

            <!-- Next Steps Flow -->
            <div class="text-left space-y-2">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Langkah Selanjutnya:</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex items-start gap-2.5 p-2 rounded-xl bg-slate-50">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">1</span>
                        <p class="text-slate-600"><strong>Peninjauan Berkas:</strong> Pengurus memverifikasi biodata dan alasan bergabung Anda.</p>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-xl bg-slate-50">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0">2</span>
                        <p class="text-slate-600"><strong>Undangan Wawancara:</strong> Undangan jadwal & lokasi wawancara akan otomatis dikirimkan ke email <strong>{{ $anggota->email }}</strong>.</p>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-xl bg-slate-50">
                        <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold shrink-0">3</span>
                        <p class="text-slate-600"><strong>Aktivasi Akun:</strong> Setelah wawancara disetujui, akun portal anggota Anda akan aktif dan kredensial login dikirim ke email.</p>
                    </div>
                </div>
            </div>

            <!-- Return Actions -->
            <div class="pt-2 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('home') }}" class="flex-1 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition-all text-center">
                    Kembali ke Beranda Utama
                </a>
                <a href="{{ route('login') }}" class="py-3 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                    Halaman Login
                </a>
            </div>

        </div>

    </div>

</body>
</html>
