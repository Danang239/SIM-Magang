<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program Magang & PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="3" />

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Badge Jenjang & Kategori -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <span class="bg-emerald-100 text-biogen-dark text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        Jenjang: {{ $jenjang }}
                    </span>
                    <span class="bg-emerald-100 text-biogen-dark text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        Kategori: {{ $kategori }}
                    </span>
                </div>
                <a href="{{ route('pengguna.career.step2') }}" class="text-xs text-gray-500 hover:text-biogen-medium transition-colors underline">
                    Ganti kategori
                </a>
            </div>

            <form method="POST" action="{{ route('pengguna.career.step3.store') }}">
                @csrf
                <input type="hidden" name="jenjang" value="{{ $jenjang }}">

                <!-- Pilih Bidang -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-1 font-sans">Pilih Bidang Magang</h2>
                    <p class="text-sm text-gray-500 mb-5">Pilih salah satu bidang penempatan yang tersedia untuk kategori {{ $kategori }} (Jenjang: {{ $jenjang }}).</p>

                    @if($bidangs->isEmpty())
                        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-gray-500 font-medium">Tidak ada bidang aktif untuk jenjang {{ $jenjang }} di kategori ini saat ini.</p>
                            <a href="{{ route('pengguna.career.step2') }}" class="mt-4 inline-block text-biogen-medium text-sm font-semibold underline">Kembali</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($bidangs as $bidang)
                                <label for="bidang_{{ $bidang->id }}" class="cursor-pointer group {{ $bidang->full ? 'opacity-60 cursor-not-allowed' : '' }}">
                                    <input type="radio" id="bidang_{{ $bidang->id }}" name="bidang_id" value="{{ $bidang->id }}"
                                        class="sr-only peer"
                                        {{ old('bidang_id') == $bidang->id ? 'checked' : '' }}
                                        {{ $bidang->full ? 'disabled' : '' }}>
                                    <div class="h-full bg-white p-5 rounded-2xl border-2 {{ $bidang->full ? 'border-gray-100' : 'border-gray-200 hover:border-biogen-medium hover:bg-emerald-50 peer-checked:border-biogen-medium peer-checked:bg-emerald-50 peer-checked:shadow-md' }} transition-all duration-200">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-bold text-gray-800 text-sm leading-snug pr-2">{{ $bidang->nama_bidang }}</h3>
                                            @if($bidang->full)
                                                <span class="shrink-0 text-[10px] bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full uppercase">Penuh</span>
                                            @else
                                                <span class="shrink-0 text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full uppercase">
                                                    {{ $bidang->slot_sisa }} Slot
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ Str::limit($bidang->deskripsi, 100) }}</p>
                                        @if($bidang->pembimbing)
                                            <div class="flex items-center space-x-2 text-xs text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span>Pembimbing: {{ $bidang->pembimbing->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('bidang_id')" class="mt-2" />
                    @endif
                </div>

                <!-- Durasi Magang -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Durasi Magang</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach([2, 3, 6] as $dur)
                            <label for="durasi_{{ $dur }}" class="cursor-pointer">
                                <input type="radio" id="durasi_{{ $dur }}" name="durasi_bulan" value="{{ $dur }}"
                                    class="sr-only peer"
                                    {{ old('durasi_bulan', 3) == $dur ? 'checked' : '' }}>
                                <div class="text-center p-4 rounded-xl border-2 border-gray-200 hover:border-biogen-medium peer-checked:border-biogen-medium peer-checked:bg-emerald-50 transition-all duration-200">
                                    <p class="text-2xl font-extrabold text-gray-800 peer-checked:text-biogen-dark">{{ $dur }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Bulan</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Keahlian / Kompetensi -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-2">Keahlian & Kompetensi</h3>
                    <p class="text-xs text-gray-500 mb-4">Jelaskan keahlian atau kompetensi relevan yang Anda miliki saat ini.</p>
                    <textarea name="keahlian" rows="4" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-biogen-medium focus:border-transparent transition-all"
                        placeholder="Contoh: Pemrograman Python, Analisis Data, Kimia Dasar, dll...">{{ old('keahlian') }}</textarea>
                    <x-input-error :messages="$errors->get('keahlian')" class="mt-2" />
                </div>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('pengguna.career.step2') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">
                        ← Kembali ke Kategori
                    </a>
                    <button type="submit" class="bg-biogen-medium hover:bg-biogen-dark text-white text-sm font-bold px-8 py-3 rounded-xl shadow hover:shadow-md transition-all duration-200">
                        Lanjut ke Pilih Tanggal →
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.publik>
