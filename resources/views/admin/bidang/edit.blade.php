<x-layouts.internal>
    <div class="mb-8">
        <a href="{{ route('admin.bidang.index') }}" class="inline-flex items-center space-x-1.5 text-xs text-gray-500 hover:text-biogen-medium font-semibold mb-3 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Kelola Bidang</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans">Edit Bidang Penempatan</h2>
        <p class="text-xs text-gray-400 mt-1">Perbarui informasi, kriteria, kuota, atau daftar pembimbing untuk {{ $bidang->nama_bidang }}.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700 space-y-1">
            <div class="font-bold flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mohon perbaiki beberapa kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside ml-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 max-w-4xl">
        <form action="{{ route('admin.bidang.update', $bidang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Bidang -->
            <div>
                <label for="nama_bidang" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Nama Bidang / Laboratorium <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_bidang" id="nama_bidang" value="{{ old('nama_bidang', $bidang->nama_bidang) }}" required
                    class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Contoh: Kultur Jaringan / Biologi Molekuler">
            </div>

            <!-- Grid: Jenjang & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="jenjang" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Target Jenjang Pendidikan <span class="text-red-500">*</span>
                    </label>
                    <select name="jenjang" id="jenjang" required
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none bg-white transition">
                        <option value="Mahasiswa" {{ old('jenjang', $bidang->jenjang) === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (D3/D4/S1/S2)</option>
                        <option value="Siswa" {{ old('jenjang', $bidang->jenjang) === 'Siswa' ? 'selected' : '' }}>Siswa (SMK/SMA Sederajat)</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Kategori Bidang <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" required
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none bg-white transition">
                        <option value="Mahasiswa" {{ old('kategori', $bidang->kategori) === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Perguruan Tinggi)</option>
                        <option value="Siswa" {{ old('kategori', $bidang->kategori) === 'Siswa' ? 'selected' : '' }}>Siswa (SMK / SMA Sederajat)</option>
                    </select>
                </div>
            </div>

            <!-- Ruang Lingkup Bidang -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Ruang Lingkup Bidang <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required
                    class="w-full text-xs rounded-xl border border-gray-200 p-4 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Jelaskan ruang lingkup kegiatan dan fokus utama di laboratorium/divisi ini...">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
            </div>

            <!-- Penugasan Pembimbing & Kuota Khusus -->
            @php
                $assignedPembimbingMap = $bidang->pembimbings->keyBy('id');
            @endphp
            <div class="pt-4 border-t border-gray-100">
                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                        Pilih Pembimbing & Kuota untuk Bidang Ini
                    </label>
                    <p class="text-[11px] text-gray-400">Centang pembimbing yang ditugaskan membina bidang ini dan atur alokasi kapasitas kuotanya.</p>
                </div>

                <div class="space-y-3">
                    @forelse($pembimbings as $p)
                        @php
                            $isAssigned = $assignedPembimbingMap->has($p->id);
                            $currentQuota = $isAssigned ? ($assignedPembimbingMap[$p->id]->pivot->kuota ?? $p->kuota_default) : $p->kuota_default;
                        @endphp
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-200 hover:border-biogen-medium bg-gray-50/50 hover:bg-emerald-50/20 transition">
                            <label class="flex items-center space-x-3 cursor-pointer flex-grow">
                                <input type="checkbox" name="pembimbing_ids[]" value="{{ $p->id }}"
                                    {{ in_array($p->id, old('pembimbing_ids', $bidang->pembimbings->pluck('id')->toArray())) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-biogen-medium focus:ring-biogen-medium">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">{{ $p->nama }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $p->nip ? 'NIP: '.$p->nip.' • ' : '' }}{{ $p->jabatan ?? 'Pembimbing' }}</p>
                                </div>
                            </label>
                            <div class="flex items-center space-x-2 shrink-0">
                                <span class="text-[11px] font-semibold text-gray-500">Kuota:</span>
                                <input type="number" name="kuota_pembimbing[{{ $p->id }}]"
                                    value="{{ old('kuota_pembimbing.'.$p->id, $currentQuota) }}" min="1" max="50"
                                    class="w-20 text-xs text-center rounded-lg border border-gray-200 py-1.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none bg-white">
                                <span class="text-[10px] text-gray-400">slot</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700">
                            Belum ada master data pembimbing yang aktif. Anda dapat menambahkannya terlebih dahulu di menu <a href="{{ route('admin.pembimbing.create') }}" class="font-bold underline">Kelola Pembimbing</a>.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upload Gambar Cover -->
            <div class="pt-4 border-t border-gray-100">
                <label for="gambar" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Foto / Banner Bidang
                </label>
                @if($bidang->gambar)
                    <div class="mb-3 flex items-center space-x-3">
                        <img src="{{ asset('storage/' . $bidang->gambar) }}" alt="{{ $bidang->nama_bidang }}" class="w-16 h-16 object-cover rounded-xl border border-gray-200 shadow-sm">
                        <span class="text-xs text-gray-500">Foto saat ini terpasang. Unggah file baru jika ingin menggantinya.</span>
                    </div>
                @endif
                <input type="file" name="gambar" id="gambar" accept="image/*"
                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-biogen-medium hover:file:bg-emerald-100">
                <p class="text-[10px] text-gray-400 mt-1">Maksimal ukuran file 5MB. Format JPG, PNG, atau WEBP.</p>
            </div>

            <!-- Status Aktif -->
            <div>
                <label class="flex items-center space-x-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bidang->is_active) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-biogen-medium focus:ring-biogen-medium">
                    <span class="text-xs font-bold text-gray-700">Aktifkan Bidang Ini (Tampilkan di halaman pendaftaran peserta)</span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.bidang.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-biogen-medium hover:bg-biogen-dark text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
