<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program Magang & PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="4" />

            <!-- Info Panel -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6 flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Bidang Dipilih</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $bidang->nama_bidang }}</p>
                </div>
                <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Jenjang</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $step3['jenjang'] }}</p>
                </div>
                <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Durasi</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $durasiBulan }} Bulan</p>
                </div>
                <a href="{{ route('pengguna.career.step3') }}" class="sm:ml-auto text-xs text-gray-400 hover:text-biogen-medium underline transition-colors">Ganti bidang</a>
            </div>

            <!-- Alpine.js Calendar -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6"
                x-data='kalenderMagang({
                    kalender: @json($kalender),
                    durasiBulan: {{ $durasiBulan }},
                    apiUrl: "{{ route('pengguna.career.api.kuota', $bidang->id) }}"
                })'
                x-init="init()">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 font-sans">Pilih Tanggal Mulai Magang</h2>
                    <div class="flex items-center space-x-3 text-xs font-semibold">
                        <span class="flex items-center space-x-1"><span class="w-3 h-3 rounded-sm bg-green-200 border border-green-300"></span><span class="text-gray-500">Tersedia</span></span>
                        <span class="flex items-center space-x-1"><span class="w-3 h-3 rounded-sm bg-red-100 border border-red-200"></span><span class="text-gray-500">Penuh</span></span>
                        <span class="flex items-center space-x-1"><span class="w-3 h-3 rounded-sm bg-biogen-dark border border-biogen-dark"></span><span class="text-gray-500">Dipilih</span></span>
                    </div>
                </div>

                <!-- Calendar Navigation -->
                <div class="flex items-center justify-between mb-4">
                    <button type="button" @click="prevMonth()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" :disabled="!canGoPrev()">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <h3 class="font-bold text-gray-800 text-base" x-text="bulanTampil()"></h3>
                    <button type="button" @click="nextMonth()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <!-- Day Headers -->
                <div class="grid grid-cols-7 mb-2">
                    @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
                        <div class="text-center text-xs font-bold text-gray-400 py-1">{{ $hari }}</div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1">
                    <!-- Empty cells before first day -->
                    <template x-for="n in startDayOfMonth()" :key="'empty-'+n">
                        <div></div>
                    </template>
                    <!-- Day cells -->
                    <template x-for="day in daysInMonth()" :key="day">
                        <button type="button"
                            @click="pilihTanggal(formatTanggal(currentYear, currentMonth, day))"
                            :disabled="!isAvailable(formatTanggal(currentYear, currentMonth, day))"
                            :class="{
                                'bg-biogen-dark text-white shadow-md': selectedDate === formatTanggal(currentYear, currentMonth, day),
                                'bg-green-100 hover:bg-green-200 text-green-800': selectedDate !== formatTanggal(currentYear, currentMonth, day) && isAvailable(formatTanggal(currentYear, currentMonth, day)) && !isFull(formatTanggal(currentYear, currentMonth, day)),
                                'bg-red-50 text-red-300 cursor-not-allowed': isFull(formatTanggal(currentYear, currentMonth, day)) && selectedDate !== formatTanggal(currentYear, currentMonth, day),
                                'text-gray-300 cursor-not-allowed': !isAvailable(formatTanggal(currentYear, currentMonth, day)) && !isFull(formatTanggal(currentYear, currentMonth, day)),
                            }"
                            class="w-full aspect-square rounded-lg text-sm font-semibold transition-all duration-150 flex flex-col items-center justify-center"
                            :title="isFull(formatTanggal(currentYear, currentMonth, day)) ? 'Slot penuh' : (!isAvailable(formatTanggal(currentYear, currentMonth, day)) ? 'Tanggal tidak tersedia' : 'Klik untuk pilih')"
                            x-text="day">
                        </button>
                    </template>
                </div>

                <!-- Selected date info -->
                <div x-show="selectedDate" x-cloak class="mt-6 p-4 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Tanggal Dipilih</p>
                        <p class="font-bold text-emerald-900 mt-0.5" x-text="formatTampilTanggal(selectedDate)"></p>
                        <p class="text-xs text-emerald-600 mt-1" x-text="'s/d ' + formatTampilTanggal(tanggalSelesai())"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-emerald-600 font-semibold">Slot Sisa</p>
                        <p class="font-bold text-emerald-900" x-text="slotSisa() + ' / ' + (kalender[selectedDate]?.kapasitas ?? '-')"></p>
                    </div>
                </div>
            </div>

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Submit -->
            <form method="POST" action="{{ route('pengguna.career.step4.store') }}" id="formStep4">
                @csrf
                <input type="hidden" name="tanggal_mulai" id="inputTanggalMulai" value="{{ old('tanggal_mulai') }}">

                <div class="flex items-center justify-between">
                    <a href="{{ route('pengguna.career.step3') }}" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Kembali</span>
                    </a>
                    <button type="button"
                        onclick="submitStep4()"
                        class="bg-biogen-medium hover:bg-biogen-light text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <span>Lanjut ke Konfirmasi</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function kalenderMagang({ kalender, durasiBulan, apiUrl }) {
        return {
            kalender,
            durasiBulan,
            apiUrl,
            selectedDate: null,
            currentYear: new Date().getFullYear(),
            currentMonth: new Date().getMonth() + 1,

            init() {
                const oldVal = document.getElementById('inputTanggalMulai').value;
                if (oldVal) this.selectedDate = oldVal;
            },

            formatTanggal(y, m, d) {
                return `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            },

            formatTampilTanggal(tanggalStr) {
                if (!tanggalStr) return '';
                const d = new Date(tanggalStr + 'T00:00:00');
                return d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
            },

            bulanTampil() {
                const d = new Date(this.currentYear, this.currentMonth - 1, 1);
                return d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            },

            daysInMonth() {
                return new Date(this.currentYear, this.currentMonth, 0).getDate();
            },

            startDayOfMonth() {
                return new Date(this.currentYear, this.currentMonth - 1, 1).getDay();
            },

            canGoPrev() {
                const now = new Date();
                return !(this.currentYear === now.getFullYear() && this.currentMonth === now.getMonth() + 1);
            },

            prevMonth() {
                if (!this.canGoPrev()) return;
                if (this.currentMonth === 1) { this.currentMonth = 12; this.currentYear--; }
                else this.currentMonth--;
            },

            nextMonth() {
                if (this.currentMonth === 12) { this.currentMonth = 1; this.currentYear++; }
                else this.currentMonth++;
            },

            isAvailable(tanggalStr) {
                return this.kalender[tanggalStr] !== undefined;
            },

            isFull(tanggalStr) {
                const info = this.kalender[tanggalStr];
                return info && !info.tersedia;
            },

            pilihTanggal(tanggalStr) {
                if (!this.isAvailable(tanggalStr) || this.isFull(tanggalStr)) return;
                this.selectedDate = tanggalStr;
                document.getElementById('inputTanggalMulai').value = tanggalStr;
            },

            tanggalSelesai() {
                if (!this.selectedDate) return null;
                const d = new Date(this.selectedDate + 'T00:00:00');
                d.setMonth(d.getMonth() + this.durasiBulan);
                d.setDate(d.getDate() - 1);
                return d.toISOString().slice(0, 10);
            },

            slotSisa() {
                if (!this.selectedDate || !this.kalender[this.selectedDate]) return '-';
                return this.kalender[this.selectedDate].slot_sisa;
            },
        };
    }

    function submitStep4() {
        const tgl = document.getElementById('inputTanggalMulai').value;
        if (!tgl) {
            alert('Silakan pilih tanggal mulai magang terlebih dahulu.');
            return;
        }
        document.getElementById('formStep4').submit();
    }
    </script>
</x-layouts.publik>
