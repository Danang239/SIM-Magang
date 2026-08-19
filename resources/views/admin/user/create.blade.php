<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.user.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Tambah Akun Petugas</h2>
        <p class="text-xs text-gray-400 mt-1">Daftarkan akun petugas/staf operasional lapangan baru BB-Biogen.</p>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <p class="font-bold">Gagal mendaftarkan petugas:</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Notice Email Wajib Asli -->
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs text-emerald-900 flex items-start space-x-3">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="font-bold text-emerald-950">Wajib Menggunakan Email Asli &amp; Aktif</p>
            <p class="mt-0.5 leading-relaxed text-emerald-800">
                Email petugas ini akan otomatis menerima <strong>notifikasi email pendaftaran magang/PKL baru</strong> dari pemohon yang memilih bidang pembimbingan petugas yang bersangkutan.
            </p>
        </div>
    </div>

    <div class="max-w-2xl bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap Petugas')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('name')" required placeholder="Contoh: Dr. Eko Wahyudi" />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Alamat Email Aktif (Wajib Asli)')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('email')" required placeholder="Contoh: eko.wahyudi@pertanian.go.id atau email@gmail.com" />
                <p class="text-[10px] text-gray-400 mt-1">Pastikan email dapat menerima pesan (inbox) untuk pemberitahuan pendaftaran pemohon.</p>
                <x-input-error class="mt-1" :messages="$errors->get('email')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor HP -->
                <div>
                    <x-input-label for="no_hp" :value="__('Nomor HP / WhatsApp')" />
                    <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('no_hp')" required placeholder="Contoh: 081234567890" />
                    <x-input-error class="mt-1" :messages="$errors->get('no_hp')" />
                </div>

                <!-- Instansi -->
                <div>
                    <x-input-label for="instansi" :value="__('Divisi / Balai BB-Biogen (Opsional)')" />
                    <x-text-input id="instansi" name="instansi" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('instansi', 'BB-Biogen')" placeholder="Contoh: Divisi Standardisasi" />
                    <x-input-error class="mt-1" :messages="$errors->get('instansi')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Kata Sandi')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error class="mt-1" :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" required placeholder="Ulangi kata sandi" />
                    <x-input-error class="mt-1" :messages="$errors->get('password_confirmation')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.user.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors">
                    Daftarkan Petugas
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
