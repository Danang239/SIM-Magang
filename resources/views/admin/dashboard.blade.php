<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Dashboard Administrator</h2>
            <p class="text-xs text-gray-400 mt-1">Kelola hak akses sistem, konfigurasi instrumen SKM, dan pantau laporan analisis tahunan secara menyeluruh.</p>
        </div>
        
        <!-- Export Multi-Format Form -->
        <form id="exportForm" method="GET" action="{{ route('admin.laporan-tahunan.export') }}" class="flex items-center space-x-2 w-fit">
            <span class="text-xs text-gray-400 font-semibold mr-1">Tahun Rekap:</span>
            <select id="exportYear" name="year" class="text-xs rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-biogen-medium focus:border-biogen-medium outline-none">
                @php
                    $currentYear = \Carbon\Carbon::now()->year;
                @endphp
                @for($y = $currentYear; $y >= $currentYear - 4; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
            
            <!-- Export PDF -->
            <button type="button" onclick="submitExport('pdf')" class="bg-red-50 hover:bg-red-100 text-red-650 text-xs px-3.5 py-2 rounded-xl font-bold border border-red-200 transition-colors flex items-center space-x-1.5" title="Unduh PDF Resmi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>PDF</span>
            </button>

            <!-- Export Excel -->
            <button type="button" onclick="submitExport('excel')" class="bg-emerald-50 hover:bg-emerald-100 text-biogen-medium text-xs px-3.5 py-2 rounded-xl font-bold border border-emerald-200 transition-colors flex items-center space-x-1.5" title="Unduh Spreadsheet Excel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Excel</span>
            </button>

            <!-- Export CSV -->
            <button type="button" onclick="submitExport('csv')" class="bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs px-3.5 py-2 rounded-xl font-bold border border-gray-200 transition-colors flex items-center space-x-1.5" title="Unduh Plain Text CSV">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>CSV</span>
            </button>
        </form>

        <script>
            function submitExport(type) {
                const form = document.getElementById('exportForm');
                if (type === 'pdf') {
                    form.action = "{{ route('admin.laporan-tahunan.export') }}";
                } else if (type === 'excel') {
                    form.action = "{{ route('admin.laporan.excel') }}";
                } else if (type === 'csv') {
                    form.action = "{{ route('admin.laporan.csv') }}";
                }
                form.submit();
            }
        </script>
    </div>

    <!-- Statistik Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Pengguna Terdaftar -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 bg-emerald-50 text-biogen-medium rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Total Pengguna Terdaftar</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        <!-- Total Pengajuan Semua Waktu -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Total Pengajuan Magang</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">{{ $stats['total_pengajuans'] }}</p>
            </div>
        </div>

        <!-- Rata-rata Skor SKM -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 bg-yellow-50 text-status-menunggu rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.252.583 1.808l-3.978 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.978-2.89a1 1 0 00-1.176 0l-3.978 2.89c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.978-2.89c-.77-.556-.372-1.808.583-1.808h4.907a1 1 0 00.95-.69l1.519-4.674z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Rata-Rata Kepuasan (SKM)</p>
                <p class="text-2xl font-bold text-gray-800 mt-0.5">{{ $stats['skm_average'] }} / 5.00</p>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Grafik Tren Bulanan -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-850 mb-4 font-sans text-xs tracking-wide uppercase text-gray-400">Tren Pengajuan Bulanan</h3>
            <div class="relative h-72">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <!-- Grafik Distribusi Bidang -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-850 mb-4 font-sans text-xs tracking-wide uppercase text-gray-400">Distribusi Pendaftar per Bidang</h3>
            <div class="relative h-72">
                <canvas id="bidangDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- SKM Evaluation Questions Analytics Section -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-8">
        <div class="border-b border-gray-100 pb-4 mb-6">
            <h3 class="font-bold text-gray-850 font-sans text-sm tracking-wide uppercase text-gray-400">Analisis Detail Instrumen SKM</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">Persentase distribusi rating 1-5 bintang untuk masing-masing kuesioner layanan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($skmQuestions as $q)
                <div class="p-4 rounded-xl border border-gray-150 bg-gray-50 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800 line-clamp-2 h-8" title="{{ $q['teks'] }}">
                            {{ $q['id'] }}. {{ $q['teks'] }}
                        </p>
                        <p class="text-[10px] text-gray-400 mt-1 font-semibold">
                            Rata-Rata: <span class="text-yellow-600 font-bold">{{ $q['average'] }} / 5.00</span> 
                            ({{ $q['total_responses'] }} Responden)
                        </p>
                    </div>

                    <div class="relative h-44 w-full mt-4 flex items-center justify-center">
                        @if($q['total_responses'] === 0)
                            <span class="text-[10px] text-gray-400 italic">Belum ada respon</span>
                        @else
                            <canvas id="skmPie_{{ $q['id'] }}"></canvas>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ChartJS Script Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data Bulanan
            const monthlyMonths = {!! json_encode($monthlyData->pluck('month')) !!};
            const monthlyCounts = {!! json_encode($monthlyData->pluck('count')) !!};

            // Data Bidang
            const bidangNames = {!! json_encode($bidangData->pluck('nama')) !!};
            const bidangCounts = {!! json_encode($bidangData->pluck('count')) !!};

            // Monthly Trend Chart (Line Chart)
            const ctxLine = document.getElementById('monthlyTrendChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: monthlyMonths.length > 0 ? monthlyMonths : ['No Data'],
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: monthlyCounts.length > 0 ? monthlyCounts : [0],
                        borderColor: '#2F9A32',
                        backgroundColor: 'rgba(47, 154, 50, 0.1)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointBackgroundColor: '#0B5E3C'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });

            // Bidang Distribution Chart (Bar Chart)
            const ctxBar = document.getElementById('bidangDistributionChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: bidangNames.length > 0 ? bidangNames.map(name => name.length > 15 ? name.substring(0, 15) + '...' : name) : ['No Data'],
                    datasets: [{
                        label: 'Peserta',
                        data: bidangCounts.length > 0 ? bidangCounts : [0],
                        backgroundColor: [
                            'rgba(11, 94, 60, 0.8)',
                            'rgba(47, 154, 50, 0.8)',
                            'rgba(107, 191, 89, 0.8)',
                            'rgba(59, 130, 246, 0.8)'
                        ],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });

            // SKM Questions Pie Charts
            const skmQuestions = {!! json_encode($skmQuestions) !!};
            const ratingLabels = ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'];
            const ratingColors = ['#ef4444', '#f97316', '#eab308', '#3b82f6', '#10b981'];

            skmQuestions.forEach(function (q) {
                if (q.total_responses > 0) {
                    const ctxPie = document.getElementById('skmPie_' + q.id).getContext('2d');
                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: ratingLabels,
                            datasets: [{
                                data: q.ratings,
                                backgroundColor: ratingColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 8,
                                        font: { size: 9 }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
</x-layouts.internal>
