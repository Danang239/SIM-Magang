<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Kelola Bidang &amp; Kuota Penempatan</h2>
            <p class="text-xs text-gray-400 mt-1">Kelola bidang PKL/magang, alokasi kapasitas kuota, ruang lingkup bidang, dan pembimbing yang ditugaskan.</p>
        </div>
        <a href="{{ route('admin.bidang.create') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Bidang</span>
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Panel -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.bidang.index') }}" class="flex items-center space-x-3">
            <div class="relative flex-grow max-w-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 pl-9 pr-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Cari nama bidang penempatan...">
                <div class="absolute left-3 top-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.bidang.index') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Bidang Table Listing -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($bidangs->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <p class="text-xs text-gray-500 font-medium">Tidak ada bidang penempatan yang ditemukan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Nama Bidang</th>
                            <th class="px-6 py-4">Jenjang</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Kapasitas Slot</th>
                            <th class="px-6 py-4">Pembimbing Ditugaskan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($bidangs as $bidang)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if($bidang->gambar)
                                            <img src="{{ asset('storage/' . $bidang->gambar) }}" alt="{{ $bidang->nama_bidang }}" class="w-10 h-10 object-cover rounded-lg shadow-sm shrink-0 border border-gray-200" />
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-emerald-100/60 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-200">
                                                {{ strtoupper(substr($bidang->nama_bidang, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-800 text-sm">{{ $bidang->nama_bidang }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5 max-w-xs truncate">{{ $bidang->deskripsi }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-[9px] bg-emerald-50 text-biogen-dark px-2 py-0.5 rounded font-bold uppercase border border-emerald-100">
                                        {{ $bidang->jenjang }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-[9px] bg-emerald-50 text-biogen-dark px-2 py-0.5 rounded font-bold uppercase border border-emerald-100">
                                        {{ $bidang->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800 text-sm">
                                    {{ $bidang->kapasitas_total }} Slot
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @forelse($bidang->pembimbings as $pembimbing)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                                {{ $pembimbing->nama }} ({{ $pembimbing->pivot->kuota ?? $pembimbing->kuota_default }})
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-[10px]">Belum ditentukan</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($bidang->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.bidang.edit', $bidang->id) }}" class="p-1.5 text-gray-400 hover:text-biogen-medium hover:bg-emerald-50 rounded-lg transition" title="Edit Bidang">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.bidang.destroy', $bidang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Bidang">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bidangs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $bidangs->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.internal>
