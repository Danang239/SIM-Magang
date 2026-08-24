<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIM-MAGANG BRMP Biogen') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            html { scroll-behavior: smooth; }
        </style>

        <!-- Scripts (includes Alpine.js via Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen page-fade-enter"
          x-data="{ scrolled: false, mobileOpen: false }"
          @scroll.window.throttle.50ms="scrolled = window.scrollY > 20">
        
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
        
        <!-- Sticky Header (Navbar Putih / Transparan) -->
        <header :class="{
                    'bg-white border-b border-gray-200 shadow-sm text-gray-800': scrolled || !{{ json_encode(request()->routeIs('home')) }},
                    'bg-transparent border-transparent text-white absolute': !scrolled && {{ json_encode(request()->routeIs('home')) }}
                }"
                class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Brand / Logo -->
                    <div class="flex items-center space-x-2">
                        <a href="/" class="flex items-center space-x-2.5">
                            <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-9 h-9 object-contain shrink-0">
                            <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-800' : 'text-white'"
                                  class="font-bold text-xl tracking-tight font-sans transition-colors duration-300">
                                BRMP <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-biogen-medium' : 'text-biogen-light'">Biogen</span>
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-6">
                        <a href="/" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-medium transition-colors duration-300">Beranda</a>
                        @auth
                            @if(auth()->user()->hasRole('Pengguna'))
                                <a href="{{ route('pengguna.riwayat') }}" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-medium transition-colors duration-300">Riwayat</a>
                                <a href="{{ route('profile.edit') }}" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-medium transition-colors duration-300">Profil</a>
                            @else
                                <a href="{{ auth()->user()->hasRole('Administrator') ? route('admin.dashboard') : route('petugas.dashboard') }}" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-medium transition-colors duration-300">Panel Internal</a>
                            @endif
                        @endauth
                        <a href="{{ route('kontak') }}" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-medium transition-colors duration-300">Kontak</a>
                    </nav>

                    <!-- Desktop Auth Actions & Mobile Avatar + Hamburger -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden md:flex items-center space-x-3">
                            @auth
                                <div class="flex items-center space-x-4">
                                    <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-700' : 'text-emerald-100'" class="hidden sm:inline-block text-sm font-medium transition-colors duration-300">
                                        Hai, <span class="font-bold">{{ auth()->user()->name }}</span>
                                    </span>
                                    @if(auth()->user()->hasRole('Pengguna'))
                                        <a href="{{ route('profile.edit') }}" title="Edit Profil">
                                            @if(auth()->user()->foto_profil)
                                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500 shadow-sm shrink-0 hover:scale-105 transition-transform">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-biogen-medium flex items-center justify-center font-bold border border-emerald-200 shadow-sm shrink-0 hover:scale-105 transition-transform">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ auth()->user()->hasRole('Administrator') ? route('admin.dashboard') : route('petugas.dashboard') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-sm px-4 py-2 rounded-lg font-semibold shadow transition-all duration-200">
                                            Panel Dashboard
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-500 hover:text-red-650' : 'text-emerald-200 hover:text-red-400'" class="text-sm font-medium transition-colors ml-2">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-600 hover:text-biogen-medium' : 'text-white hover:text-biogen-light'" class="text-sm font-semibold transition-colors duration-300">Masuk</a>
                                <a href="{{ route('register') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-sm px-4 py-2 rounded-lg font-semibold shadow transition-all duration-200">
                                    Daftar Akun
                                </a>
                            @endauth
                        </div>

                        <!-- Mobile User Avatar + Hamburger Button -->
                        <div class="md:hidden flex items-center space-x-2">
                            @auth
                                <a href="{{ route('profile.edit') }}" class="shrink-0">
                                    @if(auth()->user()->foto_profil)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-emerald-500 shadow-sm">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                            @endauth

                            <button @click="mobileOpen = !mobileOpen" 
                                    :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                                    class="p-2 rounded-xl transition-colors focus:outline-none"
                                    aria-label="Toggle Mobile Menu">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Sleek Dropdown Navigation Panel -->
            <div x-show="mobileOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="-translate-y-4 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="translate-y-0 opacity-100"
                 x-transition:leave-end="-translate-y-4 opacity-0"
                 @click.away="mobileOpen = false"
                 class="md:hidden bg-white/95 backdrop-blur-2xl border-b border-gray-200/90 shadow-2xl px-5 pt-3 pb-6 space-y-4 text-gray-800">
                
                @auth
                    <!-- Logged In User Card for Mobile -->
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-900 to-emerald-950 text-white shadow-md flex items-center justify-between">
                        <div class="flex items-center space-x-3 min-w-0">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-400 shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-sm shrink-0 border border-emerald-500">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                <span class="inline-block text-[9px] font-extrabold text-emerald-200 uppercase tracking-wider bg-emerald-800/80 px-2 py-0.5 rounded-full mt-0.5">
                                    {{ auth()->user()->hasRole('Pengguna') ? 'Peserta Magang / PKL' : auth()->user()->roles->pluck('name')->first() }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" class="p-2 bg-emerald-800/70 hover:bg-emerald-700 text-emerald-100 rounded-xl transition-colors shrink-0" title="Edit Profil">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002-2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                @endauth

                <!-- Menu Links with Icons -->
                <div class="space-y-1 pt-1 font-medium">
                    <!-- Beranda -->
                    <a href="/" @click="mobileOpen = false" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-xs">Beranda</span>
                    </a>

                    @auth
                        @if(auth()->user()->hasRole('Pengguna'))
                            <!-- Riwayat -->
                            <a href="{{ route('pengguna.riwayat') }}" @click="mobileOpen = false" 
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengguna.riwayat') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-xs">Riwayat Pengajuan</span>
                            </a>

                            <!-- Edit Profil -->
                            <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" 
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('profile.*') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-xs">Edit Profil Saya</span>
                            </a>
                        @else
                            <!-- Dashboard Internal for Staff -->
                            <a href="{{ auth()->user()->hasRole('Administrator') ? route('admin.dashboard') : route('petugas.dashboard') }}" @click="mobileOpen = false" 
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-emerald-700 text-white font-bold shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                <span class="text-xs">Panel Internal Dashboard</span>
                            </a>
                        @endif
                    @endauth

                    <!-- Kontak -->
                    <a href="{{ route('kontak') }}" @click="mobileOpen = false" 
                       class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('kontak') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-xs">Informasi Kontak</span>
                    </a>
                </div>

                <!-- Bottom Auth Action Buttons for Guests or Logout for Users -->
                <div class="pt-2 border-t border-gray-100">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center space-x-2 py-2.5 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span>Keluar Aplikasi</span>
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}" @click="mobileOpen = false" class="text-center py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" @click="mobileOpen = false" class="text-center py-2.5 rounded-xl bg-biogen-medium text-white text-xs font-bold shadow-md hover:bg-biogen-light transition-colors">
                                Daftar Akun
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main :class="!{{ json_encode(request()->routeIs('home')) }} ? 'pt-16' : ''" class="flex-grow relative">

            <!-- Animated Toast Notifications Container -->
            @if(session('success') || session('error') || session('status') || session('warning') || session('info'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 7000)"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-20 right-6 z-50 max-w-sm w-full pointer-events-auto">
                    
                    @if(session('warning'))
                        <div class="bg-white border-l-4 border-amber-500 rounded-2xl shadow-2xl p-4 flex items-start space-x-3 border border-gray-100">
                            <div class="p-2 bg-amber-100 text-amber-700 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="flex-grow pt-0.5">
                                <h4 class="text-xs font-bold text-gray-900">Perhatian!</h4>
                                <p class="text-xs text-gray-600 font-medium mt-0.5">{{ session('warning') }}</p>
                            </div>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-white border-l-4 border-sky-500 rounded-2xl shadow-2xl p-4 flex items-start space-x-3 border border-gray-100">
                            <div class="p-2 bg-sky-100 text-sky-700 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-grow pt-0.5">
                                <h4 class="text-xs font-bold text-gray-900">Informasi</h4>
                                <p class="text-xs text-gray-600 font-medium mt-0.5">{{ session('info') }}</p>
                            </div>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif

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

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-10 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
                
                <!-- Left: Branding & Copyright -->
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3 text-center sm:text-left">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-7 h-7 object-contain">
                        <span class="font-bold text-white text-lg font-sans">BRMP <span class="text-emerald-400">Biogen</span></span>
                    </div>
                    <span class="hidden sm:inline text-gray-700">|</span>
                    <span class="text-xs text-gray-400">SIM-MAGANG &copy; {{ date('Y') }} Kementerian Pertanian RI</span>
                </div>

                <!-- Right: Social Media Icons with Links -->
                <div class="flex items-center space-x-3">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/brmp_biogen/" target="_blank" rel="noopener noreferrer" 
                       title="Instagram @brmp_biogen" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-pink-600 text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>

                    <!-- YouTube -->
                    <a href="https://www.youtube.com/@brmpbiogen" target="_blank" rel="noopener noreferrer" 
                       title="YouTube BRMP Biogen Official" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-red-600 text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>

                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@brmp_biogen" target="_blank" rel="noopener noreferrer" 
                       title="TikTok @brmp_biogen" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-black text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.96-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.33 1.52-1.37 2.52-.07 1.25.56 2.45 1.58 3.11.97.64 2.24.74 3.29.28 1.05-.44 1.83-1.47 1.95-2.61.07-2.72.03-5.45.04-8.17 0-3.03-.01-6.06.01-9.09z"/></svg>
                    </a>

                    <!-- X (Twitter) -->
                    <a href="https://x.com/brmp_biogen" target="_blank" rel="noopener noreferrer" 
                       title="X (Twitter) @brmp_biogen" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-slate-700 text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/biogen.kementan" target="_blank" rel="noopener noreferrer" 
                       title="Facebook BRMP Biogen Kementan" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-blue-600 text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.848 9 5.015V8z"/></svg>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/628111756776" target="_blank" rel="noopener noreferrer" 
                       title="WhatsApp Call Center" 
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-emerald-600 text-gray-400 hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.226 4.354-1.143z"/></svg>
                    </a>
                </div>

            </div>
        </footer>

    </body>
</html>
