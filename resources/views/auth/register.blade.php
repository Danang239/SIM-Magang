<x-guest-layout>
    <!-- Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 font-sans">Buat Akun Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Daftarkan diri Anda untuk mengakses program magang.</p>
    </div>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                       focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                       @error('name') border-red-400 bg-red-50 @enderror"
                placeholder="Nama sesuai identitas">
            @error('name')
                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Aktif</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                       focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                       @error('email') border-red-400 bg-red-50 @enderror"
                placeholder="contoh@email.com">
            @error('email')
                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor HP & Instansi (2 kolom) -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor HP/WA</label>
                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}"
                    required autocomplete="tel"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                           @error('no_hp') border-red-400 bg-red-50 @enderror"
                    placeholder="08xxxxxxxxxx">
                @error('no_hp')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="instansi" class="block text-sm font-semibold text-gray-700 mb-1.5">Asal Instansi</label>
                <input id="instansi" type="text" name="instansi" value="{{ old('instansi') }}"
                    required autocomplete="organization"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                           @error('instansi') border-red-400 bg-red-50 @enderror"
                    placeholder="Nama sekolah/universitas">
                @error('instansi')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Program Studi -->
        <div>
            <label for="program_studi" class="block text-sm font-semibold text-gray-700 mb-1.5">Program Studi / Jurusan</label>
            <input id="program_studi" type="text" name="program_studi" value="{{ old('program_studi') }}"
                required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400
                       focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                       @error('program_studi') border-red-400 bg-red-50 @enderror"
                placeholder="Contoh: Teknik Informatika">
            @error('program_studi')
                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password & Konfirmasi (2 kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div x-data="{ showPass: false }">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <input id="password" :type="showPass ? 'text' : 'password'" name="password"
                        required autocomplete="new-password"
                        class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                               @error('password') border-red-400 bg-red-50 @enderror"
                        placeholder="Min. 8 karakter">
                    <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 focus:outline-none" tabindex="-1">
                        <svg x-show="!showPass" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPass" x-cloak class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div x-data="{ showConfirm: false }">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Ulangi Password</label>
                <div class="relative">
                    <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                        required autocomplete="new-password"
                        class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200"
                        placeholder="Ulangi password">
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 focus:outline-none" tabindex="-1">
                        <svg x-show="!showConfirm" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showConfirm" x-cloak class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-biogen-medium hover:bg-biogen-dark text-white font-bold py-3 px-6 rounded-xl
                   shadow-sm hover:shadow-md transition-all duration-200 text-sm tracking-wide mt-2">
            Buat Akun
        </button>
    </form>

    <!-- Login Link -->
    <p class="text-center text-sm text-gray-500 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-biogen-medium hover:text-biogen-dark font-bold transition-colors">
            Masuk di sini
        </a>
    </p>
</x-guest-layout>
