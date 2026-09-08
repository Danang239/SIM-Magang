@if(auth()->user()->hasRole('Pengguna'))
    <x-layouts.publik>
        <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-6" 
             x-data="{ 
                 showModal: {{ (session('status') !== 'profile-updated' && (empty(auth()->user()->no_hp) || empty(auth()->user()->instansi) || empty(auth()->user()->program_studi))) ? 'true' : 'false' }},
                 scrollToBio() {
                     this.showModal = false;
                     $nextTick(() => {
                         const el = document.getElementById('no_hp');
                         if(el) { el.scrollIntoView({ behavior: 'smooth', block: 'center' }); el.focus(); }
                     });
                 }
             }">
              
            <!-- Interactive Pop-Up Modal for Google Login / Profile Bio Completion (Muncul saat biodata belum lengkap, hilang permanen setelah disimpan) -->
            <div x-show="showModal" 
                 x-cloak
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-4 overflow-y-auto"
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                
                <!-- Backdrop Blur Overlay -->
                <div x-show="showModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="showModal = false"
                     class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

                <!-- Modal Window Card -->
                <div x-show="showModal"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 sm:p-7 text-left overflow-hidden border border-gray-100 z-10">
                    
                    <!-- Decorative Top Header Glow -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>
                    <div class="absolute -top-12 -left-12 w-32 h-32 bg-amber-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                    <!-- Header Icon & Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-tr from-amber-500 to-amber-400 text-white rounded-2xl shadow-lg shadow-amber-500/30 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                            Akun Google Terverifikasi
                        </span>
                    </div>

                    <!-- Title & Subtitle -->
                    <h3 class="text-lg font-extrabold text-gray-900 font-sans tracking-tight" id="modal-title">
                        Selamat Datang di SIM-MAGANG!
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Anda berhasil masuk menggunakan akun Google ({{ auth()->user()->email }}). Silakan lengkapi biodata Anda pada form di bawah ini agar data pemohon magang Anda valid.
                    </p>

                    <!-- Info Box: Data Required -->
                    <div class="my-4 p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs text-amber-900 space-y-2">
                        <p class="font-bold flex items-center gap-1.5 text-amber-950">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Lengkapi Biodata Anda Berikut:</span>
                        </p>
                        <ul class="space-y-1.5 pl-5 list-disc text-[11px] text-amber-900/90 font-medium">
                            <li><strong class="text-gray-800">Nomor WhatsApp / HP:</strong> Notifikasi hasil verifikasi</li>
                            <li><strong class="text-gray-800">Asal Sekolah / Universitas:</strong> Instansi pemohon</li>
                            <li><strong class="text-gray-800">Program Studi / Jurusan:</strong> Jurusan pendidikan Anda</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-col sm:flex-row gap-2.5">
                        <button @click="scrollToBio()" 
                                type="button" 
                                class="w-full inline-flex justify-center items-center px-4 py-3 bg-biogen-medium hover:bg-biogen-dark text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition-all duration-200 focus:outline-none">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002-2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Lengkapi Biodata Sekarang
                        </button>
                        <button @click="showModal = false" 
                                type="button" 
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 focus:outline-none">
                            Saya Mengerti
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Title -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 font-sans">Pengaturan Profil</h1>
                <p class="text-xs text-gray-500 mt-1">Perbarui data profil, informasi kontak, dan kata sandi akun Anda.</p>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-layouts.publik>
@else
    <x-layouts.internal>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Pengaturan Profil</h2>
            <p class="text-xs text-gray-400 mt-1">Perbarui data profil, informasi kontak, dan kata sandi akun internal Anda.</p>
        </div>

        <div class="max-w-3xl space-y-6">
            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-layouts.internal>
@endif
