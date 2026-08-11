<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program Magang & PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator (Step 2 Kategori) -->
            <x-career-steps :current="2" />

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Badge Jenjang -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <span class="bg-emerald-100 text-biogen-dark text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        Jenjang: {{ $jenjang }}
                    </span>
                </div>
                <a href="{{ route('pengguna.career.step1') }}" class="text-xs text-gray-500 hover:text-biogen-medium transition-colors underline">
                    Ganti jenjang
                </a>
            </div>

            <form method="POST" action="{{ route('pengguna.career.step2.store') }}">
                @csrf

                <!-- Pilih Kategori Bidang -->
                <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-8 mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-1 font-sans text-center">Pilih Kategori Bidang</h2>
                    <p class="text-sm text-gray-500 mb-8 text-center">Tentukan jenis fokus bidang penelitian magang Anda.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Option 1: Pertanian -->
                        <label for="kategori_pertanian" class="cursor-pointer group">
                            <input type="radio" id="kategori_pertanian" name="kategori" value="Pertanian"
                                class="sr-only peer"
                                {{ old('kategori', 'Pertanian') == 'Pertanian' ? 'checked' : '' }}>
                            <div class="h-full bg-white p-6 rounded-2xl border-2 border-gray-200 hover:border-biogen-medium hover:bg-emerald-50 peer-checked:border-biogen-medium peer-checked:bg-emerald-50 peer-checked:shadow-md transition-all duration-200 flex flex-col items-center text-center">
                                <div class="w-14 h-14 bg-emerald-50 text-biogen-medium rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                                    <!-- Leaf Icon -->
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Fokus Pertanian</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">Berfokus pada genetika molekuler tanaman, kultur jaringan in vitro, proteksi tanaman, dan modernisasi bioteknologi pertanian.</p>
                            </div>
                        </label>

                        <!-- Option 2: Non Pertanian -->
                        <label for="kategori_non_pertanian" class="cursor-pointer group">
                            <input type="radio" id="kategori_non_pertanian" name="kategori" value="Non Pertanian"
                                class="sr-only peer"
                                {{ old('kategori') == 'Non Pertanian' ? 'checked' : '' }}>
                            <div class="h-full bg-white p-6 rounded-2xl border-2 border-gray-200 hover:border-biogen-medium hover:bg-emerald-50 peer-checked:border-biogen-medium peer-checked:bg-emerald-50 peer-checked:shadow-md transition-all duration-200 flex flex-col items-center text-center">
                                <div class="w-14 h-14 bg-emerald-50 text-biogen-medium rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                                    <!-- Administrative/Office/Gear Icon -->
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Fokus Non Pertanian</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">Berfokus pada administrasi perkantoran, pengelolaan logistik kebun percobaan, IT, tata kelola data, dan operasional non-lab.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('pengguna.career.step1') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">
                        ← Kembali ke Jenjang
                    </a>
                    <button type="submit" class="bg-biogen-medium hover:bg-biogen-dark text-white text-sm font-bold px-8 py-3 rounded-xl shadow hover:shadow-md transition-all duration-200">
                        Lanjut ke Pilih Bidang →
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.publik>
