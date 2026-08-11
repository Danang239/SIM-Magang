<x-guest-layout>
    <!-- Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 font-sans">Masuk ke Portal</h1>
        <p class="text-gray-500 text-sm mt-1">Selamat datang kembali! Masukkan akun Anda.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 font-medium">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                       focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                       @error('email') border-red-400 bg-red-50 @enderror"
                placeholder="contoh@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-biogen-medium hover:text-biogen-dark font-semibold transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800
                       focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                       @error('password') border-red-400 bg-red-50 @enderror"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-gray-300 text-biogen-medium focus:ring-biogen-medium cursor-pointer">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Ingat saya</label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-biogen-medium hover:bg-biogen-dark text-white font-bold py-3 px-6 rounded-xl
                   shadow-sm hover:shadow-md transition-all duration-200 text-sm tracking-wide">
            Masuk
        </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-6">
        <div class="flex-1 h-px bg-gray-200"></div>
        <span class="px-4 text-xs text-gray-400 font-semibold uppercase tracking-wider">atau</span>
        <div class="flex-1 h-px bg-gray-200"></div>
    </div>

    <!-- Sign in with Google -->
    <a href="{{ route('auth.google') }}"
        class="flex items-center justify-center w-full px-4 py-3 border border-gray-200 rounded-xl bg-white
               hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow
               text-sm font-semibold text-gray-700 space-x-3 group">
        <!-- Google Icon -->
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        <span>Masuk dengan Google</span>
    </a>

    <!-- Register Link -->
    <p class="text-center text-sm text-gray-500 mt-8">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-biogen-medium hover:text-biogen-dark font-bold transition-colors">
            Daftar sekarang
        </a>
    </p>
</x-guest-layout>
