<x-layouts.publik>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight font-sans">Laboratorium & Bidang Penelitian</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-2xl leading-relaxed">
                Temukan laboratorium dan bidang riset yang tersedia di Balai Besar Pengujian Standar Instrumen Bioteknologi (BB-Biogen) untuk menunjang program Praktik Kerja Lapangan (PKL) Anda.
            </p>
        </div>

        <!-- Grid of Bidang Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($bidangs as $b)
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    
                    <!-- Top section with background accent -->
                    <div class="p-6 pb-4">
                        <!-- Badge Jenjang -->
                        <div class="flex justify-between items-center mb-4">
                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $b->jenjang === 'Mahasiswa' ? 'bg-blue-50 text-blue-750 border border-blue-150' : 'bg-orange-50 text-orange-750 border border-orange-150' }}">
                                Jalur {{ $b->jenjang }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">
                                Kapasitas: <strong class="text-gray-800">{{ $b->kapasitas }} Slot</strong>
                            </span>
                        </div>

                        <!-- Bidang Title -->
                        <h2 class="text-lg font-bold text-gray-800 font-sans leading-snug mb-3">
                            {{ $b->nama_bidang }}
                        </h2>

                        <!-- Ruang Lingkup Bidang -->
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">
                            {{ $b->deskripsi ?: 'Tidak ada informasi ruang lingkup untuk bidang penelitian ini.' }}
                        </p>
                    </div>

                    <!-- Bottom details and call-to-action button -->
                    <div class="p-6 pt-0 mt-auto border-t border-gray-50 bg-gray-50/50">
                        <div class="flex items-center space-x-3 py-3 text-xs text-gray-500">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 text-biogen-medium flex items-center justify-center font-bold border border-emerald-150">
                                {{ $b->pembimbing ? strtoupper(substr($b->pembimbing->name, 0, 1)) : '?' }}
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pembimbing</p>
                                <p class="font-semibold text-gray-700">{{ $b->pembimbing ? $b->pembimbing->name : 'Belum ditentukan' }}</p>
                            </div>
                        </div>

                        <a href="{{ route('pengguna.career.step1') }}" 
                           class="block w-full text-center bg-biogen-medium hover:bg-biogen-light text-white text-xs py-2.5 rounded-xl font-bold shadow-sm transition-all duration-200 mt-2">
                            Ajukan PKL di Bidang Ini
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Section Alur Pendaftaran PKL -->
        <div class="mt-20 pt-12 border-t border-gray-200">
            <div class="text-center mb-12">
                <span class="inline-block bg-emerald-100 text-emerald-800 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    Prosedur &amp; Tahapan
                </span>
                <h2 class="text-2xl font-extrabold text-gray-900 font-sans tracking-tight">Alur Pendaftaran PKL</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">
                    Tahapan pendaftaran hingga pelaksanaan PKL di BRMP Biogen secara sistematis dan terintegrasi secara digital.
                </p>
            </div>

            <!-- Steps Timeline Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative">
                
                <!-- Step 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            1
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pilih Bidang &amp; Tanggal</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pilih bidang penelitian yang sesuai di atas, tentukan durasi PKL, dan tentukan tanggal rencana mulai.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Langkah 1 Wizard
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            2
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Biodata &amp; Surat Pengantar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Lengkapi biodata lengkap, nomor kontak darurat, dan unggah Surat Pengantar Resmi (PDF) dari Instansi/Sekolah/Kampus.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Langkah 2 Wizard
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            3
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Verifikasi &amp; Surat Balasan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Petugas memverifikasi kelayakan pengajuan. Jika disetujui, petugas akan mengunggah Surat Balasan Resmi.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verifikasi Petugas
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            4
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pengisian SKM &amp; Terjadwal</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pemohon mengisi kuesioner Survei Kepuasan Masyarakat (SKM) singkat. Status otomatis beralih menjadi <strong>Terjadwal</strong> &amp; Surat Balasan dapat diunduh.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002-2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Post-Approval Gate
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            5
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pelaksanaan &amp; Selesai PKL</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Peserta melaksanakan PKL di BRMP Biogen hingga batas waktu yang ditentukan. Status otomatis menjadi <strong>Selesai</strong> setelah tanggal PKL berakhir.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Selesai PKL
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.publik>
