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
                Mulai perjalanan karir penelitian Anda bersama modernisasi bioteknologi pertanian. Daftarkan diri Anda secara online untuk program Magang, PKL, atau Penelitian secara terintegrasi.
            </p>
            
            <!-- Consolidated single call-to-action button -->
            <div class="flex justify-center items-center">
                @auth
                    @if(auth()->user()->hasRole('Pengguna'))
                        <a href="{{ route('pengguna.career.step1') }}" class="w-full sm:w-auto bg-biogen-medium hover:bg-biogen-light text-white text-base px-12 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 text-center">
                            Daftar Magang
                        </a>
                    @else
                        <a href="{{ auth()->user()->hasRole('Administrator') ? route('admin.dashboard') : route('petugas.dashboard') }}" class="w-full sm:w-auto bg-biogen-medium hover:bg-biogen-light text-white text-base px-12 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 text-center">
                            Masuk ke Panel Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('pengguna.career.step1') }}" class="w-full sm:w-auto bg-biogen-medium hover:bg-biogen-light text-white text-base px-12 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 text-center">
                        Daftar Magang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Alur Pendaftaran Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Mekanisme Pendaftaran Magang</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-lg mx-auto">Ikuti 4 langkah mudah untuk memulai program magang di lingkungan laboratorium BRMP Biogen.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-biogen-medium flex items-center justify-center font-extrabold text-xl rounded-xl mb-6 shadow-sm">1</div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">Registrasi Akun</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Buat akun portal pendaftaran menggunakan data diri yang valid, email aktif, nomor HP/WA, dan asal sekolah/universitas.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-biogen-medium flex items-center justify-center font-extrabold text-xl rounded-xl mb-6 shadow-sm">2</div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">Pilih Bidang & Kuota</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Pilih program laboratorium dan cari tanggal mulai pelaksanaan magang yang masih tersedia secara real-time pada sistem kalender bergulir.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-biogen-medium flex items-center justify-center font-extrabold text-xl rounded-xl mb-6 shadow-sm">3</div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">Unggah & Kuesioner</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Unggah file surat pengantar resmi instansi dalam format PDF/Gambar, isi instrumen kepuasan SKM, lalu kirim pengajuan Anda.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-biogen-medium flex items-center justify-center font-extrabold text-xl rounded-xl mb-6 shadow-sm">4</div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">Verifikasi & Mulai</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Pantau secara berkala. Petugas akan memproses berkas pendaftaran Anda. Jika disetujui, Anda siap memulai magang sesuai jadwal.</p>
                    </div>
                </div>
            </div>

            @guest
            <div class="mt-16 text-center">
                <p class="text-sm text-gray-600 font-medium">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-biogen-medium hover:text-biogen-light font-bold underline transition-colors">Masuk ke Portal</a></p>
            </div>
            @endguest
        </div>
    </section>

    <!-- Laboratorium & Bidang Penelitian Section -->
    <section class="py-20 bg-gray-50 border-t border-gray-150">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Laboratorium & Bidang Penelitian</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-lg mx-auto">Pelajari berbagai bidang riset dan laboratorium kami untuk mengidentifikasi kesesuaian dengan program studi Anda.</p>
            </div>

            <!-- Grid of Bidang Cards (Informational Only) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($bidangs as $b)
                    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                        
                        <div class="p-6">
                            <!-- Badge Jenjang & Kapasitas -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $b->jenjang === 'Mahasiswa' ? 'bg-blue-50 text-blue-750 border border-blue-150' : 'bg-orange-50 text-orange-750 border border-orange-150' }}">
                                    Jalur {{ $b->jenjang }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium">
                                    Kapasitas: <strong class="text-gray-800">{{ $b->kapasitas }} Slot</strong>
                                </span>
                            </div>

                            <!-- Bidang Title -->
                            <h3 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans">
                                {{ $b->nama_bidang }}
                            </h3>

                            <!-- Deskripsi -->
                            <p class="text-xs text-gray-500 leading-relaxed mb-6">
                                {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang penelitian ini.' }}
                            </p>
                        </div>

                  
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.publik>
