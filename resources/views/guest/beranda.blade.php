<x-layouts.publik>
    <!-- Hero Section (Full Width, Dark Green Gradient Overlay) -->
    <section class="relative bg-emerald-950 text-white overflow-hidden py-24 sm:py-32">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-800 via-emerald-950 to-emerald-950 opacity-90 z-0"></div>
        
        <!-- Custom PNG background image overlay -->
        <div class="absolute inset-0 opacity-15 bg-cover bg-center z-0" style="background-image: url('{{ asset('background.png') }}');"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <span class="inline-block bg-biogen-light/20 text-biogen-light px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-6 border border-biogen-light/30 shadow-sm">
                Balai Besar Penelitian Biogen
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight font-sans mb-6 leading-tight">
                Sistem Informasi Manajemen Magang & PKL
                <br class="hidden sm:inline" />
                <span class="text-biogen-light font-bold">BRMP Biogen</span>
            </h1>
            <p class="text-base sm:text-lg text-emerald-100 max-w-2xl mx-auto mb-10 font-sans font-light leading-relaxed">
                Mulai perjalanan karir penelitian Anda bersama modernisasi bioteknologi pertanian. Pilih bidang penelitian di bawah ini untuk memulai pendaftaran program Magang atau PKL Anda.
            </p>
            
            <div class="flex justify-center items-center">
                <a href="#daftar-section" class="w-full sm:w-auto bg-biogen-medium hover:bg-biogen-light text-white text-base px-12 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 text-center">
                    Pilih Bidang Magang
                </a>
            </div>
        </div>
    </section>

    <!-- Laboratorium & Bidang Penelitian Section -->
    <section id="daftar-section" class="py-20 bg-gray-50 border-t border-gray-150 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Laboratorium & Bidang Penelitian</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-lg mx-auto">Silakan pilih salah satu bidang penelitian di bawah untuk melihat detail informasi dan kuota yang tersedia.</p>
            </div>

            <!-- Kategori Pertanian -->
            <div class="mb-16">
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3">
                    <span class="p-2 bg-emerald-100 text-emerald-800 rounded-lg">
                        <!-- Grass/Leaf Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Pertanian</h3>
                </div>

                @if($bidangsPertanian->isEmpty())
                    <p class="text-gray-500 text-sm italic">Belum ada bidang pertanian yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsPertanian as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-emerald-900 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-700 to-emerald-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $b->jenjang === 'Mahasiswa' ? 'bg-blue-500 text-white border border-blue-600' : 'bg-orange-500 text-white border border-orange-600' }}">
                                                Jalur {{ $b->jenjang }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-emerald-750 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang penelitian ini.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="px-6 pb-6 pt-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 font-medium">
                                    <span>Kapasitas: <strong class="text-gray-800">{{ $b->kapasitas }} Slot</strong></span>
                                    <span class="text-emerald-600 font-bold group-hover:underline">Lihat Detail →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Kategori Non Pertanian -->
            <div>
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3">
                    <span class="p-2 bg-blue-100 text-blue-800 rounded-lg">
                        <!-- Desktop/Server Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Non Pertanian</h3>
                </div>

                @if($bidangsNonPertanian->isEmpty())
                    <p class="text-gray-500 text-sm italic">Belum ada bidang non pertanian yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsNonPertanian as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-md hover:border-blue-500 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-slate-900 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-slate-700 to-slate-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $b->jenjang === 'Mahasiswa' ? 'bg-blue-500 text-white border border-blue-600' : 'bg-orange-500 text-white border border-orange-600' }}">
                                                Jalur {{ $b->jenjang }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-blue-750 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang penelitian ini.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="px-6 pb-6 pt-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 font-medium">
                                    <span>Kapasitas: <strong class="text-gray-800">{{ $b->kapasitas }} Slot</strong></span>
                                    <span class="text-blue-600 font-bold group-hover:underline">Lihat Detail →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- Section Alur Pendaftaran Magang / PKL (Alur Sekarang) -->
    <section class="py-20 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-emerald-100 text-emerald-800 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    Prosedur &amp; Tahapan
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Alur Pendaftaran Magang &amp; PKL</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">
                    Tahapan pendaftaran hingga pelaksanaan magang di BRMP Biogen secara sistematis dan terintegrasi secara digital.
                </p>
            </div>

            <!-- Steps Timeline Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative">
                
                <!-- Step 1 -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            1
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pilih Bidang &amp; Tanggal</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pilih bidang penelitian yang sesuai di atas, tentukan durasi magang (1-3 bulan), dan tentukan tanggal rencana mulai.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Langkah 1 Wizard
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            2
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Biodata &amp; Surat Pengantar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Lengkapi biodata lengkap, nomor kontak darurat, dan unggah Surat Pengantar Resmi (PDF) dari Instansi/Sekolah/Kampus.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Langkah 2 Wizard
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            3
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Verifikasi &amp; Surat Balasan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Petugas memverifikasi kelayakan pengajuan. Jika disetujui, petugas akan mengunggah Surat Balasan Resmi.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verifikasi Petugas
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            4
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pengisian SKM &amp; Terjadwal</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pemohon mengisi kuesioner Survei Kepuasan Masyarakat (SKM) singkat. Status otomatis beralih menjadi <strong>Terjadwal</strong> &amp; Surat Balasan dapat diunduh.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002-2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Post-Approval Gate
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            5
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pelaksanaan &amp; Laporan Akhir</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Peserta melaksanakan magang hingga selesai, mengunggah Laporan Akhir pada sistem, dan mengunduh Surat Keterangan / Sertifikat Selesai Magang.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        Selesai Magang
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.publik>
