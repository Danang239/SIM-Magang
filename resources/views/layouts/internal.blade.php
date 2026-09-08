@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIP BRMP Biogen') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo-brmp.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-biogen-bg flex min-h-screen page-fade-enter" x-data="{ sidebarOpen: false }">

        <!-- Top Loading Progress Bar -->
        <div id="page-progress-bar" 
             class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-300 z-[9999] transition-all duration-300 ease-out w-0 shadow-[0_0_10px_rgba(16,185,129,0.9)] opacity-0 pointer-events-none"></div>

        <style>
            .page-fade-enter {
                opacity: 0;
                transition: opacity 0.22s ease-out;
            }
            .page-fade-active {
                opacity: 1;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                requestAnimationFrame(() => {
                    document.body.classList.add('page-fade-active');
                });

                const bar = document.getElementById('page-progress-bar');
                
                document.addEventListener('click', (e) => {
                    const anchor = e.target.closest('a');
                    if (!anchor) return;

                    const href = anchor.getAttribute('href');
                    const target = anchor.getAttribute('target');

                    if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                        if (anchor.hostname === window.location.hostname) {
                            if (bar) {
                                bar.style.opacity = '1';
                                bar.style.width = '75%';
                            }
                        }
                    }
                });

                window.addEventListener('beforeunload', () => {
                    if (bar) {
                        bar.style.opacity = '1';
                        bar.style.width = '100%';
                    }
                });
            });
        </script>

        <!-- 1. DESKTOP SIDEBAR (Hidden on mobile, flex on LG screens) -->
        <aside class="hidden lg:flex w-64 bg-biogen-dark text-white flex-col justify-between shrink-0 shadow-lg border-r border-green-900">
            <div>
                <!-- Logo Section -->
                <div class="px-6 py-5 border-b border-green-900 flex items-center space-x-3 bg-emerald-950">
                    <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-9 h-9 object-contain shrink-0">
                    <div>
                        <h1 class="font-bold text-lg tracking-tight font-sans text-white">SIP Biogen</h1>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <!-- Operasional PKL -->
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Layanan & PKL</p>
                    </div>
                    <a href="{{ route('admin.riwayat-pengajuan.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.riwayat-pengajuan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pengajuan & Verifikasi
                    </a>
                    <a href="{{ route('admin.bidang.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.bidang.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Kelola Bidang
                    </a>
                    <a href="{{ route('admin.pembimbing.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.pembimbing.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Kelola Pembimbing
                    </a>

                    <!-- Sistem & Admin -->
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Sistem & Laporan</p>
                    </div>
                    <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.user.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.skm-pertanyaan.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.skm-pertanyaan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfigurasi SKM
                    </a>
                    <a href="{{ route('admin.rekap-skm.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.rekap-skm.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                        <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Rekap SKM
                    </a>
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

        <!-- 2. MOBILE SLIDE-OVER DRAWER SIDEBAR (Visible when sidebarOpen is true on LG screens) -->
        <div x-show="sidebarOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex lg:hidden">
            <!-- Backdrop Overlay -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            <!-- Drawer Content -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative max-w-xs w-full bg-biogen-dark text-white flex flex-col justify-between shadow-2xl z-10">
                <div>
                    <!-- Logo & Close Button -->
                    <div class="px-6 py-5 border-b border-green-900 flex items-center justify-between bg-emerald-950">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-8 h-8 object-contain">
                            <div>
                                <h1 class="font-bold text-base tracking-tight text-white">SIP Biogen</h1>
                                <p class="text-[9px] text-green-200 tracking-wider font-semibold uppercase">SIM-MAGANG</p>
                            </div>
                        </div>
                        <button @click="sidebarOpen = false" class="text-green-200 hover:text-white p-1 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- User Identity Card -->
                    <div class="p-4 mx-4 my-4 bg-emerald-950/60 rounded-xl border border-green-900 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-biogen-light text-biogen-dark flex items-center justify-center font-bold text-sm shadow">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h2 class="font-bold text-xs truncate leading-snug">{{ auth()->user()->name }}</h2>
                            <span class="inline-block text-[9px] px-2 py-0.5 mt-0.5 rounded-full font-bold uppercase tracking-wider bg-white text-biogen-dark shadow-sm">
                                {{ auth()->user()->roles->pluck('name')->first() }}
                            </span>
                        </div>
                    </div>

                    <!-- Menu Navigation Mobile -->
                    <nav class="px-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <div class="pt-3 pb-1">
                            <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Layanan & PKL</p>
                        </div>
                        <a href="{{ route('admin.riwayat-pengajuan.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.riwayat-pengajuan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Pengajuan & Verifikasi
                        </a>
                        <a href="{{ route('admin.bidang.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.bidang.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Kelola Bidang
                        </a>
                        <a href="{{ route('admin.pembimbing.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.pembimbing.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Kelola Pembimbing
                        </a>

                        <div class="pt-3 pb-1">
                            <p class="px-4 text-[10px] font-bold text-green-300 uppercase tracking-wider">Sistem & Admin</p>
                        </div>
                        <a href="{{ route('admin.user.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.user.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.skm-pertanyaan.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.skm-pertanyaan.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Konfigurasi SKM
                        </a>
                        <a href="{{ route('admin.rekap-skm.index') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-biogen-medium hover:text-white transition-all duration-200 {{ request()->routeIs('admin.rekap-skm.*') ? 'bg-biogen-medium text-white shadow-md' : 'text-green-100' }}">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Rekap SKM
                        </a>
                    </nav>
                </div>

                <!-- Logout Button Mobile -->
                <div class="p-4 border-t border-green-900 bg-emerald-950">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-red-200 hover:bg-red-700 hover:text-white transition-all duration-200">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0 shadow-sm">
                <!-- Hamburger Button (Mobile) & Greeting -->
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 focus:outline-none" aria-label="Open Sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-xs sm:text-sm font-medium text-gray-500">Selamat datang, <span class="font-bold text-gray-800">{{ auth()->user()->name }}</span></h1>
                        <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5 hidden sm:block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <!-- Icons & User Profile -->
                <div class="flex items-center space-x-3">
                    @php
                        $pendingVerifikasiCount = \App\Models\Pengajuan::where('status', 'Menunggu Verifikasi')->count();
                    @endphp

                    <!-- Notifications Icon (Quick Link to Verifikasi Queue) -->
                    <a href="{{ route('admin.riwayat-pengajuan.index', ['status' => 'Menunggu Verifikasi']) }}" 
                       title="{{ $pendingVerifikasiCount > 0 ? $pendingVerifikasiCount . ' Pengajuan Menunggu Verifikasi' : 'Semua pengajuan sudah diverifikasi' }}"
                       class="text-gray-400 hover:text-emerald-700 transition-colors p-2 rounded-xl hover:bg-emerald-50 relative group">
                        <span class="sr-only">Notifikasi Verifikasi</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($pendingVerifikasiCount > 0)
                            <!-- Active Red Ping Badge -->
                            <span class="absolute top-1 right-1 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            </span>
                        @endif
                    </a>

                    <!-- User Circle Avatar (Quick Link to Profile Edit) -->
                    <a href="{{ route('profile.edit') }}" 
                       title="Edit Profil Saya ({{ auth()->user()->name }})" 
                       class="w-9 h-9 rounded-full bg-biogen-medium hover:bg-biogen-dark text-white flex items-center justify-center font-bold text-xs shadow-sm hover:ring-2 hover:ring-emerald-500/50 hover:scale-105 transition-all duration-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </a>
                </div>
            </header>

            <!-- Page Dynamic Content -->
            <main class="flex-grow p-6 overflow-y-auto relative">

                <!-- Animated Toast Notifications Container -->
                @if(session('success') || session('error') || session('status'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="translate-x-full opacity-0"
                         x-transition:enter-end="translate-x-0 opacity-100"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="translate-x-0 opacity-100"
                         x-transition:leave-end="translate-x-full opacity-0"
                         class="fixed top-20 right-6 z-50 max-w-sm w-full pointer-events-auto">
                        
                        @if(session('success'))
                            <div class="bg-white border-l-4 border-emerald-500 rounded-2xl shadow-2xl p-4 flex items-start space-x-3 border border-gray-100">
                                <div class="p-2 bg-emerald-100 text-emerald-700 rounded-xl shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-grow pt-0.5">
                                    <h4 class="text-xs font-bold text-gray-900">Berhasil!</h4>
                                    <p class="text-xs text-gray-600 font-medium mt-0.5">{{ session('success') }}</p>
                                </div>
                                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-white border-l-4 border-red-500 rounded-2xl shadow-2xl p-4 flex items-start space-x-3 border border-gray-100">
                                <div class="p-2 bg-red-100 text-red-700 rounded-xl shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <div class="flex-grow pt-0.5">
                                    <h4 class="text-xs font-bold text-gray-900">Peringatan / Gagal</h4>
                                    <p class="text-xs text-gray-600 font-medium mt-0.5">{{ session('error') }}</p>
                                </div>
                                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="bg-white border-l-4 border-blue-500 rounded-2xl shadow-2xl p-4 flex items-start space-x-3 border border-gray-100">
                                <div class="p-2 bg-blue-100 text-blue-700 rounded-xl shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="flex-grow pt-0.5">
                                    <h4 class="text-xs font-bold text-gray-900">Informasi</h4>
                                    <p class="text-xs text-gray-600 font-medium mt-0.5">{{ session('status') }}</p>
                                </div>
                                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

    </body>
</html>
