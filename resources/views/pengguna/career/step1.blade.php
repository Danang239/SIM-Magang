<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program Magang & PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="1" />

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-2 font-sans">Langkah 1: Pilih Jenjang Pendidikan</h2>
                <p class="text-sm text-gray-500 mb-8">Pilih jenjang pendidikan Anda. Bidang magang yang tersedia akan disesuaikan dengan pilihan ini.</p>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('pengguna.career.step1.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mahasiswa Card -->
                        <label for="jenjang_mahasiswa" class="cursor-pointer group">
                            <input type="radio" id="jenjang_mahasiswa" name="jenjang" value="Mahasiswa" class="sr-only peer" {{ old('jenjang') == 'Mahasiswa' ? 'checked' : '' }}>
                            <div class="h-full p-6 rounded-2xl border-2 border-gray-200 hover:border-biogen-medium hover:bg-emerald-50 peer-checked:border-biogen-medium peer-checked:bg-emerald-50 peer-checked:shadow-md transition-all duration-200 flex flex-col items-center text-center space-y-4">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-biogen-medium flex items-center justify-center">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 group-hover:text-biogen-medium transition-colors">Mahasiswa</h3>
                                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">Program PKL/Magang untuk mahasiswa S1/D3/D4 perguruan tinggi. Tersedia bidang penelitian dan laboratorium.</p>
                                </div>
                                <div class="mt-auto w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-biogen-medium flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-biogen-medium opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                        </label>

                        <!-- Siswa Card -->
                        <label for="jenjang_siswa" class="cursor-pointer group">
                            <input type="radio" id="jenjang_siswa" name="jenjang" value="Siswa" class="sr-only peer" {{ old('jenjang') == 'Siswa' ? 'checked' : '' }}>
                            <div class="h-full p-6 rounded-2xl border-2 border-gray-200 hover:border-biogen-medium hover:bg-emerald-50 peer-checked:border-biogen-medium peer-checked:bg-emerald-50 peer-checked:shadow-md transition-all duration-200 flex flex-col items-center text-center space-y-4">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-biogen-medium flex items-center justify-center">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 group-hover:text-biogen-medium transition-colors">Siswa / SMK</h3>
                                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">Program PKL untuk siswa SMK/SMA. Tersedia bidang teknis pertanian dan administrasi kebun percobaan.</p>
                                </div>
                                <div class="mt-auto w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-biogen-medium opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                            <span>Lanjut ke Pilih Kategori</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.publik>
