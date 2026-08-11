<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 font-sans">Dashboard Operasional</h2>
        <p class="text-xs text-gray-400 mt-1">Selamat datang kembali! Berikut ringkasan antrean kerja verifikasi hari ini.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <!-- Total Masuk -->
        <div class="bg-white p-4 rounded-2xl border border-gray-150 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-emerald-50 text-biogen-medium rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Total Pengajuan</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-4 rounded-2xl border border-yellow-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Belum Verifikasi</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['menunggu'] }}</p>
            </div>
        </div>

        <!-- Disetujui Bulan Ini -->
        <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-emerald-50 text-green-600 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Persetujuan Baru</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['disetujui_bulan_ini'] }}</p>
            </div>
        </div>

        <!-- Menunggu Review Laporan -->
        <div class="bg-white p-4 rounded-2xl border border-blue-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Antrean Laporan</p>
                <p class="text-xl font-bold text-gray-850 mt-0.5">{{ $stats['laporan_review'] }}</p>
            </div>
        </div>

        <!-- Terlambat Lapor -->
        <div class="bg-white p-4 rounded-2xl border border-red-100 shadow-sm flex items-center space-x-3">
            <div class="p-2.5 bg-red-50 text-red-650 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 truncate">Terlambat Lapor</p>
                <p class="text-xl font-bold text-red-600 mt-0.5">{{ $stats['laporan_telat'] }}</p>
            </div>
        </div>
    </div>

    <!-- Alert / Tindakan Penting -->
    @if($stats['menunggu'] > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 mb-8 flex space-x-3">
            <svg class="w-5.5 h-5.5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="text-sm font-bold text-yellow-800">Ada {{ $stats['menunggu'] }} Pengajuan Menunggu Tindakan Anda</p>
                <p class="text-xs text-yellow-700 mt-0.5 leading-relaxed">Segera tinjau berkas permohonan magang untuk menjaga ketersediaan kapasitas kuota rolling yang akurat.</p>
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

        <!-- Terlambat Lapor Panel (Right 1 Column) -->
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm font-sans">Peserta Terlambat Lapor</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Peserta aktif yang melewati masa tenggang selesai magang.</p>
                </div>

                @if($laporanTelatList->isEmpty())
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs font-semibold">Semua laporan tertib tepat waktu.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100 max-h-[350px] overflow-y-auto">
                        @foreach($laporanTelatList as $telat)
                            <div class="p-4 hover:bg-red-50/20 transition-all">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-800 text-xs">{{ $telat->user->name }}</p>
                                        <p class="text-[10px] text-gray-450 mt-0.5">{{ $telat->bidang->nama_bidang }} ({{ $telat->nomor_pengajuan }})</p>
                                    </div>
                                    <span class="inline-block text-[9px] bg-red-100 text-red-800 font-bold px-2 py-0.5 rounded-full">
                                        Terlambat
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-3 text-[10px] text-gray-400">
                                    <span>Selesai Rencana: <strong>{{ \Carbon\Carbon::parse($telat->tanggal_selesai_rencana)->translatedFormat('d M Y') }}</strong></span>
                                    @php
                                        $diffDays = \Carbon\Carbon::parse($telat->tanggal_selesai_rencana)->diffInDays(now());
                                    @endphp
                                    <span class="text-red-650 font-bold font-sans">{{ $diffDays }} hari</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.internal>
