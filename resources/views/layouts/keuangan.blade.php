<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Keuangan Karang Taruna') - {{ config('app.name', 'Karang Taruna') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full flex overflow-hidden bg-slate-50 text-slate-800" x-data="{ sidebarOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white flex flex-col transition-transform duration-300 ease-in-out shadow-2xl lg:static lg:translate-x-0">

        <!-- Brand -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800/80 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-white flex items-center justify-center shadow-lg overflow-hidden">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain p-1">
                </div>
                <div>
                    <h1 class="font-bold text-sm text-white leading-tight">Keuangan</h1>
                    <p class="text-[10px] text-emerald-400 font-medium">Karang Taruna Karya Bhakti</p>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Nav Menu -->
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <div class="pt-4 pb-1.5 px-3.5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Transaksi</p>
            </div>

            {{-- Pemasukan --}}
            <a href="{{ route('pemasukan.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('pemasukan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
                Pemasukan
            </a>

            {{-- Pengeluaran --}}
            <a href="{{ route('pengeluaran.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('pengeluaran.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
                Pengeluaran
            </a>

            <div class="pt-4 pb-1.5 px-3.5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Laporan</p>
            </div>

            {{-- Laporan Keuangan --}}
            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('laporan.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan Keuangan
            </a>

        </nav>

        <!-- User Footer -->
        <div class="p-4 border-t border-slate-800 shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2.5 overflow-hidden min-w-0">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                         class="w-9 h-9 rounded-xl object-cover ring-2 ring-emerald-500/40 shrink-0">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->roles->pluck('name')->first() ?? 'User' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-xl transition-all ml-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Top Bar -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-8 z-20 shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h2 class="text-base font-bold text-slate-900 tracking-tight">@yield('header_title', 'Keuangan')</h2>
                    <p class="text-xs text-slate-500 hidden sm:block">@yield('header_subtitle', 'Sistem Pencatatan Keuangan Karang Taruna Karya Bhakti')</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @yield('header_actions')
                <img src="{{ auth()->user()->avatar_url }}" alt="avatar"
                     class="w-8 h-8 rounded-lg border border-slate-200 object-cover shadow-sm">
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-slate-50">
            @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm">✓</div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">✕</button>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-sm">!</div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">✕</button>
            </div>
            @endif

            @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                <div class="font-semibold text-sm mb-1">Terdapat beberapa kesalahan:</div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-amber-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
