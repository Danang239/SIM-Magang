<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-lg font-bold text-red-600 font-sans flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-xs text-gray-500 leading-relaxed">
            {{ __('Setelah akun Anda dihapus, semua data profil, histori pendaftaran magang, dan berkas terkait akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.') }}
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-sm px-5 py-2.5 rounded-xl font-bold transition-all duration-200 shadow-2xs hover:shadow-sm inline-flex items-center gap-2"
    >
        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        {{ __('Hapus Akun Saya') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="p-2.5 bg-red-100 text-red-600 rounded-2xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-gray-900 font-sans">
                        {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                    </h2>
                    <span class="text-xs text-red-500 font-semibold">Tindakan ini permanen dan tidak dapat dipulihkan</span>
                </div>
            </div>

            <p class="text-xs text-gray-600 leading-relaxed bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                {{ __('Setelah akun dihapus, seluruh data berkas, riwayat pendaftaran, dan informasi akun akan dihapus permanen dari sistem. Silakan masukkan kata sandi Anda untuk mengonfirmasi.') }}
            </p>

            <div class="mt-5" x-data="{ showPass: false }">
                <x-input-label for="password" value="{{ __('Kata Sandi Akun') }}" class="text-xs font-bold text-gray-700 mb-1" />

                <div class="relative mt-1">
                    <input id="password" name="password" :type="showPass ? 'text' : 'password'" 
                           class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 focus:ring-red-500 focus:border-red-500 text-sm transition-colors" 
                           placeholder="Masukkan kata sandi Anda untuk konfirmasi" />
                    <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 focus:outline-none" tabindex="-1">
                        <svg x-show="!showPass" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPass" x-cloak class="w-4.5 h-4.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
