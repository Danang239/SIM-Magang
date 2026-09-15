<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'SIP BRMP Biogen') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo-brmp.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-white m-0 p-0 overflow-x-hidden page-fade-enter">
        
        <!-- Top Loading Progress Bar -->
        <div id="page-progress-bar" 
             class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-300 z-[9999] transition-all duration-300 ease-out w-0 shadow-[0_0_10px_rgba(16,185,129,0.9)] opacity-0 pointer-events-none"></div>

        <style>
            .page-fade-enter {
                opacity: 0;
                transition: opacity 0.22s ease-out;
            }
            .page-fade-active {
                opacity: 1;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                requestAnimationFrame(() => {
                    document.body.classList.add('page-fade-active');
                });

                const bar = document.getElementById('page-progress-bar');
                
                document.addEventListener('click', (e) => {
                    const anchor = e.target.closest('a');
                    if (!anchor) return;

                    const href = anchor.getAttribute('href');
                    const target = anchor.getAttribute('target');

                    if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                        if (anchor.hostname === window.location.hostname) {
                            if (bar) {
                                bar.style.opacity = '1';
                                bar.style.width = '75%';
                            }
                        }
                    }
                });

                window.addEventListener('beforeunload', () => {
                    if (bar) {
                        bar.style.opacity = '1';
                        bar.style.width = '100%';
                    }
                });
            });
        </script>
        
        <!-- Full-Screen Split Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-screen w-full">
            
            <!-- LEFT SIDE: Full-Height Image & Green Gradient Overlay (60% Width) -->
            <div class="lg:col-span-7 relative hidden lg:flex flex-col justify-between p-10 lg:p-14 text-white bg-cover bg-center overflow-hidden min-h-screen" style="background-image: url('{{ asset('background.png') }}');">
                <!-- Dark Green Gradient Overlay for Text Readability -->
                <div class="absolute inset-0 z-0" style="background: linear-gradient(135deg, rgba(4, 47, 29, 0.92) 0%, rgba(11, 94, 60, 0.85) 50%, rgba(9, 77, 49, 0.92) 100%);"></div>

                <!-- Top Branding -->
                <div class="relative z-10 flex items-center space-x-3">
                    <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-11 h-11 object-contain drop-shadow-md shrink-0">
                    <div>
                        <span class="font-black text-2xl tracking-tight text-white block leading-none font-sans">SIP Biogen</span>
                        <span class="text-xs text-emerald-200 uppercase tracking-widest font-semibold mt-1 block">Balai Besar Perakitan dan Modernisasi Bioteknologi dan Sumber Daya Genetik Pertanian</span>
                    </div>
                </div>

                <!-- Middle Content -->
                <div class="relative z-10 space-y-5 my-auto py-12 max-w-lg">
                    <h1 class="text-3xl lg:text-4xl font-extrabold leading-tight font-sans text-white">
                        Sistem Informasi PKL
                    </h1>
                    <p class="text-sm text-emerald-100/90 leading-relaxed font-medium text-justify">
                        Sistem Informasi PKL (SIP) merupakan platform untuk mendukung layanan jasa guna memfasilitasi mahasiswa/siswa melaksanakan praktik kerja lapangan di bidang Bioteknologi, Sumber Daya Genetik Pertanian, Bank Gen Pertanian, Unit Pengelola Benih Sumber, Hubungan Masyarakat, Teknologi Informasi, dan Perkantoran.
                    </p>
                </div>

                <!-- Bottom Footer -->
                <div class="relative z-10 pt-6 border-t border-white/15 text-xs text-emerald-200/70 font-medium">
                    © {{ date('Y') }} BRMP Biogen — Kementerian Pertanian RI
                </div>
            </div>

            <!-- RIGHT SIDE: Clean Form Slot Container (40% Width) -->
            <div class="lg:col-span-5 flex flex-col justify-between items-center p-6 sm:p-10 lg:p-14 bg-white min-h-screen relative">
                
                <!-- Header Branding Logo for Mobile -->
                <div class="w-full max-w-md flex lg:hidden items-center justify-between mb-8">
                    <a href="/" class="flex items-center space-x-2.5">
                        <img src="{{ asset('logo-brmp.png') }}" alt="Logo BRMP Biogen" class="w-9 h-9 object-contain shrink-0">
                        <span class="font-bold text-lg text-gray-800 font-sans tracking-tight">
                            SIP <span class="text-biogen-medium">Biogen</span>
                        </span>
                    </a>
                </div>

                <!-- Form Content Slot (Centered Vertically) -->
                <div class="w-full max-w-md my-auto space-y-6">
                    {{ $slot }}
                </div>

                <!-- Footer Copyright for Mobile -->
                <div class="w-full max-w-md lg:hidden mt-8 text-center text-xs text-gray-400 font-medium border-t border-gray-100 pt-4">
                    © {{ date('Y') }} BRMP Biogen — Kementerian Pertanian RI
                </div>
            </div>

        </div>

    </body>
</html>
