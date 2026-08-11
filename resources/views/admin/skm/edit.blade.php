<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.skm-pertanyaan.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Edit Pertanyaan SKM</h2>
        <p class="text-xs text-gray-400 mt-1">Perbarui indikator kepuasan pelayanan magang/PKL yang sudah ada.</p>
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
        <form method="POST" action="{{ route('admin.skm-pertanyaan.update', $skmPertanyaan->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Teks Pertanyaan -->
            <div>
                <x-input-label for="teks_pertanyaan" :value="__('Pernyataan / Teks Pertanyaan SKM')" />
                <textarea id="teks_pertanyaan" name="teks_pertanyaan" rows="4"
                    class="w-full rounded-xl border border-gray-200 text-xs text-gray-850 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition mt-1"
                    required>{{ old('teks_pertanyaan', $skmPertanyaan->teks_pertanyaan) }}</textarea>
                <x-input-error class="mt-1" :messages="$errors->get('teks_pertanyaan')" />
            </div>

            <!-- Urutan -->
            <div>
                <x-input-label for="urutan" :value="__('Nomor Urutan Tampil')" />
                <x-text-input id="urutan" name="urutan" type="number" class="mt-1 block w-full text-xs rounded-xl border-gray-200 focus:ring-biogen-medium focus:border-biogen-medium" :value="old('urutan', $skmPertanyaan->urutan)" min="1" required />
                <x-input-error class="mt-1" :messages="$errors->get('urutan')" />
            </div>

            <!-- Status Aktif -->
            <div>
                <x-input-label :value="__('Status Keaktifan')" />
                <div class="flex items-center space-x-4 mt-2">
                    <label for="status_aktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_aktif" name="is_active" value="1" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active', $skmPertanyaan->is_active) == '1' ? 'checked' : '' }}>
                        <span>Aktif (Ditampilkan dalam kuesioner)</span>
                    </label>
                    <label for="status_nonaktif" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="radio" id="status_nonaktif" name="is_active" value="0" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" {{ old('is_active', $skmPertanyaan->is_active) == '0' ? 'checked' : '' }}>
                        <span>Non-Aktif (Ditangguhkan)</span>
                    </label>
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('is_active')" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.skm-pertanyaan.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors">
                    Perbarui Pertanyaan
                </button>
            </div>
        </form>
    </div>
</x-layouts.internal>
