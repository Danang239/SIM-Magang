<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 font-sans">Dashboard Operasional</h2>
        <p class="text-xs text-gray-400 mt-1">Selamat datang kembali! Berikut ringkasan antrean verifikasi dan pendaftar aktif hari ini.</p>
    </div>

    <!-- Stat Cards (5 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <!-- Total Masuk -->
        <div class="bg-white p-4 rounded-2xl border border-gray-150 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-emerald-50 text-biogen-medium rounded-xl shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Total Pengajuan</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-4 rounded-2xl border border-yellow-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Belum Verifikasi</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['menunggu'] }}</p>
            </div>
        </div>

        <!-- Persetujuan Baru -->
        <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-emerald-50 text-green-600 rounded-xl shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Persetujuan Baru</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['disetujui_bulan_ini'] }}</p>
            </div>
        </div>

        <!-- Peserta Aktif -->
        <div class="bg-white p-4 rounded-2xl border border-purple-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Peserta Aktif</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['aktif'] }}</p>
            </div>
        </div>

        <!-- Peserta Selesai -->
        <div class="bg-white p-4 rounded-2xl border border-blue-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Alumni / Selesai</p>
                <p class="text-xl font-bold text-blue-600 mt-0.5">{{ $stats['selesai'] }}</p>
            </div>
        </div>
    </div>

    <!-- Alert / Tindakan Penting -->
    @if($stats['menunggu'] > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 mb-8 flex items-start space-x-3">
            <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="text-sm font-bold text-yellow-800">Ada {{ $stats['menunggu'] }} Pengajuan Menunggu Tindakan Anda</p>
                <p class="text-xs text-yellow-700 mt-0.5 leading-relaxed">Segera tinjau berkas permohonan magang untuk menjaga ketersediaan kapasitas kuota yang akurat.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Antrean Perlu Tindak Lanjut (Left 2 Columns) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm font-sans">Antrean Verifikasi Terlama</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Selesaikan berkas pengajuan prioritas berdasarkan tanggal kirim terlama.</p>
                    </div>
                    <a href="{{ route('petugas.verifikasi.index') }}" class="text-xs font-semibold text-biogen-medium hover:text-biogen-dark transition-colors">Lihat Semua Antrean &rarr;</a>
                </div>

                @if($antrean->isEmpty())
                    <div class="text-center py-16">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-gray-500 font-medium">Luar biasa! Antrean verifikasi kosong saat ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-3.5">Tanggal Masuk</th>
                                    <th class="px-6 py-3.5">Pemohon</th>
                                    <th class="px-6 py-3.5">Bidang / Pilihan</th>
                                    <th class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                @foreach($antrean as $item)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="px-6 py-4 text-gray-500 font-medium">
                                            {{ $item->created_at->translatedFormat('d M Y — H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-800">{{ $item->user->name }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $item->user->instansi ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-700">{{ $item->bidang->nama_bidang }}</p>
                                            <span class="inline-block text-[9px] bg-emerald-50 text-biogen-dark px-1.5 py-0.5 rounded font-bold uppercase mt-0.5">{{ $item->jenjang }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('petugas.verifikasi.show', $item->public_id) }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition-all inline-block">
                                                Verifikasi
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Peserta Terjadwal / Aktif Panel (Right 1 Column) -->
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm font-sans">Jadwal Magang Mendatang</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Daftar peserta disetujui yang akan memulai magang.</p>
                </div>

                @if($terjadwalList->isEmpty())
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs font-semibold">Belum ada peserta jadwal mendatang.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100 max-h-[350px] overflow-y-auto">
                        @foreach($terjadwalList as $t)
                            <div class="p-4 hover:bg-emerald-50/20 transition-all">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-800 text-xs">{{ $t->user->name }}</p>
                                        <p class="text-[10px] text-gray-450 mt-0.5">{{ $t->bidang->nama_bidang }} ({{ $t->nomor_pengajuan }})</p>
                                    </div>
                                    <span class="inline-block text-[9px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">
                                        Terjadwal
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-3 text-[10px] text-gray-400">
                                    <span>Mulai: <strong>{{ \Carbon\Carbon::parse($t->tanggal_mulai)->translatedFormat('d M Y') }}</strong></span>
                                    <span class="text-emerald-700 font-bold font-sans">{{ $t->durasi_bulan }} Bulan</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.internal>
