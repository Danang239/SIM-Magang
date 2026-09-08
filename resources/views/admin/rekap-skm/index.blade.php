<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Rekapitulasi Kepuasan Masyarakat (SKM)</h2>
            <p class="text-xs text-gray-400 mt-1">Pantau dan unduh rekap data kepuasan layanan per kuartal secara terperinci.</p>
        </div>

        <!-- Export Actions -->
        @if($totalResponden > 0)
            <div class="flex items-center space-x-2 w-fit">
                <a href="{{ route('admin.rekap-skm.excel', ['year' => $year, 'quarter' => $quarter]) }}" 
                   class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs px-4 py-2.5 rounded-xl font-bold border border-emerald-200 transition-colors flex items-center space-x-1.5" title="Unduh Spreadsheet Excel">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Excel</span>
                </a>
                <a href="{{ route('admin.rekap-skm.csv', ['year' => $year, 'quarter' => $quarter]) }}" 
                   class="bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs px-4 py-2.5 rounded-xl font-bold border border-gray-200 transition-colors flex items-center space-x-1.5" title="Unduh Plain Text CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>CSV</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Filter & Summary Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <!-- Filter Form -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm lg:col-span-3 flex flex-col sm:flex-row items-end gap-4">
            <form method="GET" action="{{ route('admin.rekap-skm.index') }}" class="w-full grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="year" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tahun</label>
                    <select id="year" name="year" class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
                        @php
                            $currentYear = \Carbon\Carbon::now()->year;
                        @endphp
                        @for($y = $currentYear; $y >= $currentYear - 4; $y--)
                            <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="quarter" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kuartal</label>
                    <select id="quarter" name="quarter" class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2.5 bg-white focus:ring-emerald-500 focus:border-emerald-500 focus:ring-1 outline-none">
                        <option value="1" {{ $quarter === 1 ? 'selected' : '' }}>Kuartal 1 (Jan - Mar)</option>
                        <option value="2" {{ $quarter === 2 ? 'selected' : '' }}>Kuartal 2 (Apr - Jun)</option>
                        <option value="3" {{ $quarter === 3 ? 'selected' : '' }}>Kuartal 3 (Jul - Sep)</option>
                        <option value="4" {{ $quarter === 4 ? 'selected' : '' }}>Kuartal 4 (Okt - Des)</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Total Responden Card -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 bg-emerald-50 text-emerald-700 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Responden</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">{{ $totalResponden }}</p>
            </div>
        </div>
    </div>

    <!-- Rating Averages Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 text-sm font-sans uppercase tracking-wider">Rata-rata Penilaian per Pertanyaan</h3>
        </div>

        @if($totalResponden === 0)
            <div class="p-12 text-center text-gray-400 text-xs italic">
                Tidak ada data responden SKM yang ditemukan pada periode Kuartal {{ $quarter }} Tahun {{ $year }}.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-gray-400 font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Butir Pertanyaan Layanan</th>
                            <th class="py-4 px-6 w-40 text-center">Rata-Rata Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-700">
                        @foreach($rekapData as $idx => $r)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-400 text-center">{{ $idx + 1 }}</td>
                                <td class="py-4 px-6 font-semibold leading-relaxed">{{ $r['teks'] }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center space-x-1.5 bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full border border-yellow-100 font-bold">
                                        <svg class="w-3.5 h-3.5 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>{{ $r['average'] }} / 4.00</span>
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
