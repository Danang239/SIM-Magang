@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIM-MAGANG BRMP Biogen') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js is loaded automatically via Vite, but we include this just in case -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-biogen-bg flex min-h-screen">

        <!-- Sidebar (Hijau Tua) -->
        <aside class="w-64 bg-biogen-dark text-white flex flex-col justify-between shrink-0 shadow-lg border-r border-green-900">
            <div>
                <!-- Logo Section -->
                <div class="px-6 py-5 border-b border-green-900 flex items-center space-x-3 bg-emerald-950">
                    <!-- DNA/Leaf Minimalist Icon -->
                    <svg class="w-8 h-8 text-biogen-light flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18M12 3a9 9 0 019 9m-9-9a9 9 0 00-9 9m9 9a9 9 0 019-9m-9 9a9 9 0 00-9-9M6 12h12M9 8h6M9 16h6" />
                    </svg>
                    <div>
                        <h1 class="font-bold text-lg tracking-tight font-sans">BRMP Biogen</h1>
                        <p class="text-[10px] text-green-200 tracking-wider font-semibold uppercase leading-tight">SIM-MAGANG</p>
                    </div>
                </div>

                <!-- User Identity Card -->
                <div class="p-4 mx-4 my-4 bg-emerald-950/60 rounded-xl border border-green-900 flex items-center space-x-3">
                    <!-- Initial Avatar Circle -->
                    <div class="w-10 h-10 rounded-full bg-biogen-light text-biogen-dark flex items-center justify-center font-bold text-base shadow">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h2 class="font-bold text-sm truncate leading-snug">{{ auth()->user()->name }}</h2>
                        <span class="inline-block text-[10px] px-2 py-0.5 mt-0.5 rounded-full font-bold uppercase tracking-wider bg-white text-biogen-dark shadow-sm">
                            {{ auth()->user()->roles->pluck('name')->first() }}
                        </span>
                    </div>
                </div>

                <!-- Menu Navigation -->
                <nav class="px-4 space-y-1">
                    @php
                        $role = auth()->user()->roles->pluck('name')->first();
                        $dashboardRoute = $role === 'Administrator' ? route('admin.dashboard') : route('petugas.dashboard');
                    @endphp

                    <a href="{{ $dashboardRoute }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('*.dashboard') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <!-- Petugas & Admin Shared Features -->
                    @if($role === 'Petugas' || $role === 'Administrator')
                        <div class="pt-4 pb-1">
                            <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Operasional</p>
                        </div>
                        <a href="{{ route('petugas.verifikasi.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('petugas.verifikasi.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Verifikasi Pengajuan
                        </a>
                        <a href="{{ route('petugas.review-laporan.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('petugas.review-laporan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Review Laporan Akhir
                        </a>
                        <a href="{{ route('petugas.bidang.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('petugas.bidang.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Kelola Bidang
                        </a>
                    @endif

                    <!-- Admin Only Features -->
                    @if($role === 'Administrator')
                        <div class="pt-4 pb-1">
                            <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Sistem & Admin</p>
                        </div>
                        <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.user.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.skm-pertanyaan.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.skm-pertanyaan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Konfigurasi SKM
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan Tahunan
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Logout Section at Bottom -->
            <div class="p-4 border-t border-green-900 bg-emerald-950">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-red-200 hover:bg-red-700 hover:text-white transition-all duration-200">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 shadow-sm">
                <!-- Greeting & Date -->
                <div>
                    <h1 class="text-sm font-medium text-gray-500">Selamat datang, <span class="font-bold text-gray-800">{{ auth()->user()->name }}</span></h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>

                <!-- Icons & User Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications Icon -->
                    <button class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-lg hover:bg-gray-50 relative">
                        <span class="sr-only">Notifications</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <!-- Ping indicator if any -->
                        <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    <!-- User Circle Avatar -->
                    <div class="w-8 h-8 rounded-full bg-biogen-medium text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- Page Dynamic Content -->
            <main class="flex-grow p-6 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

    </body>
</html>
