<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Daftar Bidang Penempatan</h2>
            <p class="text-xs text-gray-400 mt-1">Kelola divisi, kapasitas rolling, pembimbing, dan status aktif bidang penempatan magang/PKL.</p>
        </div>
        <a href="{{ route('petugas.bidang.create') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
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
        <form method="GET" action="{{ route('petugas.bidang.index') }}" class="flex items-center space-x-3">
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
                <a href="{{ route('petugas.bidang.index') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-xs font-semibold transition-colors">
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
                            <th class="px-6 py-4">Pembimbing</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($bidangs as $bidang)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-800 text-sm">{{ $bidang->nama_bidang }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5 max-w-sm truncate">{{ $bidang->deskripsi }}</p>
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
                                    {{ $bidang->kapasitas }} Slot
                                </td>
                                <td class="px-6 py-4">
                                    @if($bidang->pembimbing)
                                        <p class="font-semibold text-gray-800">{{ $bidang->pembimbing->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $bidang->pembimbing->email }}</p>
                                    @else
                                        <span class="text-gray-400 italic">Belum ditugaskan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($bidang->is_active)
                                        <span class="inline-block text-[9px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full uppercase">Aktif</span>
                                    @else
                                        <span class="inline-block text-[9px] bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full uppercase">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-2">
                                        <!-- Edit -->
                                        <a href="{{ route('petugas.bidang.edit', $bidang->id) }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition-all">
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form method="POST" action="{{ route('petugas.bidang.destroy', $bidang->id) }}"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang {{ $bidang->nama_bidang }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                                                Hapus
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
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $bidangs->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.internal>
