<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('petugas.bidang.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Tambah Bidang Penempatan</h2>
        <p class="text-xs text-gray-400 mt-1">Buat divisi penempatan magang/PKL baru beserta kriteria & pembimbingnya.</p>
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
        <form method="POST" action="{{ route('petugas.bidang.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Bidang -->
            <div>
                <x-input-label for="nama_bidang" :value="__('Nama Bidang / Divisi Penempatan')" />
                <x-text-input id="nama_bidang" name="nama_bidang" type="text" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('nama_bidang')" required placeholder="Contoh: Pemuliaan Tanaman Hortikultura" />
                <x-input-error class="mt-1" :messages="$errors->get('nama_bidang')" />
            </div>

            <!-- Deskripsi -->
            <div>
                <x-input-label for="deskripsi" :value="__('Deskripsi Singkat Bidang')" />
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full rounded-xl border border-gray-200 text-xs text-gray-850 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition mt-1"
                    placeholder="Ringkasan atau gambaran umum mengenai bidang penelitian ini..."
                    required>{{ old('deskripsi') }}</textarea>
                <x-input-error class="mt-1" :messages="$errors->get('deskripsi')" />
            </div>

            <!-- Job Description & Aktivitas -->
            <div>
                <x-input-label for="jobdesc" :value="__('Job Description & Aktivitas Magang')" />
                <textarea id="jobdesc" name="jobdesc" rows="5"
                    class="w-full rounded-xl border border-gray-200 text-xs text-gray-850 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition mt-1"
                    placeholder="Detail poin-poin aktivitas harian, tugas praktikum, sterilisasi, isolasi, atau pengelolaan laboratorium/kebun... (Dapat diisi berupa daftar poin-poin)">{{ old('jobdesc') }}</textarea>
                <p class="text-[10px] text-gray-400 mt-1">Informasi ini akan ditampilkan pada detail bidang saat calon peserta memilih tempat magang.</p>
                <x-input-error class="mt-1" :messages="$errors->get('jobdesc')" />
            </div>

            <!-- Jenjang, Kategori & Kapasitas Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Jenjang Pendidikan -->
                <div>
                    <x-input-label for="jenjang" :value="__('Jenjang Pendidikan')" />
                    <select id="jenjang" name="jenjang"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="Mahasiswa" {{ old('jenjang') === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Kategori Kuliah)</option>
                        <option value="Siswa" {{ old('jenjang') === 'Siswa' ? 'selected' : '' }}>Siswa (Kategori SMK/SMA)</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('jenjang')" />
                </div>

                <!-- Kategori Bidang -->
                <div>
                    <x-input-label for="kategori" :value="__('Kategori Bidang')" />
                    <select id="kategori" name="kategori"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 mt-1 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Pertanian" {{ old('kategori') === 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Non Pertanian" {{ old('kategori') === 'Non Pertanian' ? 'selected' : '' }}>Non Pertanian</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('kategori')" />
                </div>

                <!-- Kapasitas Slot -->
                <div>
                    <x-input-label for="kapasitas" :value="__('Kapasitas Slot')" />
                    <x-text-input id="kapasitas" name="kapasitas" type="number" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('kapasitas', 5)" min="1" max="100" required />
                    <x-input-error class="mt-1" :messages="$errors->get('kapasitas')" />
                </div>
            </div>

            <!-- Pembimbing -->
            <!-- Multi-Petugas Pembimbing & Kuota -->
            <div class="bg-gray-50/70 p-5 rounded-2xl border border-gray-200/80 space-y-4">
                <div>
                    <x-input-label :value="__('Petugas Pembimbing & Kuota Bimbingan Spesifik')" />
                    <p class="text-[11px] text-gray-500 mt-0.5">Satu bidang dapat dibimbing oleh lebih dari 1 Petugas. Setiap petugas dapat menentukan kuota bimbingan masing-masing.</p>
                </div>

                <div class="space-y-3">
                    @foreach($pembimbings as $p)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 bg-white rounded-xl border border-gray-200 shadow-sm gap-3"
                             x-data="{ checked: {{ in_array($p->id, old('petugas_ids', [])) ? 'true' : 'false' }} }">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="petugas_ids[]" value="{{ $p->id }}" x-model="checked"
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <p class="font-bold text-xs text-gray-800">{{ $p->name }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $p->email }} • Role: {{ $p->roles->pluck('name')->first() }}</p>
                                </div>
                            </label>

                            <div class="flex items-center space-x-2 pl-7 sm:pl-0" x-show="checked">
                                <span class="text-xs font-medium text-gray-500">Kuota Bimbingan:</span>
                                <input type="number" name="kuota_petugas[{{ $p->id }}]"
                                    value="{{ old('kuota_petugas.' . $p->id, 5) }}"
                                    min="1" max="100"
                                    class="w-20 rounded-lg border-gray-300 text-xs text-center font-bold focus:border-emerald-500 focus:ring-emerald-500">
                                <span class="text-xs text-gray-400 font-medium">Slot</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('petugas_ids')" />
            </div>

            <!-- Status Aktif -->
            <div>
                <x-input-label :value="__('Status Keaktifan')" />
                <div class="flex items-center space-x-4 mt-2">
                    <label for="status_aktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_aktif" name="is_active" value="1" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                        <span>Aktif (Dapat dipilih oleh pendaftar)</span>
                    </label>
                    <label for="status_nonaktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_nonaktif" name="is_active" value="0" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active') == '0' ? 'checked' : '' }}>
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
                    Simpan Bidang
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
