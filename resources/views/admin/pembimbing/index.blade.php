<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Kelola Master Pembimbing</h2>
            <p class="text-xs text-gray-400 mt-1">Daftar nama pembimbing lapangan / peneliti, pengaturan bidang binaan, dan kapasitas kuota fleksibel.</p>
        </div>
        <a href="{{ route('admin.pembimbing.create') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span>Tambah Pembimbing</span>
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

    <!-- Search & Filter Panel -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.pembimbing.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 pl-9 pr-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Cari nama pembimbing, NIP, email, atau jabatan...">
                <div class="absolute left-3 top-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <div class="flex items-center space-x-2 shrink-0">
                <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pembimbing.index') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-xs font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Pembimbing Table Listing -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($pembimbings->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-xs text-gray-500 font-medium">Belum ada data pembimbing yang terdaftar.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Nama Pembimbing</th>
                            <th class="px-6 py-4">NIP / Jabatan</th>
                            <th class="px-6 py-4">Kontak / Email</th>
                            <th class="px-6 py-4">Bidang Binaan &amp; Kuota</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($pembimbings as $p)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-biogen-medium flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($p->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 text-sm">{{ $p->nama }}</p>
                                            <p class="text-[11px] text-gray-400">{{ $p->pengajuans_count }} pengajuan dibimbing</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-700">{{ $p->nip ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $p->jabatan ?? 'Pembimbing' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-700">{{ $p->email ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $p->no_hp ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5 max-w-xs">
                                        @forelse($p->bidangs as $b)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                {{ $b->nama_bidang }}: <span class="ml-1 font-bold text-emerald-950">{{ $b->pivot->kuota ?? 5 }} Kuota</span>
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-[11px]">Belum ditugaskan ke bidang</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->is_active)
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
                                        <a href="{{ route('admin.pembimbing.edit', $p->id) }}" class="p-1.5 text-gray-400 hover:text-biogen-medium hover:bg-emerald-50 rounded-lg transition" title="Edit Pembimbing">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.pembimbing.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembimbing ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Pembimbing">
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
            @if($pembimbings->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pembimbings->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.internal>
