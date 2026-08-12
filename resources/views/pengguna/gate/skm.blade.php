<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Kuesioner Kepuasan Masyarakat</h1>
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

            <form method="POST" action="{{ route('pengguna.gate.skm.store', $pengajuan->id) }}">
                @csrf

                <!-- Survei Kepuasan Masyarakat (SKM) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-800 font-sans">Survei Kepuasan Masyarakat (SKM)</h2>
                        <p class="text-xs text-gray-500 mt-1">Berikan penilaian Anda untuk setiap pernyataan berikut. Skala: 1 (Sangat Tidak Setuju) – 5 (Sangat Setuju).</p>
                    </div>

                    <div class="space-y-6">
                        @foreach($pertanyaans as $index => $pertanyaan)
                            <div class="pb-5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <p class="text-sm font-semibold text-gray-700 mb-3">
                                    <span class="text-biogen-medium font-bold mr-1">{{ $index + 1 }}.</span>
                                    {{ $pertanyaan->teks_pertanyaan }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    @foreach([1,2,3,4,5] as $rating)
                                        <label for="skm_{{ $pertanyaan->id }}_{{ $rating }}" class="flex-1 cursor-pointer">
                                            <input type="radio"
                                                id="skm_{{ $pertanyaan->id }}_{{ $rating }}"
                                                name="skm[{{ $pertanyaan->id }}]"
                                                value="{{ $rating }}"
                                                class="sr-only peer"
                                                {{ old("skm.{$pertanyaan->id}") == $rating ? 'checked' : '' }}>
                                            <div class="text-center py-2 rounded-lg border-2 border-gray-200 hover:border-biogen-medium peer-checked:border-biogen-medium peer-checked:bg-biogen-medium peer-checked:text-white text-gray-500 font-bold text-sm transition-all duration-150 cursor-pointer">
                                                {{ $rating }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-between text-[10px] text-gray-400 mt-1 px-1">
                                    <span>Sangat Tidak Setuju</span>
                                    <span>Sangat Setuju</span>
                                </div>
                                <x-input-error :messages="$errors->get('skm.'.$pertanyaan->id)" class="mt-1" />
                            </div>
                        @endforeach

                        <!-- Saran Tambahan -->
                        <div class="pt-2">
                            <label for="skm_saran" class="block text-sm font-semibold text-gray-700 mb-2">
                                Saran / Masukan (Opsional)
                            </label>
                            <textarea id="skm_saran" name="skm_saran" rows="3"
                                class="w-full rounded-xl border border-gray-200 text-sm text-gray-800 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition"
                                placeholder="Tuliskan saran atau masukan Anda untuk perbaikan layanan magang BRMP Biogen..."
                                maxlength="2000">{{ old('skm_saran') }}</textarea>
                            <x-input-error :messages="$errors->get('skm_saran')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Jawaban SKM</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.publik>
