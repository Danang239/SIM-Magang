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
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password"
                    required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200
                           @error('password') border-red-400 bg-red-50 @enderror"
                    placeholder="Min. 8 karakter">
                @error('password')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Ulangi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all duration-200"
                    placeholder="Ulangi password">
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
