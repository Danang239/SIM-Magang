<x-layouts.publik>
    <!-- Floating & Scroll Reveal Animations Style -->
    <style>
        @keyframes hero-float-1 {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes hero-float-2 {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-14px); }
        }
        @keyframes hero-float-3 {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-hero-float-1 { animation: hero-float-1 3.6s ease-in-out infinite; }
        .animate-hero-float-2 { animation: hero-float-2 4.2s ease-in-out infinite 0.6s; }
        .animate-hero-float-3 { animation: hero-float-3 3.0s ease-in-out infinite 1.1s; }

        /* Scroll Reveal Smooth Transitions */
        .reveal-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -40px 0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-scroll').forEach(el => observer.observe(el));
        });
    </script>

    <!-- Full-Screen Hero Section (Green Gradient Background) -->
    <section class="relative text-white overflow-hidden min-h-screen flex items-center pt-20" style="background: linear-gradient(135deg, #042f1d 0%, #0B5E3C 50%, #094d31 100%);">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-12 z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- LEFT COLUMN: Badge, Title, Description, Button -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight font-sans text-white leading-tight">
                        Sistem Informasi PKL <br />
                        <span class="text-amber-300 italic font-black">BRMP Biogen</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm sm:text-base text-emerald-100 font-sans font-medium leading-relaxed opacity-95 max-w-xl text-justify">
                        SIP Merupakan platform untuk mendukung layanan jasa guna untuk memfasilitasi mahasiswa/siswa melaksanakan praktik kerja lapangan di bidang Bio Teknologi, Sumber Daya Genetik Pertanian, Hubungan Masyarakat, Teknologi Informasi, dan Administrasi.
                    </p>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <a href="#daftar-section" class="inline-block bg-biogen-medium hover:bg-biogen-light text-white text-base px-10 py-3.5 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all duration-200 uppercase tracking-wider">
                            Bidang PKL
                        </a>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Hero Person Illustration + Floating Cards -->
                <div class="lg:col-span-6 flex justify-center lg:justify-end items-center mt-10 lg:mt-0 py-6">
                    <div class="relative w-full max-w-[320px] sm:max-w-[360px] lg:max-w-[380px]">
                        
                        <!-- Center Illustration -->
                        <img src="{{ asset('hero-person.png') }}"
                             class="w-full h-auto drop-shadow-2xl hover:scale-[1.01] transition-transform duration-300 relative z-10"
                             alt="SIM-MAGANG BRMP Biogen Hero Illustration" />

                        <!-- Floating Card 1: Topik & Pembimbing (Top Left) -->
                        <div class="absolute -top-10 -left-10 sm:-left-24 lg:-left-32 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-1 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Topik &amp; Pembimbing</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Pastikan ketersediaan kuota</p>
                            </div>
                        </div>

                        <!-- Floating Card 2: Surat Pengantar (Top Right) -->
                        <div class="absolute -top-8 -right-8 sm:-right-20 lg:-right-24 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-2 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-xl shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Surat Pengantar</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Dari kampus / sekolah asal</p>
                            </div>
                        </div>

                        <!-- Floating Card 3: Daftar di SIP (Middle Left) -->
                        <div class="absolute top-[38%] -left-14 sm:-left-28 lg:-left-36 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-3 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-xl shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Daftar di SIP</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Upload &amp; notif email masuk</p>
                            </div>
                        </div>

                        <!-- Floating Card 4: Verifikasi Admin (Middle Right) -->
                        <div class="absolute top-[52%] -right-8 sm:-right-18 lg:-right-24 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-1 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-xl shrink-0 border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Verifikasi Admin</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Pemeriksaan &amp; surat balasan</p>
                            </div>
                        </div>

                        <!-- Floating Card 5: Surat Balasan (Bottom Left) -->
                        <div class="absolute -bottom-10 -left-10 sm:-left-24 lg:-left-32 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-2 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Surat Balasan Email</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Hasil diterima via email &amp; web</p>
                            </div>
                        </div>

                        <!-- Floating Card 6: SLA Kepastian Waktu (Bottom Right) -->
                        <div class="absolute -bottom-10 -right-6 sm:-right-16 lg:-right-20 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-3 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-teal-50 text-teal-600 rounded-xl shrink-0 border border-teal-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Maksimal 5 Hari Kerja</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Verifikasi cepat &amp; transparan</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Animated Statistics Counter Bar (2 Data Items Centered) -->
    <div class="bg-white border-y border-gray-200 py-8 relative z-20 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <!-- Stat 1: Total Bidang Penempatan -->
                <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50/90 to-gray-50/80 border border-emerald-100 hover:border-emerald-300 transition-all duration-300 reveal-scroll shadow-sm flex items-center space-x-4">
                    <div class="p-3.5 bg-emerald-600 text-white rounded-2xl shrink-0 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div x-data="{ count: 0, target: {{ $bidangsMahasiswa->count() + $bidangsSiswa->count() }}, animate() { let step = Math.max(1, Math.ceil(this.target / 25)); let timer = setInterval(() => { this.count += step; if(this.count >= this.target) { this.count = this.target; clearInterval(timer); } }, 50); } }"
                         x-init="let observer = new IntersectionObserver((entries) => { if(entries[0].isIntersecting) { animate(); observer.disconnect(); } }, { threshold: 0.5 }); observer.observe($el);">
                        <div class="text-3xl sm:text-4xl font-black text-gray-900 font-sans tracking-tight" x-text="count + ' Bidang'">0 Bidang</div>
                        <p class="text-xs font-extrabold text-emerald-800 uppercase tracking-wider mt-0.5">Bidang Penempatan</p>
                    </div>
                </div>

                <!-- Stat 2: Total Kapasitas Kuota -->
                <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50/90 to-gray-50/80 border border-emerald-100 hover:border-emerald-300 transition-all duration-300 reveal-scroll shadow-sm flex items-center space-x-4">
                    <div class="p-3.5 bg-emerald-600 text-white rounded-2xl shrink-0 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div x-data="{ count: 0, target: {{ $bidangsMahasiswa->sum('kapasitas') + $bidangsSiswa->sum('kapasitas') }}, animate() { let step = Math.max(1, Math.ceil(this.target / 30)); let timer = setInterval(() => { this.count += step; if(this.count >= this.target) { this.count = this.target; clearInterval(timer); } }, 40); } }"
                         x-init="let observer = new IntersectionObserver((entries) => { if(entries[0].isIntersecting) { animate(); observer.disconnect(); } }, { threshold: 0.5 }); observer.observe($el);">
                        <div class="text-3xl sm:text-4xl font-black text-gray-900 font-sans tracking-tight" x-text="count + ' Slot'">0 Slot</div>
                        <p class="text-xs font-extrabold text-emerald-800 uppercase tracking-wider mt-0.5">Total Kapasitas Kuota</p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Bidang PKL Section -->
    <section id="daftar-section" class="py-20 bg-gray-50 border-t border-gray-150 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal-scroll">
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Bidang PKL</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-lg mx-auto">Silakan pilih bidang PKL di bawah untuk melihat detail informasi dan kuota yang tersedia.</p>
            </div>

            <!-- Kategori Mahasiswa -->
            <div class="mb-16">
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3 reveal-scroll">
                    <span class="p-2 bg-blue-100 text-blue-800 rounded-lg">
                        <!-- Academic Cap / Student Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Mahasiswa</h3>
                </div>

                @if($bidangsMahasiswa->isEmpty())
                    <p class="text-gray-500 text-sm italic reveal-scroll">Belum ada bidang kategori mahasiswa yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsMahasiswa as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-blue-500 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-blue-950 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-slate-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white bg-blue-600">
                                                JALUR {{ strtoupper($b->jenjang) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-blue-700 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang PKL ini.' }}
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

            <!-- Kategori Siswa -->
            <div>
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3 reveal-scroll">
                    <span class="p-2 bg-amber-100 text-amber-800 rounded-lg">
                        <!-- School/Book Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Siswa</h3>
                </div>

                @if($bidangsSiswa->isEmpty())
                    <p class="text-gray-500 text-sm italic reveal-scroll">Belum ada bidang kategori siswa yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsSiswa as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-amber-500 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-amber-950 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-amber-700 to-amber-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white bg-amber-600">
                                                JALUR {{ strtoupper($b->jenjang) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-amber-700 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang PKL ini.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="px-6 pb-6 pt-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 font-medium">
                                    <span>Kapasitas: <strong class="text-gray-800">{{ $b->kapasitas }} Slot</strong></span>
                                    <span class="text-amber-600 font-bold group-hover:underline">Lihat Detail →</span>
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
            <div class="text-center mb-16 reveal-scroll">
                <span class="inline-block bg-emerald-100 text-emerald-800 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    Prosedur &amp; Tahapan
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Alur Pendaftaran PKL</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">
                    Tahapan pendaftaran PKL di BRMP Biogen secara sistematis dan terintegrasi secara digital.
                </p>
            </div>

            <!-- Steps Timeline Grid (5 Steps) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 relative">
                
                <!-- Step 1 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-base mb-3 shadow-sm">
                            1
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-1.5 leading-snug">Cek Topik &amp; Pembimbing</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Memastikan ketersediaan topik dan kuota pembimbing lapangan pada bidang PKL yang dituju.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Pilih Bidang
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-base mb-3 shadow-sm">
                            2
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-1.5 leading-snug">Surat Pengantar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Menyiapkan surat pengantar resmi dari perguruan tinggi atau sekolah (format PDF).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Berkas Kampus/Sekolah
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-base mb-3 shadow-sm">
                            3
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-1.5 leading-snug">Daftar di SIP &amp; Upload</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Mendaftar melalui SIP dan mengunggah berkas. Pendaftar menerima notif email otomatis.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Pendaftaran Online
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-base mb-3 shadow-sm">
                            4
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-1.5 leading-snug">Verifikasi Dokumen Admin</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Admin memverifikasi berkas dan menerbitkan surat balasan resmi (maksimal 5 hari kerja).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Verifikasi Admin
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-base mb-3 shadow-sm">
                            5
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-1.5 leading-snug">Terima Surat Balasan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pendaftar menerima surat balasan resmi melalui email dan dapat diunduh langsung di sistem.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Surat Balasan
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.publik>
