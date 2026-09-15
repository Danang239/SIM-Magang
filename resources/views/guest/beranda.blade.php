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

        /* Flowchart Connector Arrows Animation */
        @keyframes flowDash {
            to {
                stroke-dashoffset: -20;
            }
        }
        .flow-arrow-path {
            stroke-dasharray: 6 4;
            animation: flowDash 1.2s linear infinite;
        }

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
                        Sistem Informasi PKL (SIP) merupakan platform untuk mendukung layanan jasa guna memfasilitasi mahasiswa/siswa melaksanakan praktik kerja lapangan di bidang Bioteknologi, Sumber Daya Genetik Pertanian, Bank Gen Pertanian, Unit Pengelola Benih Sumber, Hubungan Masyarakat, Teknologi Informasi, dan Perkantoran.
                    </p>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <a href="#daftar-section" class="inline-block bg-biogen-medium hover:bg-biogen-light text-white text-base px-10 py-3.5 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all duration-200 uppercase tracking-wider">
                            Pilih Bidang PKL
                        </a>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Hero Person Illustration + Floating Cards -->
                <div class="lg:col-span-6 flex justify-center lg:justify-end items-center mt-10 lg:mt-0 py-6">
                    <div class="relative w-full max-w-[320px] sm:max-w-[360px] lg:max-w-[380px]">                  
                        <!-- Center Illustration (Hero Image at Base Layer z-0) -->
                        <img src="{{ asset('hero-person.png') }}"
                             class="w-full h-auto drop-shadow-2xl hover:scale-[1.01] transition-transform duration-300 relative z-0 pointer-events-none"
                             alt="SIP Biogen Hero Illustration" />

                        <!-- ========================================== -->
                        <!-- EXTERNAL FLOWCHART CONNECTORS (OUTSIDE CARDS - SOLID AMBER) -->
                        <!-- ========================================== -->

                        <!-- 1. Connector: Step 1 (Top Left) -> Step 2 (Top Right) -->
                        <div class="absolute -top-16 left-1/2 -translate-x-1/2 z-10 hidden sm:block pointer-events-none drop-shadow-[0_2px_8px_rgba(252,211,77,0.4)]">
                            <svg class="w-48 h-12 overflow-visible" viewBox="0 0 160 40" fill="none">
                                <defs>
                                    <marker id="arrow1-2" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#FCD34D"/>
                                    </marker>
                                </defs>
                                <path d="M 15 28 Q 80 2, 145 22" stroke="#FCD34D" stroke-width="3" stroke-linecap="round" class="flow-arrow-path" marker-end="url(#arrow1-2)"/>
                            </svg>
                        </div>

                        <!-- 2. Connector: Step 2 (Top Right) -> Step 3 (Middle Right) -->
                        <div class="absolute top-[14%] -right-4 sm:-right-8 lg:-right-10 z-10 hidden sm:block pointer-events-none drop-shadow-[0_2px_8px_rgba(252,211,77,0.4)]">
                            <svg class="w-16 h-28 overflow-visible" viewBox="0 0 50 90" fill="none">
                                <defs>
                                    <marker id="arrow2-3" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#FCD34D"/>
                                    </marker>
                                </defs>
                                <path d="M 18 5 Q 46 45, 22 78" stroke="#FCD34D" stroke-width="3" stroke-linecap="round" class="flow-arrow-path" marker-end="url(#arrow2-3)"/>
                            </svg>
                        </div>

                        <!-- 3. Connector: Step 3 (Middle Right) -> Step 4 (Middle Left) -->
                        <div class="absolute top-[41%] left-1/2 -translate-x-1/2 z-10 hidden sm:block pointer-events-none drop-shadow-[0_2px_8px_rgba(252,211,77,0.4)]">
                            <svg class="w-56 h-16 overflow-visible" viewBox="0 0 200 50" fill="none">
                                <defs>
                                    <marker id="arrow3-4" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#FCD34D"/>
                                    </marker>
                                </defs>
                                <path d="M 185 10 Q 100 48, 15 28" stroke="#FCD34D" stroke-width="3" stroke-linecap="round" class="flow-arrow-path" marker-end="url(#arrow3-4)"/>
                            </svg>
                        </div>

                        <!-- 4. Connector: Step 4 (Middle Left) -> Step 5 (Bottom Center) -->
                        <div class="absolute top-[62%] left-[10%] sm:left-[5%] z-10 hidden sm:block pointer-events-none drop-shadow-[0_2px_8px_rgba(252,211,77,0.4)]">
                            <svg class="w-24 h-24 overflow-visible" viewBox="0 0 90 80" fill="none">
                                <defs>
                                    <marker id="arrow4-5" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#FCD34D"/>
                                    </marker>
                                </defs>
                                <path d="M 15 5 Q 12 55, 78 72" stroke="#FCD34D" stroke-width="3" stroke-linecap="round" class="flow-arrow-path" marker-end="url(#arrow4-5)"/>
                            </svg>
                        </div>

                        <!-- ========================================== -->
                        <!-- 5 FLOATING FLOWCHART CARDS (Layer z-30) -->
                        <!-- ========================================== -->

                        <!-- Flowchart Step 1: Memilih Topik (Top Left - Emerald) -->
                        <div class="absolute -top-10 -left-10 sm:-left-24 lg:-left-32 z-30 bg-white/95 backdrop-blur-md text-gray-900 px-4 py-3 rounded-2xl shadow-2xl border border-white/80 flex items-center space-x-3 animate-hero-float-1 hover:scale-105 transition-all whitespace-nowrap group">
                            <div class="relative">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100 group-hover:bg-emerald-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <span class="absolute -top-2 -left-2 bg-emerald-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">1</span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors leading-snug">Memilih Topik</h4>
                        </div>

                        <!-- Flowchart Step 2: Membuat Surat Pengantar (Top Right - Blue) -->
                        <div class="absolute -top-8 -right-8 sm:-right-20 lg:-right-24 z-30 bg-white/95 backdrop-blur-md text-gray-900 px-4 py-3 rounded-2xl shadow-2xl border border-white/80 flex items-center space-x-3 animate-hero-float-2 hover:scale-105 transition-all whitespace-nowrap group">
                            <div class="relative">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl shrink-0 border border-blue-100 group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="absolute -top-2 -left-2 bg-blue-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">2</span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors leading-snug">Membuat Surat Pengantar</h4>
                        </div>

                        <!-- Flowchart Step 3: Mendaftar melalui SIP (Middle Right - Amber) -->
                        <div class="absolute top-[38%] -right-8 sm:-right-18 lg:-right-24 z-30 bg-white/95 backdrop-blur-md text-gray-900 px-4 py-3 rounded-2xl shadow-2xl border border-white/80 flex items-center space-x-3 animate-hero-float-3 hover:scale-105 transition-all whitespace-nowrap group">
                            <div class="relative">
                                <div class="p-2 bg-amber-50 text-amber-600 rounded-xl shrink-0 border border-amber-100 group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                </div>
                                <span class="absolute -top-2 -left-2 bg-amber-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">3</span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-amber-700 transition-colors leading-snug">Mendaftar melalui SIP</h4>
                        </div>

                        <!-- Flowchart Step 4: Verifikasi oleh Admin (Middle Left - Purple) -->
                        <div class="absolute top-[48%] -left-14 sm:-left-28 lg:-left-36 z-30 bg-white/95 backdrop-blur-md text-gray-900 px-4 py-3 rounded-2xl shadow-2xl border border-white/80 flex items-center space-x-3 animate-hero-float-1 hover:scale-105 transition-all whitespace-nowrap group">
                            <div class="relative">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-xl shrink-0 border border-purple-100 group-hover:bg-purple-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <span class="absolute -top-2 -left-2 bg-purple-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">4</span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-purple-700 transition-colors leading-snug">Verifikasi oleh Admin</h4>
                        </div>

                        <!-- Flowchart Step 5: Mendapat Surat Balasan (Bottom Center - Emerald Teal) -->
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 z-30 bg-white/95 backdrop-blur-md text-gray-900 px-5 py-3 rounded-2xl shadow-2xl border border-white/80 flex items-center space-x-3 animate-hero-float-2 hover:scale-105 transition-all whitespace-nowrap group">
                            <div class="relative">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100 group-hover:bg-emerald-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="absolute -top-2 -left-2 bg-emerald-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">5</span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors leading-snug">Mendapat Surat Balasan</h4>
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
                    <span class="p-2 bg-emerald-100 text-emerald-800 rounded-lg">
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
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-emerald-950 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 to-emerald-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white bg-emerald-700">
                                                JALUR {{ strtoupper($b->jenjang) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-emerald-700 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Ruang Lingkup Bidang -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada informasi ruang lingkup untuk bidang PKL ini.' }}
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

            <!-- Kategori Siswa -->
            <div>
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3 reveal-scroll">
                    <span class="p-2 bg-emerald-100 text-emerald-800 rounded-lg">
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
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-emerald-950 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 to-emerald-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white bg-emerald-700">
                                                JALUR {{ strtoupper($b->jenjang) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-emerald-700 transition-colors">
                                            {{ $b->nama_bidang }}
                                        </h4>

                                        <!-- Ruang Lingkup Bidang -->
                                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $b->deskripsi ?: 'Tidak ada informasi ruang lingkup untuk bidang PKL ini.' }}
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
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-base mb-3.5 shadow-sm ring-4 ring-emerald-50">
                            1
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-2 leading-snug">Memilih Topik</h3>
                        <p class="text-xs text-gray-500 leading-relaxed text-justify">
                            Mengeksplorasi bidang penelitian atau laboratorium yang tersedia di BRMP Biogen dan memastikan ketersediaan kuota pembimbing yang sesuai dengan minat riset.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-semibold flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Eksplorasi Bidang
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-base mb-3.5 shadow-sm ring-4 ring-emerald-50">
                            2
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-2 leading-snug">Membuat Surat Pengantar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed text-justify">
                            Mengurus dan menyiapkan dokumen surat pengantar resmi dari pihak kampus atau sekolah asal yang ditujukan kepada pimpinan instansi (format PDF).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-semibold flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Surat Kampus/Sekolah
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-base mb-3.5 shadow-sm ring-4 ring-emerald-50">
                            3
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-2 leading-snug">Mendaftar melalui SIP</h3>
                        <p class="text-xs text-gray-500 leading-relaxed text-justify">
                            Mengisi formulir pendaftaran online pada platform SIP Biogen, memilih pembimbing lapangan, dan mengunggah dokumen surat pengantar yang telah disiapkan.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-semibold flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Pendaftaran Online
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-base mb-3.5 shadow-sm ring-4 ring-emerald-50">
                            4
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-2 leading-snug">Verifikasi oleh Admin</h3>
                        <p class="text-xs text-gray-500 leading-relaxed text-justify">
                            Petugas admin dan pembimbing memeriksa kelayakan berkas pendaftar dan memproses persetujuan pengajuan (estimasi maksimal 5 hari kerja).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-semibold flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Validasi &amp; Review
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-gray-50/90 rounded-2xl p-5 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-base mb-3.5 shadow-sm ring-4 ring-emerald-50">
                            5
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans mb-2 leading-snug">Mendapat Surat Balasan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed text-justify">
                            Pendaftar menerima surat balasan resmi via email terdaftar dan dapat mengunduh dokumen bukti penerimaan langsung melalui portal SIP Biogen.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-semibold flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Hasil &amp; Unduh Surat
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.publik>
