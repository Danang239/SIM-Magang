<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Formulir Biodata Peserta Magang</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Back to Dashboard Link -->
            <div class="mb-6">
                <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

            <!-- Error messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pengguna.gate.biodata.store', $pengajuan->id) }}">
                @csrf

                <!-- Biodata Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h2 class="text-lg font-bold text-gray-800 font-sans">Informasi Pribadi</h2>
                        <p class="text-xs text-gray-500 mt-1">Lengkapi biodata diri Anda secara akurat sesuai kartu identitas resmi.</p>
                    </div>

                    <!-- NIM / NISN -->
                    <div>
                        <x-input-label for="nim_nisn" :value="__('NIM / NISN')" />
                        <x-text-input id="nim_nisn" name="nim_nisn" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('nim_nisn')" required placeholder="Contoh: 1202203001 atau 2021004" />
                        <x-input-error class="mt-1" :messages="$errors->get('nim_nisn')" />
                    </div>

                    <!-- Lahir Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tempat Lahir -->
                        <div>
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('tempat_lahir')" required placeholder="Contoh: Bogor" />
                            <x-input-error class="mt-1" :messages="$errors->get('tempat_lahir')" />
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('tanggal_lahir')" required />
                            <x-input-error class="mt-1" :messages="$errors->get('tanggal_lahir')" />
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <x-input-label :value="__('Jenis Kelamin')" />
                        <div class="flex items-center space-x-6 mt-2">
                            <label for="jk_l" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 cursor-pointer">
                                <input type="radio" id="jk_l" name="jenis_kelamin" value="Laki-laki" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                <span>Laki-laki</span>
                            </label>
                            <label for="jk_p" class="flex items-center space-x-2 text-sm font-semibold text-gray-700 cursor-pointer">
                                <input type="radio" id="jk_p" name="jenis_kelamin" value="Perempuan" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <span>Perempuan</span>
                            </label>
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('jenis_kelamin')" />
                    </div>

                    <!-- Alamat -->
                    <div>
                        <x-input-label for="alamat" :value="__('Alamat Domisili Lengkap')" />
                        <textarea id="alamat" name="alamat" rows="4"
                            class="w-full rounded-xl border border-gray-200 text-sm text-gray-800 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition mt-1"
                            placeholder="Tulis alamat tempat tinggal Anda saat ini dengan lengkap (jalan, RT/RW, kelurahan, kecamatan, kota)..."
                            required>{{ old('alamat') }}</textarea>
                        <x-input-error class="mt-1" :messages="$errors->get('alamat')" />
                    </div>
                </div>

                <!-- Kontak Darurat Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h2 class="text-lg font-bold text-gray-800 font-sans">Hubungan & Kontak Darurat</h2>
                        <p class="text-xs text-gray-500 mt-1">Kontak yang dapat dihubungi segera oleh tim Biogen apabila terjadi keadaan darurat.</p>
                    </div>

                    <!-- Kontak Darurat Nama -->
                    <div>
                        <x-input-label for="kontak_darurat_nama" :value="__('Nama Lengkap Kontak Darurat')" />
                        <x-text-input id="kontak_darurat_nama" name="kontak_darurat_nama" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('kontak_darurat_nama')" required placeholder="Contoh: Nama Orang Tua / Wali / Saudara" />
                        <x-input-error class="mt-1" :messages="$errors->get('kontak_darurat_nama')" />
                    </div>

                    <!-- Lahir Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kontak Darurat No -->
                        <div>
                            <x-input-label for="kontak_darurat_no" :value="__('Nomor Telepon / HP')" />
                            <x-text-input id="kontak_darurat_no" name="kontak_darurat_no" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('kontak_darurat_no')" required placeholder="Contoh: +6281234567890" />
                            <x-input-error class="mt-1" :messages="$errors->get('kontak_darurat_no')" />
                        </div>

                        <!-- Hubungan Kontak Darurat -->
                        <div>
                            <x-input-label for="hubungan_kontak_darurat" :value="__('Hubungan')" />
                            <x-text-input id="hubungan_kontak_darurat" name="hubungan_kontak_darurat" type="text" class="mt-1 block w-full text-sm rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('hubungan_kontak_darurat')" required placeholder="Contoh: Ayah, Ibu, Wali, Kakak" />
                            <x-input-error class="mt-1" :messages="$errors->get('hubungan_kontak_darurat')" />
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Simpan Formulir Biodata</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.publik>
