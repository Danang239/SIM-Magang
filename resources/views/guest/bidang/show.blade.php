<x-layouts.publik>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Detail Card -->
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm overflow-hidden">
                <!-- Header Banner -->
                <div class="h-64 sm:h-80 bg-emerald-950 relative overflow-hidden flex items-center justify-center">
                    @if($bidang->gambar)
                        <img src="{{ asset('storage/' . $bidang->gambar) }}" alt="{{ $bidang->nama_bidang }}" class="w-full h-full object-cover" />
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 to-emerald-950 opacity-95"></div>
                        <svg class="w-24 h-24 text-white/20 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    @endif

                    <div class="absolute bottom-6 left-6 right-6 z-10 text-white">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white" style="background-color: {{ strtolower($bidang->jenjang) === 'mahasiswa' ? '#2563eb' : '#ea580c' }};">
                                JALUR {{ strtoupper($bidang->jenjang) }}
                            </span>
                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-600 text-white">
                                Kategori {{ $bidang->kategori }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight font-sans">
                            {{ $bidang->nama_bidang }}
                        </h1>
                    </div>
                </div>

                <!-- Content Body -->
                <div class="p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-3 font-sans">Deskripsi Bidang</h2>
                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                {{ $bidang->deskripsi ?: 'Tidak ada deskripsi untuk bidang penelitian ini.' }}
                            </p>
                        </div>

                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-4 font-sans flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002-2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Job Description &amp; Aktivitas
                            </h2>

                            @if($bidang->jobdesc)
                                @php
                                    $rawJobdesc = trim($bidang->jobdesc);
                                    if (str_contains($rawJobdesc, "\n")) {
                                        $items = array_filter(array_map('trim', explode("\n", $rawJobdesc)));
                                    } else {
                                        $items = array_filter(array_map('trim', preg_split('/(?=\d+\.\s*)/', $rawJobdesc)));
                                    }
                                @endphp

                                <div class="space-y-3">
                                    @foreach($items as $item)
                                        @php
                                            $cleanItem = preg_replace('/^\d+\.\s*/', '', $item);
                                        @endphp
                                        @if(!empty($cleanItem))
                                            <div class="flex items-start p-4 bg-gray-50/80 rounded-2xl border border-gray-150 shadow-sm hover:border-emerald-300 hover:bg-emerald-50/40 transition-all duration-200">
                                                <div class="w-7 h-7 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mr-3.5 mt-0.5 shadow-sm">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <p class="text-sm text-gray-700 leading-relaxed font-medium">
                                                    {{ $cleanItem }}
                                                </p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm text-gray-500 italic bg-gray-50 p-5 rounded-2xl border border-gray-200">
                                    Belum ada detail deskripsi pekerjaan untuk program magang ini.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Sidebar Info & CTA -->
                    <div class="space-y-6" x-data="{ selectedPembimbing: '' }">
                        <div class="bg-gray-50 rounded-2xl border border-gray-150 p-6 space-y-5">
                            <h3 class="text-base font-bold text-gray-800 font-sans border-b border-gray-200 pb-3">Informasi Kuota &amp; Pembimbing</h3>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Kapasitas Total Bidang</span>
                                <span class="font-bold text-gray-800">{{ $kapasitasTotal }} Slot</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Total Sisa Kuota</span>
                                <span class="font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">{{ $sisaKuotaTotal }} Slot</span>
                            </div>

                            <!-- List Pembimbing & Pilihan Radio Button Opsional -->
                            <div id="container-pembimbing" class="pt-3 border-t border-gray-200 space-y-3 p-2 transition-all duration-300">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Pembimbing Lapangan <span class="text-red-500">* (Wajib)</span></label>
                                
                                @forelse($pembimbingWithQuota as $pembimbing)
                                    <label class="flex items-center justify-between p-3.5 rounded-xl border transition-all cursor-pointer"
                                        :class="selectedPembimbing == '{{ $pembimbing->id }}' ? 'bg-emerald-50/80 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-white border-gray-200 hover:border-emerald-300'">
                                        <div class="flex items-center space-x-3">
                                            <input type="radio" name="pembimbing_choice" value="{{ $pembimbing->id }}" x-model="selectedPembimbing" class="text-emerald-600 focus:ring-emerald-500">
                                            <div>
                                                <p class="font-bold text-gray-800 text-xs">{{ $pembimbing->nama ?? $pembimbing->name }}</p>
                                                <p class="text-[10px] text-gray-400">{{ $pembimbing->jabatan ?: 'Pembimbing Lapangan' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $pembimbing->sisa_kuota > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                            {{ $pembimbing->sisa_kuota }} Slot
                                        </span>
                                    </label>
                                @empty
                                    <div class="text-xs text-gray-500 italic p-3 bg-white rounded-xl border border-gray-200">
                                        Pembimbing belum ditentukan.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div>
                            @auth
                                @if(auth()->user()->hasRole('Pengguna'))
                                    <a x-bind:href="selectedPembimbing ? '{{ route('pengguna.career.step1') }}?bidang_id={{ $bidang->id }}&pembimbing_id=' + selectedPembimbing : '#'"
                                        @click="if(!selectedPembimbing) { window.showFloatingError('Silakan pilih salah satu Pembimbing Lapangan terlebih dahulu pada daftar.', document.getElementById('container-pembimbing'), 'Pilih Pembimbing Lapangan'); $event.preventDefault(); }"
                                        class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-4 rounded-xl font-bold shadow-md hover:shadow-lg transition-all duration-200"
                                        :class="!selectedPembimbing ? 'opacity-85 hover:bg-emerald-600 hover:shadow-md' : ''">
                                        Daftar Magang Sekarang
                                    </a>
                                @else
                                    <div class="text-center text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-xl p-4">
                                        Anda masuk sebagai <strong>{{ auth()->user()->roles->first()?->name }}</strong>. Silakan masuk menggunakan akun Pengguna untuk mendaftar.
                                    </div>
                                @endif
                            @else
                                <a x-bind:href="selectedPembimbing ? '{{ route('login') }}?redirect=' + encodeURIComponent('{{ route('pengguna.career.step1') }}?bidang_id={{ $bidang->id }}&pembimbing_id=' + selectedPembimbing) : '#'"
                                    @click="if(!selectedPembimbing) { window.showFloatingError('Silakan pilih salah satu Pembimbing Lapangan terlebih dahulu pada daftar.', document.getElementById('container-pembimbing'), 'Pilih Pembimbing Lapangan'); $event.preventDefault(); }"
                                    class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-4 rounded-xl font-bold shadow-md hover:shadow-lg transition-all duration-200"
                                    :class="!selectedPembimbing ? 'opacity-85 hover:bg-emerald-600 hover:shadow-md' : ''">
                                    Daftar Magang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.publik>
