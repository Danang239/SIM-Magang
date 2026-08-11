<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program Magang & PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="5" />

            <!-- Ringkasan Pilihan -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Ringkasan Pengajuan Anda</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Jenjang</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $step3['jenjang'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Bidang</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $bidang->nama_bidang }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Mulai</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ \Carbon\Carbon::parse($step4['tanggal_mulai'])->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Selesai (Rencana)</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ \Carbon\Carbon::parse($step4['tanggal_selesai_rencana'])->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
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

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('pengguna.career.store') }}" enctype="multipart/form-data">
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

                <!-- Upload Surat Pengantar -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
                    <h2 class="text-lg font-bold text-gray-800 font-sans mb-1">Surat Pengantar Resmi</h2>
                    <p class="text-xs text-gray-500 mb-5">Unggah surat pengantar resmi dari sekolah atau universitas Anda. Format: PDF, JPG, PNG (Maks. 2MB).</p>

                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-biogen-medium transition-colors"
                        x-data="{ fileName: '' }"
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if(f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                        "
                        @dragover.prevent>
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <template x-if="!fileName">
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Seret & lepas file di sini, atau</p>
                                <label for="file_surat_pengantar" class="cursor-pointer bg-biogen-medium hover:bg-biogen-light text-white text-xs px-4 py-2 rounded-lg font-bold shadow transition-all duration-200 inline-block">
                                    Pilih File
                                </label>
                            </div>
                        </template>
                        <template x-if="fileName">
                            <div>
                                <p class="text-sm font-semibold text-biogen-dark" x-text="fileName"></p>
                                <button type="button" class="text-xs text-gray-400 hover:text-red-500 mt-1 transition-colors" @click="fileName = ''; $refs.fileInput.value = ''">Hapus</button>
                            </div>
                        </template>
                        <input type="file"
                            id="file_surat_pengantar"
                            name="file_surat_pengantar"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="hidden"
                            x-ref="fileInput"
                            @change="fileName = $event.target.files[0]?.name ?? ''">
                        <p class="text-[10px] text-gray-400 mt-3">Format: PDF, JPG, PNG • Maks. 2MB</p>
                    </div>
                    <x-input-error :messages="$errors->get('file_surat_pengantar')" class="mt-2" />
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('pengguna.career.step4') }}" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Kembali</span>
                    </a>
                    <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Pengajuan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.publik>
