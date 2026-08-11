<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Instrumen Pertanyaan SKM</h2>
            <p class="text-xs text-gray-400 mt-1">Kelola daftar indikator kepuasan pelayanan magang/PKL yang dinilai oleh peserta.</p>
        </div>
        <a href="{{ route('admin.skm-pertanyaan.create') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Pertanyaan</span>
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

    <!-- Questions Table Listing -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($pertanyaans->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-gray-500 font-medium">Belum ada instrumen kuesioner yang ditambahkan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4 style-cell" style="width: 10%;">Urutan</th>
                            <th class="px-6 py-4" style="width: 60%;">Pernyataan Evaluasi</th>
                            <th class="px-6 py-4" style="width: 15%;">Status</th>
                            <th class="px-6 py-4 text-right" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($pertanyaans as $item)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-800 text-sm">
                                    #{{ $item->urutan }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-850">
                                    {{ $item->teks_pertanyaan }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->is_active)
                                        <span class="inline-block text-[9px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full uppercase">Aktif</span>
                                    @else
                                        <span class="inline-block text-[9px] bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full uppercase">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-2">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.skm-pertanyaan.edit', $item->id) }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition-all">
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form method="POST" action="{{ route('admin.skm-pertanyaan.destroy', $item->id) }}"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-655 border border-red-200 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
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
        @endif
    </div>
</x-layouts.internal>
