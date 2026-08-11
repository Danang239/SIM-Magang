<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('petugas.bidang.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Edit Bidang Penempatan</h2>
        <p class="text-xs text-gray-400 mt-1">Perbarui data divisi penempatan magang/PKL yang sudah ada.</p>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <p class="font-bold">Gagal menyimpan data:</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('petugas.bidang.update', $bidang->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Bidang -->
            <div>
                <x-input-label for="nama_bidang" :value="__('Nama Bidang / Divisi Penempatan')" />
                <x-text-input id="nama_bidang" name="nama_bidang" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('nama_bidang', $bidang->nama_bidang)" required placeholder="Contoh: Pemuliaan Tanaman Hortikultura" />
                <x-input-error class="mt-1" :messages="$errors->get('nama_bidang')" />
            </div>

            <!-- Deskripsi -->
            <div>
                <x-input-label for="deskripsi" :value="__('Deskripsi Bidang')" />
                <textarea id="deskripsi" name="deskripsi" rows="5"
                    class="w-full rounded-xl border border-gray-200 text-xs text-gray-850 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition mt-1"
                    placeholder="Uraikan detail pekerjaan, tugas, laboratorium yang digunakan, atau alat-alat pendukung dalam bidang ini..."
                    required>{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
                <x-input-error class="mt-1" :messages="$errors->get('deskripsi')" />
            </div>

            <!-- Jenjang, Kategori & Kapasitas Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Jenjang Pendidikan -->
                <div>
                    <x-input-label for="jenjang" :value="__('Jenjang Pendidikan')" />
                    <select id="jenjang" name="jenjang"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="Mahasiswa" {{ old('jenjang', $bidang->jenjang) === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Kategori Kuliah)</option>
                        <option value="Siswa" {{ old('jenjang', $bidang->jenjang) === 'Siswa' ? 'selected' : '' }}>Siswa (Kategori SMK/SMA)</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('jenjang')" />
                </div>

                <!-- Kategori Bidang -->
                <div>
                    <x-input-label for="kategori" :value="__('Kategori Bidang')" />
                    <select id="kategori" name="kategori"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Pertanian" {{ old('kategori', $bidang->kategori) === 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Non Pertanian" {{ old('kategori', $bidang->kategori) === 'Non Pertanian' ? 'selected' : '' }}>Non Pertanian</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('kategori')" />
                </div>

                <!-- Kapasitas Slot -->
                <div>
                    <x-input-label for="kapasitas" :value="__('Kapasitas Slot')" />
                    <x-text-input id="kapasitas" name="kapasitas" type="number" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('kapasitas', $bidang->kapasitas)" min="1" max="100" required />
                    <x-input-error class="mt-1" :messages="$errors->get('kapasitas')" />
                </div>
            </div>

            <!-- Pembimbing -->
            <div>
                <x-input-label for="pembimbing_id" :value="__('Pembimbing Lapangan')" />
                <select id="pembimbing_id" name="pembimbing_id"
                    class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white">
                    <option value="">-- Pilih Pembimbing (Opsional) --</option>
                    @foreach($pembimbings as $p)
                        <option value="{{ $p->id }}" {{ old('pembimbing_id', $bidang->pembimbing_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} ({{ $p->roles->pluck('name')->first() }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-400 mt-1">Daftar ini memuat user dengan role Petugas & Admin.</p>
                <x-input-error class="mt-1" :messages="$errors->get('pembimbing_id')" />
            </div>

            <!-- Status Aktif -->
            <div>
                <x-input-label :value="__('Status Keaktifan')" />
                <div class="flex items-center space-x-4 mt-2">
                    <label for="status_aktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_aktif" name="is_active" value="1" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active', $bidang->is_active) == '1' ? 'checked' : '' }}>
                        <span>Aktif (Dapat dipilih oleh pendaftar)</span>
                    </label>
                    <label for="status_nonaktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_nonaktif" name="is_active" value="0" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active', $bidang->is_active) == '0' ? 'checked' : '' }}>
                        <span>Non-Aktif (Ditangguhkan)</span>
                    </label>
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('is_active')" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                <a href="{{ route('petugas.bidang.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors">
                    Perbarui Bidang
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
