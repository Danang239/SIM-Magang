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

                <!-- Data Profil Responden (Auto-filled) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                        <div>
                            <h2 class="text-base font-bold text-gray-800 font-sans">Identitas Responden (Otomatis dari Formulir)</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Data identitas berikut ditarik secara otomatis dari berkas pendaftaran Anda.</p>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold text-[10px] rounded-lg tracking-wider uppercase">Auto-Filled</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-xs">
                        <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-150">
                            <p class="text-gray-400 font-medium">Nama Lengkap</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">{{ $pengajuan->user->name }}</p>
                        </div>
                        <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-150">
                            <p class="text-gray-400 font-medium">Jenis Kelamin</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">{{ $pengajuan->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-150">
                            <p class="text-gray-400 font-medium">Pendidikan Terakhir</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">{{ $pengajuan->pendidikan_terakhir ?? $pengajuan->jenjang }}</p>
                        </div>
                        <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-150">
                            <p class="text-gray-400 font-medium">Usia</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">
                                {{ $pengajuan->tanggal_lahir ? \Carbon\Carbon::parse($pengajuan->tanggal_lahir)->age . ' Tahun' : '-' }}
                            </p>
                        </div>
                        <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-150 sm:col-span-2">
                            <p class="text-gray-400 font-medium">Pekerjaan</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">Siswa / Mahasiswa (Peserta PKL)</p>
                        </div>
                    </div>

                    <!-- Pilihan Cepat Status Disabilitas -->
                    <div class="mt-5 pt-4 border-t border-gray-100" x-data="{ disabilitas: '{{ old('status_disabilitas', '') }}' }">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                            Status Penyandang Disabilitas <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mb-3">Silakan pilih salah satu opsi status penyandang disabilitas berikut:</p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center p-3 rounded-xl border cursor-pointer transition-all"
                                :class="disabilitas === 'Bukan Penyandang Disabilitas' ? 'bg-emerald-50 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-gray-50 border-gray-200 hover:border-emerald-300'">
                                <input type="radio" name="status_disabilitas" value="Bukan Penyandang Disabilitas" x-model="disabilitas" class="text-emerald-600 focus:ring-emerald-500 me-2.5" required>
                                <span class="text-xs font-bold text-gray-800">Bukan Penyandang Disabilitas</span>
                            </label>

                            <label class="flex items-center p-3 rounded-xl border cursor-pointer transition-all"
                                :class="disabilitas === 'Penyandang Disabilitas' ? 'bg-emerald-50 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-gray-50 border-gray-200 hover:border-emerald-300'">
                                <input type="radio" name="status_disabilitas" value="Penyandang Disabilitas" x-model="disabilitas" class="text-emerald-600 focus:ring-emerald-500 me-2.5" required>
                                <span class="text-xs font-bold text-gray-800">Penyandang Disabilitas</span>
                            </label>

                            <label class="flex items-center p-3 rounded-xl border cursor-pointer transition-all"
                                :class="disabilitas === 'Pendamping Penyandang Disabilitas' ? 'bg-emerald-50 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-gray-50 border-gray-200 hover:border-emerald-300'">
                                <input type="radio" name="status_disabilitas" value="Pendamping Penyandang Disabilitas" x-model="disabilitas" class="text-emerald-600 focus:ring-emerald-500 me-2.5" required>
                                <span class="text-xs font-bold text-gray-800">Pendamping Penyandang</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('status_disabilitas')" class="mt-1" />
                    </div>
                </div>

                <!-- Survei Kepuasan Masyarakat (SKM) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs rounded-lg uppercase tracking-wider mb-2">Pendapat Responden Tentang Pelayanan</span>
                        <h2 class="text-lg font-bold text-gray-800 font-sans">Instrumen Kuesioner SKM</h2>
                        <p class="text-xs text-gray-500 mt-1">Pilihlah salah satu jawaban yang paling menggambarkan pengalaman pelayanan yang Anda terima.</p>
                    </div>

                    <div class="space-y-6">
                        @foreach($pertanyaans as $index => $pertanyaan)
                            @php
                                $lower = strtolower($pertanyaan->teks_pertanyaan);
                                $isSesuai = str_contains($lower, 'persyaratan') || str_contains($lower, 'jangka waktu') || str_contains($lower, 'biaya') || str_contains($lower, 'produk');
                                $options = [
                                    4 => $isSesuai ? 'Sangat sesuai' : 'Sangat setuju',
                                    3 => $isSesuai ? 'Sesuai' : 'Setuju',
                                    2 => $isSesuai ? 'Tidak sesuai' : 'Tidak setuju',
                                    1 => $isSesuai ? 'Sangat tidak sesuai' : 'Sangat tidak setuju',
                                ];
                            @endphp
                            <div class="pb-5 border-b border-gray-100 last:border-0">
                                <p class="text-sm font-bold text-gray-800 mb-3 leading-relaxed">
                                    <span class="text-emerald-700 font-extrabold mr-1">{{ $index + 1 }}.</span>
                                    {{ $pertanyaan->teks_pertanyaan }} <span class="text-red-500">*</span>
                                </p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach($options as $val => $label)
                                        <label class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-emerald-500 hover:bg-emerald-50/40 cursor-pointer transition-all">
                                            <input type="radio"
                                                id="skm_{{ $pertanyaan->id }}_{{ $val }}"
                                                name="skm[{{ $pertanyaan->id }}]"
                                                value="{{ $val }}"
                                                class="text-emerald-600 focus:ring-emerald-500 me-3"
                                                {{ old("skm.{$pertanyaan->id}") == $val ? 'checked' : '' }}
                                                required>
                                            <span class="text-xs font-semibold text-gray-800">{{ $val }}. {{ $label }}</span>
                                        </label>
                                    @endforeach
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
                                placeholder="Tuliskan saran atau masukan Anda untuk perbaikan layanan PKL BRMP Biogen..."
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
