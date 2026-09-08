<x-layouts.internal>
    <div class="mb-8">
        <a href="{{ route('admin.pembimbing.index') }}" class="inline-flex items-center space-x-1.5 text-xs text-gray-500 hover:text-biogen-medium font-semibold mb-3 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Kelola Pembimbing</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans">Tambah Master Pembimbing</h2>
        <p class="text-xs text-gray-400 mt-1">Tambahkan data pembimbing baru yang dapat dipilih oleh calon peserta magang.</p>
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

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin.pembimbing.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Lengkap & Gelar -->
            <div>
                <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Nama Lengkap & Gelar <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                    class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Contoh: Dr. Ir. Mastur, M.Si.">
            </div>

            <!-- Grid: NIP & Jabatan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nip" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        NIP (Nomor Induk Pegawai)
                    </label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                        placeholder="Contoh: 197001011995031001">
                </div>
                <div>
                    <label for="jabatan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Jabatan / Posisi Riset
                    </label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', 'Peneliti / Pembimbing Lapangan') }}"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                        placeholder="Contoh: Peneliti Ahli Madya">
                </div>
            </div>

            <!-- Grid: Email & No HP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Alamat Email (Untuk Tembusan Info)
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                        placeholder="Contoh: nama@biogen.go.id">
                </div>
                <div>
                    <label for="no_hp" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Nomor HP / WhatsApp
                    </label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                        class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                        placeholder="Contoh: 081234567890">
                </div>
            </div>

            <!-- Kuota Default -->
            <div>
                <label for="kuota_default" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Kapasitas Kuota Default (Peserta) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kuota_default" id="kuota_default" value="{{ old('kuota_default', 5)" min="1" max="50" required
                    class="w-full md:w-48 text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition">
                <p class="text-[11px] text-gray-400 mt-1">Jumlah maksimal mahasiswa yang dapat dibimbing dalam rentang tanggal bersamaan.</p>
            </div>

            <!-- Pilih Bidang yang Dibimbing -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Bidang PKL yang Dibina
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($bidangs as $b)
                        <label class="flex items-center space-x-2.5 p-3 rounded-xl border border-gray-200 hover:border-biogen-medium hover:bg-emerald-50/50 cursor-pointer transition">
                            <input type="checkbox" name="bidang_ids[]" value="{{ $b->id }}"
                                {{ in_array($b->id, old('bidang_ids', [])) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-biogen-medium focus:ring-biogen-medium">
                            <span class="text-xs font-semibold text-gray-700">{{ $b->nama_bidang }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="flex items-center space-x-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-biogen-medium focus:ring-biogen-medium">
                    <span class="text-xs font-bold text-gray-700">Aktifkan Pembimbing (Dapat dipilih oleh pendaftar)</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pembimbing.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-biogen-medium hover:bg-biogen-dark text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition">
                    Simpan Pembimbing
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
