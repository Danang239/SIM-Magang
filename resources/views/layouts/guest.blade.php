<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'SIM-MAGANG BRMP Biogen') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col justify-center items-center relative overflow-x-hidden py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Bulletproof Inline Green Gradient Overlay (Guaranteed to work regardless of Tailwind compilation) -->
        <div class="absolute inset-0 z-10" style="background: linear-gradient(135deg, rgba(6, 78, 59, 0.92) 0%, rgba(2, 44, 23, 0.97) 100%);"></div>
        
        <!-- Full Building Background Image -->
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('background-dengan-logo.png') }}');"></div>

        <!-- Content Container -->
        <div class="relative z-20 w-full flex flex-col items-center">
            
            <!-- Semi-transparent Card Box with Glassmorphism effect wrapping all content -->
            <div class="w-full sm:max-w-md bg-white/85 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-white/35">
                
                <!-- Branding Logo inside the card so it is covered and highly readable -->
                <div class="flex items-center justify-center space-x-2.5 mb-8">
                    <div class="w-9 h-9 rounded-xl bg-biogen-medium flex items-center justify-center shadow-md">
                        <svg class="w-5.5 h-5.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18M12 3a9 9 0 019 9m-9-9a9 9 0 00-9 9m9 9a9 9 0 019-9m-9 9a9 9 0 00-9-9M6 12h12M9 8h6M9 16h6" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-800 font-sans tracking-tight">
                        BRMP <span class="text-biogen-medium">Biogen</span>
                    </span>
                </div>

                <!-- Form Content slot -->
                {{ $slot }}

                <!-- Small inside footer -->
                <p class="mt-8 text-[10px] text-gray-400 text-center font-medium uppercase tracking-wider">
                    © {{ date('Y') }} BRMP Biogen — Kementerian Pertanian RI
                </p>
            </div>
        </div>

    </body>
</html>
