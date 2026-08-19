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

        <!-- Scripts (includes Alpine.js via Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen"
          x-data="{ scrolled: false }"
          @scroll.window="scrolled = window.scrollY > 15">
        
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
                        <a href="/" class="flex items-center space-x-2">
                            <!-- DNA/Leaf Minimalist Icon -->
                            <svg :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-biogen-medium' : 'text-white'"
                                 class="w-8 h-8 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18M12 3a9 9 0 019 9m-9-9a9 9 0 00-9 9m9 9a9 9 0 019-9m-9 9a9 9 0 00-9-9M6 12h12M9 8h6M9 16h6" />
                            </svg>
                            <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-800' : 'text-white'"
                                  class="font-bold text-xl tracking-tight font-sans transition-colors duration-300">
                                BRMP <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-biogen-medium' : 'text-biogen-light'">Biogen</span>
                            </span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
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

                    <!-- Auth Actions -->
                    <div class="flex items-center space-x-3">
                        @auth
                            <div class="flex items-center space-x-4">
                                <span :class="scrolled || !{{ json_encode(request()->routeIs('home')) }} ? 'text-gray-700' : 'text-emerald-100'" class="hidden sm:inline-block text-sm font-medium transition-colors duration-300">
                                    Hai, <span class="font-bold">{{ auth()->user()->name }}</span>
                                </span>
                                @if(auth()->user()->hasRole('Pengguna'))
                                    @if(auth()->user()->foto_profil)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500 shadow-sm shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-biogen-medium flex items-center justify-center font-bold border border-emerald-200 shadow-sm shrink-0">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
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
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main :class="!{{ json_encode(request()->routeIs('home')) }} ? 'pt-16' : ''" class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-white text-lg font-sans">BRMP <span class="text-biogen-light">Biogen</span></span>
                    <span class="text-xs border-l border-gray-700 pl-2">SIM-MAGANG &copy; {{ date('Y') }}</span>
                </div>
                <div class="text-xs text-center md:text-right">
                    Kementerian Pertanian Republik Indonesia | Hak Cipta Dilindungi Undang-Undang.
                </div>
            </div>
        </footer>

    </body>
</html>
