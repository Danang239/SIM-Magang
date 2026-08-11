<x-layouts.publik>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight font-sans">Laboratorium & Bidang Penelitian</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-2xl leading-relaxed">
                Temukan laboratorium dan bidang riset yang tersedia di Balai Besar Pengujian Standar Instrumen Bioteknologi (BB-Biogen) untuk menunjang program magang, PKL, atau penelitian Anda.
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

                        <!-- Deskripsi -->
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">
                            {{ $b->deskripsi ?: 'Tidak ada deskripsi untuk bidang penelitian ini.' }}
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
                            Ajukan Magang di Bidang Ini
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</x-layouts.publik>
