<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Success Banner -->
            <div class="text-center mb-10">
                <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-5 shadow-sm">
                    <svg class="w-10 h-10 text-biogen-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Pengajuan Berhasil Dikirim!</h1>
                <p class="text-gray-500 text-sm mt-2">
                    Tim BRMP Biogen akan memverifikasi pengajuan Anda. Pantau status di dashboard Anda.
                </p>
            </div>

            <!-- Detail Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <!-- Nomor Pengajuan Banner -->
                <div class="bg-biogen-dark px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-emerald-300 text-xs font-semibold uppercase tracking-wider">Nomor Pengajuan</p>
                        <p class="text-white text-xl font-extrabold tracking-widest mt-0.5">{{ $pengajuan->nomor_pengajuan }}</p>
                    </div>
                    <div class="bg-emerald-800 text-emerald-200 px-3 py-1.5 rounded-full text-xs font-bold">
                        {{ $pengajuan->status }}
                    </div>
                </div>

                <!-- Details -->
                <div class="p-6 divide-y divide-gray-100">
                    <div class="grid grid-cols-2 gap-4 py-4 first:pt-0">
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Nama Pemohon</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Instansi</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">{{ auth()->user()->instansi ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-4">
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Jenjang</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">{{ $pengajuan->jenjang }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Bidang Penempatan</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">{{ $pengajuan->bidang->nama_bidang }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-4">
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Tanggal Mulai</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">
                                {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Tanggal Selesai (Rencana)</p>
                            <p class="font-semibold text-gray-800 mt-0.5 text-sm">
                                {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai_rencana)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="py-4">
                        <p class="text-xs text-gray-400 font-medium">Pembimbing</p>
                        <p class="font-semibold text-gray-800 mt-0.5 text-sm">
                            {{ $pengajuan->bidang->pembimbing?->name ?? 'Belum ditentukan' }}
                        </p>
                    </div>
                    <div class="py-4 last:pb-0">
                        <p class="text-xs text-gray-400 font-medium">Tanggal Pengajuan</p>
                        <p class="font-semibold text-gray-800 mt-0.5 text-sm">
                            {{ $pengajuan->created_at->translatedFormat('l, d F Y — H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8 flex space-x-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm text-blue-700">
                    <p class="font-semibold mb-1">Langkah selanjutnya</p>
                    <ul class="list-disc pl-4 space-y-0.5 text-xs leading-relaxed">
                        <li>Petugas akan memverifikasi kelengkapan dokumen Anda.</li>
                        <li>Anda akan mendapat notifikasi jika ada perubahan status.</li>
                        <li>Simpan nomor pengajuan <strong>{{ $pengajuan->nomor_pengajuan }}</strong> sebagai referensi.</li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('pengguna.riwayat') }}"
                    class="flex-1 text-center bg-biogen-dark hover:bg-biogen-medium text-white px-6 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200">
                    Ke Riwayat Pengajuan
                </a>
                <a href="{{ route('pengguna.career.step1') }}"
                    class="flex-1 text-center bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-6 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200">
                    Ajukan Pengajuan Baru
                </a>
            </div>
        </div>
    </div>
</x-layouts.publik>
