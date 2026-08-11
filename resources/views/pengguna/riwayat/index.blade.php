<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 font-sans">Riwayat Pengajuan Magang & PKL</h1>
                    <p class="text-xs text-gray-500 mt-1">Lihat dan lacak semua pengajuan magang yang telah Anda buat.</p>
                </div>
                <a href="{{ route('pengguna.career.step1') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-sm px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Ajukan Baru</span>
                </a>
            </div>

            <!-- Filter & Search Panel -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('pengguna.riwayat') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Cari Pengajuan</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                class="w-full text-sm rounded-xl border border-gray-200 pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                                placeholder="Cari No. Pengajuan / Bidang...">
                            <div class="absolute left-3.5 top-3 text-gray-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full text-sm rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white">
                            <option value="">Semua Status</option>
                            @foreach(['Menunggu Verifikasi', 'Disetujui', 'Ditolak', 'Terjadwal', 'Sedang Magang', 'Selesai', 'Dibatalkan'] as $st)
                                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Urutan Tanggal</label>
                        <select id="sort" name="sort"
                            class="w-full text-sm rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition bg-white">
                            <option value="desc" {{ request('sort', 'desc') === 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 bg-biogen-dark hover:bg-biogen-medium text-white text-sm font-bold py-2.5 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                            Terapkan
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'sort']))
                            <a href="{{ route('pengguna.riwayat') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if($pengajuans->isEmpty())
                    <div class="text-center py-16">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-sm text-gray-500 font-medium">Tidak ada pengajuan yang ditemukan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4">No. Pengajuan</th>
                                    <th class="px-6 py-4">Bidang Penempatan</th>
                                    <th class="px-6 py-4">Tanggal Mulai</th>
                                    <th class="px-6 py-4">Durasi</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($pengajuans as $pengajuan)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-800 tracking-wider">
                                            {{ $pengajuan->nomor_pengajuan }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-700">
                                            {{ $pengajuan->bidang->nama_bidang }}
                                            <span class="block text-[10px] text-gray-400 font-normal uppercase mt-0.5">{{ $pengajuan->jenjang }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 font-medium">
                                            {{ $pengajuan->durasi_bulan }} Bulan
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $badgeClasses = match($pengajuan->status) {
                                                    'Disetujui' => 'bg-green-100 text-green-700',
                                                    'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-700',
                                                    'Ditolak' => 'bg-red-100 text-red-700',
                                                    'Terjadwal' => 'bg-purple-100 text-purple-700',
                                                    'Sedang Magang' => 'bg-cyan-100 text-cyan-700',
                                                    'Selesai' => 'bg-blue-100 text-blue-700',
                                                    'Dibatalkan' => 'bg-gray-100 text-gray-600',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-block text-xs font-bold px-3 py-1 rounded-full {{ $badgeClasses }}">
                                                {{ $pengajuan->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('pengguna.pengajuan.show', $pengajuan->public_id) }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm hover:shadow transition-all duration-150 inline-block">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pengajuans->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            {{ $pengajuans->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.publik>
