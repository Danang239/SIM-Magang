<x-layouts.publik>
    <!-- Hero Section Header -->
    <div class="relative bg-gradient-to-br from-[#042f1d] via-[#0B5E3C] to-[#094d31] py-16 px-6 sm:px-12 text-center text-white overflow-hidden pt-24">
        <div class="relative z-20 max-w-4xl mx-auto">
            <div class="inline-flex items-center space-x-2 bg-emerald-900/80 border border-emerald-400/30 px-4 py-1.5 rounded-full text-xs font-semibold text-emerald-200 shadow-md mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="uppercase tracking-wider">LOKASI &amp; KONTAK REKOMENDASI</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight font-sans">Hubungi Kami</h1>
            <p class="mt-3 text-sm sm:text-base text-emerald-100 max-w-xl mx-auto font-medium opacity-90">
                Silakan hubungi kami untuk informasi lebih lanjut mengenai program magang, penelitian, atau kunjungan ilmiah di BRMP Biogen.
            </p>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="bg-gray-50 py-12 px-4 sm:px-8 lg:px-12">
        <div class="max-w-6xl mx-auto space-y-10">
            
            <!-- 1. LARGE GOOGLE MAPS EMBED -->
            <div class="bg-white p-3 rounded-3xl border border-gray-200 shadow-xl overflow-hidden h-[420px] sm:h-[480px] lg:h-[500px] relative group">
                <!-- Floating Map Badge -->
                <div class="absolute top-6 left-6 z-10 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-gray-100 flex items-center space-x-2.5 transition-transform duration-300 group-hover:scale-105">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-extrabold text-gray-900 font-sans">Kantor Utama BRMP Biogen</span>
                    <span class="text-[10px] text-gray-500 font-medium hidden sm:inline">• Bogor, Jawa Barat</span>
                </div>

                <iframe src="https://maps.google.com/maps?q=Balai%20Besar%20Perakitan%20dan%20Modernisasi%20Bioteknologi%20dan%20Sumber%20Daya%20Genetik%20Pertanian%20(BRMP%20BIOGEN)&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                    class="w-full h-full rounded-2xl border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- 2. TWO-COLUMN LAYOUT UNDERNEATH MAP -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- LEFT COLUMN: Informasi Kontak Resmi -->
                <div class="lg:col-span-7 bg-white p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-md transition-shadow">
                    <div>
                        <div class="mb-2">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 font-sans">Informasi Kontak Resmi</h2>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Silakan hubungi kami pada jam operasional kerja resmi.</p>

                        <div class="space-y-4 mt-6">
                            <!-- Alamat Instansi (Larger & More Spacious) -->
                            <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50/70 via-gray-50/60 to-gray-50/90 border border-emerald-100/80 shadow-sm hover:border-emerald-300 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="p-3.5 bg-emerald-600 text-white rounded-2xl shrink-0 shadow-sm mt-1">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div class="space-y-1.5 flex-grow">
                                        <span class="text-[10px] font-extrabold text-emerald-800 uppercase tracking-widest bg-emerald-100/80 px-2.5 py-0.5 rounded-full inline-block">Alamat Utama Instansi</span>
                                        <h3 class="text-base sm:text-lg font-extrabold text-gray-900 leading-snug font-sans pt-1">
                                            Balai Besar Perakitan dan Modernisasi Bioteknologi dan Sumber Daya Genetik Pertanian (BRMP BIOGEN)
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-600 font-medium leading-relaxed pt-1">
                                            Jl. Tentara Pelajar No.3A, RT.02/RW.7, Menteng, Kec. Bogor Barat, Kota Bogor, Jawa Barat 16111
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Call Center & Email Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Call Center & WA -->
                                <div class="flex items-start space-x-3.5 p-4 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-emerald-200 transition-colors">
                                    <div class="p-2.5 bg-emerald-100/80 text-emerald-700 rounded-xl shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.461c-1.832 0-3.623-.49-5.187-1.42l-.372-.222-3.856 1.011 1.029-3.757-.244-.388a10.02 10.02 0 0 1-1.538-5.358c0-5.526 4.496-10.022 10.023-10.022 2.678 0 5.194 1.043 7.086 2.937a10.003 10.003 0 0 1 2.934 7.086c0 5.528-4.498 10.024-10.025 10.024m0-18.423c-4.632 0-8.403 3.771-8.403 8.399 0 1.621.464 3.197 1.341 4.567l.211.326-.889 3.245 3.321-.871.319.19c1.322.784 2.839 1.198 4.398 1.198 4.631 0 8.401-3.771 8.401-8.399 0-2.248-.876-4.363-2.463-5.952-1.587-1.587-3.702-2.463-5.951-2.463"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Call Center &amp; WA</p>
                                        <p class="text-xs font-bold text-gray-800 mt-0.5">
                                            (0251) 8337975
                                        </p>
                                        <p class="text-[11px] text-gray-500 font-medium">+62 811-1756-776</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start space-x-3.5 p-4 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-emerald-200 transition-colors">
                                    <div class="p-2.5 bg-purple-100/80 text-purple-700 rounded-xl shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Email Resmi</p>
                                        <p class="text-xs font-bold text-gray-800 mt-0.5 truncate">
                                            magangbiogen@gmail.com
                                        </p>
                                        <p class="text-[11px] text-gray-500 font-medium">Surat &amp; Pertanyaan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- JAM KERJA CARD (WITH ANIMATED PULSE RING) -->
                            <div class="p-5 rounded-2xl bg-gray-50/90 border border-gray-100 space-y-3 hover:border-emerald-200 transition-colors">
                                <div class="flex items-center justify-between pb-2 border-b border-gray-200/80">
                                    <h3 class="text-base font-bold text-gray-900 font-sans tracking-tight">Jam Kerja</h3>
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2.5 py-0.5 rounded-full uppercase flex items-center space-x-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        <span>Operasional Kantor</span>
                                    </span>
                                </div>
                                
                                <div class="flex items-start space-x-5 pt-1">
                                    <!-- Circular Green Clock Icon with Pulse Ring -->
                                    <div class="w-12 h-12 rounded-full border-2 border-emerald-600 flex items-center justify-center text-emerald-600 shrink-0 mt-1 shadow-md bg-white ring-4 ring-emerald-500/20">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <!-- Schedule List -->
                                    <div class="flex-grow text-xs sm:text-sm text-gray-700 font-medium space-y-1.5">
                                        <div class="flex justify-between items-center max-w-[240px]">
                                            <span class="w-16">Senin</span>
                                            <span class="text-gray-400">:</span>
                                            <span class="font-bold text-gray-800">7.30 - 16.00</span>
                                        </div>
                                        <div class="flex justify-between items-center max-w-[240px]">
                                            <span class="w-16">Selasa</span>
                                            <span class="text-gray-400">:</span>
                                            <span class="font-bold text-gray-800">7.30 - 16.00</span>
                                        </div>
                                        <div class="flex justify-between items-center max-w-[240px]">
                                            <span class="w-16">Rabu</span>
                                            <span class="text-gray-400">:</span>
                                            <span class="font-bold text-gray-800">7.30 - 16.00</span>
                                        </div>
                                        <div class="flex justify-between items-center max-w-[240px]">
                                            <span class="w-16">Kamis</span>
                                            <span class="text-gray-400">:</span>
                                            <span class="font-bold text-gray-800">7.30 - 16.00</span>
                                        </div>
                                        <div class="flex justify-between items-center max-w-[240px]">
                                            <span class="w-16">Jum'at</span>
                                            <span class="text-gray-400">:</span>
                                            <span class="font-bold text-gray-800">7.30 - 16.30</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Media Sosial Resmi -->
                <div class="lg:col-span-5 bg-white p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col justify-between space-y-6">
                    <div>
                        <div class="mb-2">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 font-sans">Media Sosial Resmi</h2>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Kunjungi akun medsos kami untuk update kegiatan &amp; informasi riset bioteknologi terbaru.</p>
                    </div>

                    <!-- Social Media Links List -->
                    <div class="space-y-3 my-auto">
                        
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/brmp_biogen/" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-pink-50 to-purple-50 hover:from-pink-100 hover:to-purple-100 border border-pink-100 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-pink-500 text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Instagram Resmi</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">@brmp_biogen</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <!-- YouTube -->
                        <a href="https://www.youtube.com/@brmpbiogen" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-4 rounded-2xl bg-red-50/70 hover:bg-red-100/80 border border-red-100 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-red-600 text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-red-600 transition-colors">YouTube Channel</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">BRMP Biogen Official</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <!-- WhatsApp Call Center -->
                        <a href="https://wa.me/628111756776" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50/70 hover:bg-emerald-100/80 border border-emerald-100 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-emerald-600 text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.226 4.354-1.143z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">WhatsApp Call Center</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">+62 811-1756-776</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <!-- TikTok -->
                        <a href="https://www.tiktok.com/@brmp_biogen" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-900/5 hover:bg-gray-900/10 border border-gray-200 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-black text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.96-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.33 1.52-1.37 2.52-.07 1.25.56 2.45 1.58 3.11.97.64 2.24.74 3.29.28 1.05-.44 1.83-1.47 1.95-2.61.07-2.72.03-5.45.04-8.17 0-3.03-.01-6.06.01-9.09z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-black transition-colors">TikTok Resmi</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">@brmp_biogen</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-black group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <!-- X / Twitter -->
                        <a href="https://x.com/brmp_biogen" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-100/80 hover:bg-slate-200/80 border border-slate-200 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-slate-900 text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-slate-900 transition-colors">X (Twitter) Resmi</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">@brmp_biogen</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-slate-900 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/biogen.kementan" target="_blank" rel="noopener noreferrer" 
                           class="flex items-center justify-between p-3.5 rounded-2xl bg-blue-50/70 hover:bg-blue-100/80 border border-blue-100 text-gray-800 transition-all duration-200 group shadow-sm hover:shadow">
                            <div class="flex items-center space-x-3.5">
                                <div class="p-2.5 bg-blue-600 text-white rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.848 9 5.015V8z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Facebook Resmi</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">BRMP Biogen Kementan</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                    </div>
                   
                </div>

            </div>

        </div>
    </div>
</x-layouts.publik>
