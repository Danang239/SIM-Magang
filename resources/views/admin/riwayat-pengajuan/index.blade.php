<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 font-sans">Arsip Riwayat Pengajuan Magang</h2>
        <p class="text-xs text-gray-400 mt-1">Cari, filter, dan telusuri seluruh rekam jejak berkas pengajuan magang yang masuk.</p>
    </div>

    <!-- Filter Panel Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.riwayat-pengajuan.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <!-- Search Keyword -->
            <div class="md:col-span-2">
                <label for="search" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pencarian</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none"
                    placeholder="Nama peserta atau No. Pengajuan...">
            </div>

            <!-- Bidang -->
            <div>
                <label for="bidang_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bidang</label>
                <select id="bidang_id" name="bidang_id" class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
                    <option value="">-- Semua Bidang --</option>
                    @foreach($bidangs as $b)
                        <option value="{{ $b->id }}" {{ request('bidang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_bidang }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</label>
                <select id="status" name="status" class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
                    <option value="">-- Semua Status --</option>
                    @foreach(['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Selesai', 'Ditolak', 'Dibatalkan'] as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Reset / Submit buttons -->
            <div class="flex items-center space-x-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2.5 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                    Cari
                </button>
                <a href="{{ route('admin.riwayat-pengajuan.index') }}" class="px-3.5 py-2.5 border border-gray-200 text-gray-500 hover:bg-gray-50 text-xs font-bold rounded-xl transition-colors text-center">
                    Reset
                </a>
            </div>

            <!-- Tanggal Dari -->
            <div>
                <label for="tanggal_dari" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dari Tanggal Masuk</label>
                <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
            </div>

            <!-- Tanggal Sampai -->
            <div>
                <label for="tanggal_sampai" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Hingga Tanggal Masuk</label>
                <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($pengajuans->isEmpty())
            <div class="p-12 text-center text-gray-400 text-xs italic">
                Tidak ada data pengajuan magang yang ditemukan.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-gray-400 font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">No. Pengajuan</th>
                            <th class="py-4 px-6">Nama Peserta</th>
                            <th class="py-4 px-6">Bidang Penempatan</th>
                            <th class="py-4 px-6">Tanggal Masuk</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-700">
                        @foreach($pengajuans as $p)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold tracking-wider">{{ $p->nomor_pengajuan }}</td>
                                <td class="py-4 px-6 font-semibold">{{ $p->user->name }}</td>
                                <td class="py-4 px-6 font-medium">{{ $p->bidang->nama_bidang }}</td>
                                <td class="py-4 px-6">{{ $p->created_at->translatedFormat('d M Y') }}</td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $badgeClasses = match($p->status) {
                                            'Disetujui' => 'bg-green-100 text-green-700 border border-green-200',
                                            'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                            'Ditolak' => 'bg-red-100 text-red-700 border border-red-200',
                                            'Terjadwal' => 'bg-purple-100 text-purple-700 border border-purple-200',
                                            'Sedang Magang' => 'bg-cyan-100 text-cyan-700 border border-cyan-200',
                                            'Selesai' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                            'Dibatalkan' => 'bg-gray-100 text-gray-700 border border-gray-200',
                                            default => 'bg-gray-100 text-gray-600 border border-gray-200'
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClasses }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.riwayat-pengajuan.show', $p->public_id) }}" 
                                       class="inline-block bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-xl border border-emerald-150 transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-150">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>
</x-layouts.internal>
