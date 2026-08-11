<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Antrean Verifikasi Berkas</h2>
            <p class="text-xs text-gray-400 mt-1">Daftar semua pengajuan baru yang menunggu verifikasi kelengkapan berkas.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Panel -->
    <div class="bg-white rounded-2xl border border-gray-255 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('petugas.verifikasi.index') }}" class="flex items-center space-x-3">
            <div class="relative flex-grow max-w-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 pl-9 pr-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Cari No. Pengajuan atau nama pemohon...">
                <div class="absolute left-3 top-3 text-gray-450">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('petugas.verifikasi.index') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Queue -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($pengajuans->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-500 font-medium">Tidak ada pengajuan magang yang perlu diverifikasi.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">No. Pengajuan</th>
                            <th class="px-6 py-4">Nama Pemohon</th>
                            <th class="px-6 py-4">Pendidikan / Jurusan</th>
                            <th class="px-6 py-4">Pilihan Bidang</th>
                            <th class="px-6 py-4">Tanggal Kirim</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($pengajuans as $item)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-800 tracking-wider">
                                    {{ $item->nomor_pengajuan }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $item->user->instansi ?? '-' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $item->user->program_studi ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">{{ $item->bidang->nama_bidang }}</p>
                                    <span class="inline-block text-[9px] bg-emerald-50 text-biogen-dark px-1.5 py-0.5 rounded font-bold uppercase mt-0.5">{{ $item->jenjang }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $item->created_at->translatedFormat('d M Y — H:i') }} WIB
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('petugas.verifikasi.show', $item->public_id) }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-[10px] font-bold px-4 py-2 rounded-lg shadow-sm transition-all inline-block">
                                        Tinjau Berkas
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
</x-layouts.internal>
