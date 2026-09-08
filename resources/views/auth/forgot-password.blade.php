<x-guest-layout>
    <!-- Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 font-sans">Lupa Password?</h1>
        <p class="text-gray-500 text-sm mt-1 leading-relaxed">
            Tidak masalah. Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk membuat kata sandi baru.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email yang Terdaftar</label>
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

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-biogen-medium hover:bg-biogen-dark text-white font-bold py-3 px-6 rounded-xl
                       shadow-sm hover:shadow-md transition-all duration-200 text-sm tracking-wide">
                Kirim Tautan Reset Password
            </button>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-biogen-dark font-semibold transition-colors">
                &larr; Kembali ke halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>
