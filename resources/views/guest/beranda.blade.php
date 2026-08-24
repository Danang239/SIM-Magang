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
                    <!-- Pill Badge -->
                    <div class="inline-flex items-center space-x-2 bg-emerald-900/80 border border-emerald-400/30 px-4 py-1.5 rounded-full text-xs font-semibold text-emerald-200 shadow-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="uppercase tracking-wider">BALAI BESAR RESEARCH & DEVELOPMENT BIOGEN</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight font-sans text-white leading-tight">
                        Sistem Informasi Manajemen Magang & PKL <br />
                        <span class="text-amber-300 italic font-black">BRMP Biogen</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm sm:text-base text-emerald-100 font-sans font-medium leading-relaxed opacity-95 max-w-xl">
                        Mulai perjalanan karir penelitian Anda bersama modernisasi bioteknologi pertanian. Pilih bidang penelitian di bawah ini untuk memulai pendaftaran program Magang atau PKL Anda.
                    </p>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <a href="#daftar-section" class="inline-block bg-biogen-medium hover:bg-biogen-light text-white text-base px-10 py-3.5 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all duration-200 uppercase tracking-wider">
                            Bidang Magang
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

                        <!-- Floating Card 1: Sertifikat Resmi (Top Left) -->
                        <div class="absolute -top-10 -left-10 sm:-left-24 lg:-left-32 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-1 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-xl shrink-0 border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 001.946.806 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Sertifikat Resmi</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Dikeluarkan oleh BRMP Biogen</p>
                            </div>
                        </div>

                        <!-- Floating Card 2: Skill Upgrade (Top Right) -->
                        <div class="absolute -top-8 -right-8 sm:-right-20 lg:-right-24 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-2 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-xl shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Skill Upgrade</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Siap kerja hari pertama</p>
                            </div>
                        </div>

                        <!-- Floating Card 3: Mentor Profesional (Middle Left) -->
                        <div class="absolute top-[38%] -left-14 sm:-left-28 lg:-left-36 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-3 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Mentor Profesional</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Dibimbing peneliti & praktisi</p>
                            </div>
                        </div>

                        <!-- Floating Card 4: Networking (Middle Right) -->
                        <div class="absolute top-[52%] -right-8 sm:-right-18 lg:-right-24 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-1 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-xl shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Networking</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Relasi se-Indonesia</p>
                            </div>
                        </div>

                        <!-- Floating Card 5: Portofolio (Bottom Left) -->
                        <div class="absolute -bottom-10 -left-10 sm:-left-24 lg:-left-32 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-2 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-xl shrink-0 border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Portofolio</h4>
                                <p class="text-[10px] text-gray-400 font-normal">Hasil karya di portofolio</p>
                            </div>
                        </div>

                        <!-- Floating Card 6: Pengalaman Kerja (Bottom Right) -->
                        <div class="absolute -bottom-10 -right-6 sm:-right-16 lg:-right-20 z-20 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-xl border border-gray-100/80 flex items-center space-x-3.5 animate-hero-float-3 hover:scale-105 transition-transform whitespace-nowrap">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-xl shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 leading-snug">Pengalaman Kerja</h4>
                                <p class="text-[10px] text-gray-400 font-normal">CV makin bersinar</p>
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
                    <div x-data="{ count: 0, target: {{ $bidangsPertanian->count() + $bidangsNonPertanian->count() }}, animate() { let step = Math.max(1, Math.ceil(this.target / 25)); let timer = setInterval(() => { this.count += step; if(this.count >= this.target) { this.count = this.target; clearInterval(timer); } }, 50); } }"
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
                    <div x-data="{ count: 0, target: {{ $bidangsPertanian->sum('kapasitas') + $bidangsNonPertanian->sum('kapasitas') }}, animate() { let step = Math.max(1, Math.ceil(this.target / 30)); let timer = setInterval(() => { this.count += step; if(this.count >= this.target) { this.count = this.target; clearInterval(timer); } }, 40); } }"
                         x-init="let observer = new IntersectionObserver((entries) => { if(entries[0].isIntersecting) { animate(); observer.disconnect(); } }, { threshold: 0.5 }); observer.observe($el);">
                        <div class="text-3xl sm:text-4xl font-black text-gray-900 font-sans tracking-tight" x-text="count + ' Slot'">0 Slot</div>
                        <p class="text-xs font-extrabold text-emerald-800 uppercase tracking-wider mt-0.5">Total Kapasitas Kuota</p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Laboratorium & Bidang Penelitian Section -->
    <section id="daftar-section" class="py-20 bg-gray-50 border-t border-gray-150 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal-scroll">
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Laboratorium &amp; Bidang Penelitian</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-lg mx-auto">Silakan pilih salah satu bidang penelitian di bawah untuk melihat detail informasi dan kuota yang tersedia.</p>
            </div>

            <!-- Kategori Pertanian -->
            <div class="mb-16">
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3 reveal-scroll">
                    <span class="p-2 bg-emerald-100 text-emerald-800 rounded-lg">
                        <!-- Grass/Leaf Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Pertanian</h3>
                </div>

                @if($bidangsPertanian->isEmpty())
                    <p class="text-gray-500 text-sm italic reveal-scroll">Belum ada bidang pertanian yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsPertanian as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
                                <div>
                                    <!-- Image / Banner Placeholder -->
                                    <div class="h-48 bg-emerald-900 relative overflow-hidden flex items-center justify-center">
                                        @if($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama_bidang }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-700 to-emerald-950 opacity-90"></div>
                                            <svg class="w-16 h-16 text-white/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        @endif
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white" style="background-color: {{ strtolower($b->jenjang) === 'mahasiswa' ? '#2563eb' : '#ea580c' }};">
                                                JALUR {{ strtoupper($b->jenjang) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <!-- Bidang Title -->
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-snug font-sans group-hover:text-emerald-700 transition-colors">
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
                <div class="flex items-center space-x-3 mb-8 border-b border-gray-200 pb-3 reveal-scroll">
                    <span class="p-2 bg-blue-100 text-blue-800 rounded-lg">
                        <!-- Desktop/Server Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800 font-sans">Kategori Non Pertanian</h3>
                </div>

                @if($bidangsNonPertanian->isEmpty())
                    <p class="text-gray-500 text-sm italic reveal-scroll">Belum ada bidang non pertanian yang aktif saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($bidangsNonPertanian as $b)
                            <a href="{{ route('bidang.show', $b->id) }}" class="group bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-blue-500 transition-all duration-300 flex flex-col justify-between overflow-hidden reveal-scroll">
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
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm text-white" style="background-color: {{ strtolower($b->jenjang) === 'mahasiswa' ? '#2563eb' : '#ea580c' }};">
                                                JALUR {{ strtoupper($b->jenjang) }}
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
            <div class="text-center mb-16 reveal-scroll">
                <span class="inline-block bg-emerald-100 text-emerald-800 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    Prosedur &amp; Tahapan
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Alur Pendaftaran Magang &amp; PKL</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">
                    Tahapan pendaftaran hingga pelaksanaan magang di BRMP Biogen secara sistematis dan terintegrasi secara digital.
                </p>
            </div>

            <!-- Steps Timeline Grid (4 Steps) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                
                <!-- Step 1 -->
                <div class="bg-gray-50/90 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            1
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pilih Bidang &amp; Tanggal</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pilih bidang penelitian yang sesuai di atas, tentukan durasi magang (1-6 bulan), dan tentukan tanggal rencana mulai.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Langkah 1 Wizard
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50/90 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            2
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Biodata &amp; Surat Pengantar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Lengkapi biodata lengkap, kontak darurat, dan unggah Surat Pengantar Resmi (PDF) dari Sekolah/Kampus Anda.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Langkah 2 Wizard
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50/90 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            3
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Verifikasi &amp; Surat Balasan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Petugas memverifikasi kelayakan pengajuan. Jika disetujui, petugas akan mengunggah Surat Balasan Resmi BRMP Biogen.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verifikasi Petugas
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-gray-50/90 rounded-2xl p-6 border border-gray-150 relative flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 hover:border-emerald-400 transition-all duration-300 reveal-scroll">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-4 shadow-sm">
                            4
                        </div>
                        <h3 class="font-bold text-gray-800 text-base font-sans mb-2 leading-snug">Pengisian SKM &amp; Diterima Magang</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pemohon mengisi kuesioner SKM singkat. Status otomatis beralih menjadi <strong>Terjadwal / Diterima</strong> &amp; Surat Balasan siap diunduh!
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[11px] text-emerald-700 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Diterima &amp; Siap Magang
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.publik>
