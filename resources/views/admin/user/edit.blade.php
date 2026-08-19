<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.user.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Edit Akun Pengguna</h2>
        <p class="text-xs text-gray-400 mt-1">Perbarui data profil, informasi divisi, dan role hak akses user.</p>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <p class="font-bold">Gagal memperbarui pengguna:</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.user.update', $user->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('name', $user->name)" required />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Alamat Email Aktif (Wajib Asli)')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('email', $user->email)" required />
                <p class="text-[10px] text-gray-400 mt-1">Apabila akun bertindak sebagai Petugas Pembimbing, email ini akan menerima notifikasi pendaftaran dari pemohon.</p>
                <x-input-error class="mt-1" :messages="$errors->get('email')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor HP -->
                <div>
                    <x-input-label for="no_hp" :value="__('Nomor HP / WhatsApp')" />
                    <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('no_hp', $user->no_hp)" required />
                    <x-input-error class="mt-1" :messages="$errors->get('no_hp')" />
                </div>

                <!-- Instansi -->
                <div>
                    <x-input-label for="instansi" :value="__('Instansi / Sekolah')" />
                    <x-text-input id="instansi" name="instansi" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('instansi', $user->instansi)" />
                    <x-input-error class="mt-1" :messages="$errors->get('instansi')" />
                </div>
            </div>

            <!-- Hak Akses / Role -->
            <div>
                <x-input-label for="role" :value="__('Hak Akses / Role Sistem')" />
                <select id="role" name="role"
                    class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white" required>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ old('role', $user->roles->pluck('name')->first()) === $r->name ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-1" :messages="$errors->get('role')" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.user.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
