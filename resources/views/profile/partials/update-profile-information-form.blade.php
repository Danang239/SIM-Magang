<section>
    <header class="mb-6">
        <h2 class="text-lg font-bold text-gray-800 font-sans">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-xs text-gray-500">
            {{ __("Perbarui data pribadi, foto profil, instansi, dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Foto Profil Avatar Section -->
        <div class="flex items-center space-x-5" x-data="{ photoName: null, photoPreview: null }">
            <!-- Current Avatar -->
            <div class="shrink-0 relative">
                <template x-if="!photoPreview">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                    @else
                        <div class="w-16 h-16 rounded-full bg-biogen-medium text-white flex items-center justify-center font-bold text-lg border border-emerald-600 shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </template>
                <!-- Preview Avatar (Alpine) -->
                <template x-if="photoPreview">
                    <img :src="photoPreview" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                </template>
            </div>

            <!-- Upload input -->
            <div>
                <x-input-label for="foto_profil" :value="__('Foto Profil')" class="mb-1" />
                <input type="file" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png" class="hidden" x-ref="photo"
                    @change="
                        const file = $refs.photo.files[0];
                        if (file) {
                            photoName = file.name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL(file);
                        }
                    ">
                <button type="button" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-xs px-3 py-1.5 rounded-lg font-bold shadow-sm transition-colors"
                    @click.prevent="$refs.photo.click()">
                    Pilih Foto Baru
                </button>
                <p class="text-[10px] text-gray-400 mt-1">JPEG, JPG, PNG. Maksimal 1MB.</p>
                <x-input-error class="mt-1" :messages="$errors->get('foto_profil')" />
            </div>
        </div>

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-sm rounded-xl border-gray-200" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-xs mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum terverifikasi.') }}
                        <button form="send-verification" class="underline text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-xs text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Nomor HP / WhatsApp -->
        <div>
            <x-input-label for="no_hp" :value="__('Nomor WhatsApp / HP')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200" :value="old('no_hp', $user->no_hp)" required placeholder="Contoh: 08123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>

        <!-- Asal Sekolah / Kampus (Instansi) -->
        <div>
            <x-input-label for="instansi" :value="__('Asal Sekolah / Universitas')" />
            <x-text-input id="instansi" name="instansi" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200" :value="old('instansi', $user->instansi)" required placeholder="Contoh: Institut Pertanian Bogor" />
            <x-input-error class="mt-2" :messages="$errors->get('instansi')" />
        </div>

        <!-- Program Studi / Jurusan -->
        <div>
            <x-input-label for="program_studi" :value="__('Program Studi / Jurusan')" />
            <x-text-input id="program_studi" name="program_studi" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200" :value="old('program_studi', $user->program_studi)" required placeholder="Contoh: Agronomi dan Hortikultura" />
            <x-input-error class="mt-2" :messages="$errors->get('program_studi')" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-sm px-6 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-emerald-600 font-semibold"
                >Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>
