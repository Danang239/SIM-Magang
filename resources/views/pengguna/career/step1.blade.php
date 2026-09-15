<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto mt-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Daftar Program PKL</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="1" />

            <!-- Info Panel -->
            <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-5 mb-6 flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0">
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Bidang Dipilih</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $bidang->nama_bidang }}</p>
                </div>
                <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Kategori</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $bidang->kategori }}</p>
                </div>
                <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Jalur / Jenjang</p>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">Jalur {{ $bidang->jenjang }}</p>
                </div>
                <a href="{{ route('home') }}" class="sm:ml-auto text-xs text-emerald-600 hover:text-emerald-800 font-semibold underline transition-colors">Ganti bidang</a>
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

            <!-- Form -->
            <form method="POST" action="{{ route('pengguna.career.step1.store') }}" id="formStep1"
                x-data='kalenderPKL({
                    kalender: @json($kalender),
                    durasiBulan: {{ old('durasi_bulan', $step1Data['durasi_bulan'] ?? 2) }},
                    apiUrl: "{{ route('pengguna.career.api.kuota', $bidang->id) }}"
                })'
                x-init="init()">
                @csrf
                
                <input type="hidden" name="tanggal_mulai" id="inputTanggalMulai" value="{{ old('tanggal_mulai', $step1Data['tanggal_mulai'] ?? '') }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Left: Inputs -->
                    <div class="md:col-span-1 bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-6">
                        <div>
                            <label for="durasi_bulan" class="block text-sm font-bold text-gray-700 mb-2">Durasi PKL</label>
                            <select name="durasi_bulan" id="durasi_bulan" 
                                x-model="durasiBulan"
                                @change="watchDurasi()"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="2">2 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="4">4 Bulan</option>
                                <option value="5">5 Bulan</option>
                                <option value="6">6 Bulan</option>
                            </select>
                        </div>

                        <div>
                            <label for="keahlian" class="block text-sm font-bold text-gray-700 mb-2">Keahlian / Kompetensi</label>
                            <textarea name="keahlian" id="keahlian" rows="4"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                placeholder="Sebutkan keahlian, kompetensi, atau bidang riset yang Anda minati terkait bidang ini...">{{ old('keahlian', $step1Data['keahlian'] ?? '') }}</textarea>
                        </div>

                        <!-- Panduan Indikator Warna Kalender -->
                        <div class="pt-4 border-t border-gray-150 space-y-3">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Panduan Warna Kalender</span>
                            </h3>
                            
                            <div class="space-y-2 text-xs">
                                <!-- Hijau (Tersedia) -->
                                <div class="p-2.5 rounded-xl bg-emerald-50/90 border border-emerald-200 flex items-start space-x-2.5">
                                    <span class="w-3.5 h-3.5 rounded-md bg-emerald-500 shrink-0 mt-0.5 shadow-xs"></span>
                                    <div>
                                        <p class="font-bold text-emerald-950">Hijau (Tersedia)</p>
                                        <p class="text-[11px] text-emerald-800 leading-snug mt-0.5">
                                            Slot kuota terbuka dan sudah memenuhi jeda minimal 14 hari verifikasi. Anda bebas memilih tanggal ini sebagai awal PKL.
                                        </p>
                                    </div>
                                </div>

                                <!-- Merah (Penuh) -->
                                <div class="p-2.5 rounded-xl bg-red-50/90 border border-red-200 flex items-start space-x-2.5">
                                    <span class="w-3.5 h-3.5 rounded-md bg-red-500 shrink-0 mt-0.5 shadow-xs"></span>
                                    <div>
                                        <p class="font-bold text-red-950">Merah (Slot Penuh)</p>
                                        <p class="text-[11px] text-red-800 leading-snug mt-0.5">
                                            Kapasitas pembimbing pada rentang waktu ini sedang terisi penuh oleh peserta lain.
                                        </p>
                                    </div>
                                </div>

                                <!-- Abu-Abu (Jeda Verifikasi) -->
                                <div class="p-2.5 rounded-xl bg-gray-50 border border-gray-200 flex items-start space-x-2.5">
                                    <span class="w-3.5 h-3.5 rounded-md bg-gray-400 shrink-0 mt-0.5 shadow-xs"></span>
                                    <div>
                                        <p class="font-bold text-gray-800">Abu-Abu (Jeda 14 Hari)</p>
                                        <p class="text-[11px] text-gray-600 leading-snug mt-0.5">
                                            Masa persiapan administrasi dan verifikasi berkas oleh admin sejak tanggal pendaftaran (terkunci otomatis).
                                        </p>
                                    </div>
                                </div>

                                <!-- Hijau Tua (Dipilih) -->
                                <div class="p-2.5 rounded-xl bg-emerald-100/70 border border-emerald-300 flex items-start space-x-2.5">
                                    <span class="w-3.5 h-3.5 rounded-md bg-emerald-700 shrink-0 mt-0.5 ring-2 ring-emerald-600 ring-offset-1"></span>
                                    <div>
                                        <p class="font-bold text-emerald-950">Dipilih</p>
                                        <p class="text-[11px] text-emerald-800 leading-snug mt-0.5">
                                            Tanggal mulai PKL yang saat ini sedang Anda tentukan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Calendar -->
                    <div id="container-kalender" class="md:col-span-2 bg-white rounded-2xl border border-gray-150 shadow-sm p-6 flex flex-col justify-between transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                                <h2 class="text-base font-bold text-gray-800 font-sans">Pilih Tanggal Mulai PKL <span class="text-red-500">*</span></h2>
                                <div class="flex flex-wrap items-center gap-2.5 text-[10px] font-semibold">
                                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-100 border border-emerald-300"></span><span class="text-gray-600">Tersedia</span></span>
                                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-sm bg-red-100 border border-red-300"></span><span class="text-gray-600">Penuh</span></span>
                                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-sm bg-gray-100 border border-gray-300"></span><span class="text-gray-600">Jeda Verifikasi (14 Hari)</span></span>
                                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-600 border border-emerald-700"></span><span class="text-gray-600">Dipilih</span></span>
                                </div>
                            </div>

                            @php
                                $adaTanggalTersedia = collect($kalender)->where('tipe', 'tersedia')->count() > 0;
                            @endphp

                            @if(!$adaTanggalTersedia)
                                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-3 text-xs text-red-900">
                                    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <p class="font-bold">Seluruh Kuota Periode Ini Penuh</p>
                                        <p class="mt-0.5 text-red-800 leading-relaxed">
                                            Seluruh slot kuota pada pembimbing ini telah terisi penuh hingga 4 bulan ke depan. Belum ada slot pendaftaran yang dapat dipilih pada rentang kalender ini.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Calendar Navigation -->
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" @click="prevMonth()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" :disabled="!canGoPrev()">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <h3 class="font-bold text-gray-800 text-sm" x-text="bulanTampil()"></h3>
                                <button type="button" @click="nextMonth()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>

                            <!-- Day Headers -->
                            <div class="grid grid-cols-7 mb-2">
                                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
                                    <div class="text-center text-[10px] font-bold text-gray-400 py-1">{{ $hari }}</div>
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
                                            'bg-emerald-600 text-white font-bold shadow-md ring-2 ring-emerald-500 ring-offset-1': selectedDate === formatTanggal(currentYear, currentMonth, day),
                                            'bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold hover:scale-105 cursor-pointer': selectedDate !== formatTanggal(currentYear, currentMonth, day) && isAvailable(formatTanggal(currentYear, currentMonth, day)),
                                            'bg-red-50 text-red-400 border border-red-200 cursor-not-allowed': selectedDate !== formatTanggal(currentYear, currentMonth, day) && isFull(formatTanggal(currentYear, currentMonth, day)),
                                            'bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed': selectedDate !== formatTanggal(currentYear, currentMonth, day) && isJedaVerifikasi(formatTanggal(currentYear, currentMonth, day)),
                                            'text-gray-300 cursor-not-allowed bg-transparent': selectedDate !== formatTanggal(currentYear, currentMonth, day) && isLampau(formatTanggal(currentYear, currentMonth, day)),
                                        }"
                                        class="w-full aspect-square rounded-lg text-xs transition-all duration-150 flex flex-col items-center justify-center"
                                        :title="getTooltip(formatTanggal(currentYear, currentMonth, day))"
                                        x-text="day">
                                    </button>
                                </template>
                            </div>

                            <!-- Selected date info -->
                            <div x-show="selectedDate" x-cloak class="mt-6 p-4 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-emerald-600 font-semibold uppercase tracking-wider">Tanggal Mulai & Rencana Selesai</p>
                                    <p class="font-bold text-emerald-900 text-sm mt-0.5" x-text="formatTampilTanggal(selectedDate)"></p>
                                    <p class="text-xs text-emerald-600 mt-1 font-medium" x-text="'Hingga: ' + formatTampilTanggal(tanggalSelesai())"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-emerald-600 font-semibold">Slot Sisa</p>
                                    <p class="font-bold text-emerald-900 text-sm" x-text="slotSisa() + ' / ' + (kalender[selectedDate]?.kapasitas ?? '-')"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Submit Actions -->
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-emerald-700 transition-colors font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Batal</span>
                    </a>
                    <button type="button"
                        onclick="submitStep1()"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <span>Lanjut ke Pengisian Biodata</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function kalenderPKL({ kalender, durasiBulan, apiUrl }) {
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
                const info = this.kalender[tanggalStr];
                return info && info.tersedia === true;
            },

            isFull(tanggalStr) {
                const info = this.kalender[tanggalStr];
                return info && info.tipe === 'penuh';
            },

            isJedaVerifikasi(tanggalStr) {
                const info = this.kalender[tanggalStr];
                return info && info.tipe === 'jeda_verifikasi';
            },

            isLampau(tanggalStr) {
                const info = this.kalender[tanggalStr];
                return !info || info.tipe === 'lampau';
            },

            getTooltip(tanggalStr) {
                const info = this.kalender[tanggalStr];
                if (!info || info.tipe === 'lampau') return 'Tanggal sudah lewat';
                if (info.tipe === 'jeda_verifikasi') return 'Masa jeda verifikasi berkas (14 hari)';
                if (info.tipe === 'penuh') return `Slot Penuh (${info.terisi}/${info.kapasitas} terisi)`;
                return `Tersedia (${info.slot_sisa} slot sisa) — Klik untuk memilih`;
            },

            pilihTanggal(tanggalStr) {
                if (!this.isAvailable(tanggalStr)) return;
                this.selectedDate = tanggalStr;
                document.getElementById('inputTanggalMulai').value = tanggalStr;
            },

            tanggalSelesai() {
                if (!this.selectedDate) return null;
                const d = new Date(this.selectedDate + 'T00:00:00');
                d.setMonth(d.getMonth() + parseInt(this.durasiBulan));
                d.setDate(d.getDate() - 1);
                return d.toISOString().slice(0, 10);
            },

            slotSisa() {
                if (!this.selectedDate || !this.kalender[this.selectedDate]) return '-';
                return this.kalender[this.selectedDate].slot_sisa;
            },

            watchDurasi() {
                fetch(`${this.apiUrl}?durasi=${this.durasiBulan}`)
                    .then(res => res.json())
                    .then(data => {
                        this.kalender = data;
                        if (this.selectedDate && !this.isAvailable(this.selectedDate)) {
                            this.selectedDate = null;
                            document.getElementById('inputTanggalMulai').value = '';
                        }
                    });
            }
        };
    }

    function submitStep1() {
        const keahlian = document.getElementById('keahlian');
        if (!keahlian || !keahlian.value.trim()) {
            showFloatingError('Silakan isi uraian Keahlian / Kompetensi yang Anda miliki atau minati.', keahlian);
            return;
        }

        const tgl = document.getElementById('inputTanggalMulai').value;
        const containerKalender = document.getElementById('container-kalender');
        if (!tgl) {
            showFloatingError('Silakan pilih salah satu Tanggal Mulai PKL yang masih tersedia pada kalender.', containerKalender);
            return;
        }

        document.getElementById('formStep1').submit();
    }
    </script>
</x-layouts.publik>
