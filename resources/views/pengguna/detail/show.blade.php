<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Breadcrumbs / Back button -->
            <div class="mb-6">
                <a href="{{ route('pengguna.riwayat') }}" class="inline-flex items-center space-x-2 text-sm text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Kembali ke Riwayat</span>
                </a>
            </div>

            <!-- Status Alert (e.g. Success, Errors) -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Application Details (2 columns on large screen) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Core Details Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <!-- Invoice Header -->
                        <div class="bg-biogen-dark px-6 py-5 flex items-center justify-between text-white">
                            <div>
                                <p class="text-emerald-300 text-xs font-bold uppercase tracking-wider">No. Pengajuan</p>
                                <h2 class="text-xl font-extrabold tracking-wider mt-0.5">{{ $pengajuan->nomor_pengajuan }}</h2>
                            </div>
                            @php
                                $badgeClasses = match($pengajuan->status) {
                                    'Disetujui' => 'bg-green-700 text-green-100',
                                    'Menunggu Verifikasi' => 'bg-yellow-600 text-yellow-100',
                                    'Ditolak' => 'bg-red-700 text-red-100',
                                    'Terjadwal' => 'bg-purple-700 text-purple-100',
                                    'Sedang Magang' => 'bg-cyan-700 text-cyan-100',
                                    'Selesai' => 'bg-blue-700 text-blue-100',
                                    'Dibatalkan' => 'bg-gray-600 text-gray-100',
                                    default => 'bg-gray-700 text-gray-100'
                                };
                            @endphp
                            <div class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $badgeClasses }}">
                                {{ $pengajuan->status }}
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="p-6 divide-y divide-gray-100">
                            <!-- Section: Department -->
                            <div class="pb-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pilihan Penempatan</p>
                                <h3 class="text-base font-bold text-gray-800 mt-1">{{ $pengajuan->bidang->nama_bidang }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $pengajuan->bidang->deskripsi }}</p>
                            </div>

                            <!-- Section: Timeline Rencana -->
                            <div class="py-4 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Mulai</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-1">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Selesai (Rencana)</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-1">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai_rencana)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Section: Detail Akademis -->
                            <div class="py-4 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenjang & Instansi</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-1">
                                        {{ $pengajuan->jenjang }} - {{ $pengajuan->user->instansi ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Program Studi</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-1">
                                        {{ $pengajuan->user->program_studi ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Section: Keahlian -->
                            <div class="py-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kompetensi / Keahlian</p>
                                <p class="text-sm text-gray-700 mt-1.5 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    {{ $pengajuan->keahlian }}
                                </p>
                            </div>

                            <!-- Section: Pembimbing -->
                            <div class="py-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pembimbing Lapangan</p>
                                @if($pengajuan->bidang->pembimbing)
                                    <div class="flex items-center space-x-3 mt-2">
                                        <div class="w-9 h-9 rounded-full bg-emerald-100 text-biogen-dark flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($pengajuan->bidang->pembimbing->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $pengajuan->bidang->pembimbing->name }}</p>
                                            <p class="text-[11px] text-gray-400">Pembimbing Resmi BRMP Biogen</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 mt-1">Belum ditugaskan (akan diproses setelah verifikasi disetujui).</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Documents Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-gray-800 text-base mb-4 font-sans">Dokumen Lampiran</h3>
                        <div class="space-y-3">
                            <!-- Surat Pengantar -->
                            <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-emerald-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-biogen-medium flex items-center justify-center">
                                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">Surat Pengantar</p>
                                        <p class="text-[10px] text-gray-400">Diunggah saat pendaftaran</p>
                                    </div>
                                </div>
                                <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']) }}" target="_blank"
                                    class="text-xs font-bold text-biogen-medium hover:text-biogen-dark underline flex items-center space-x-1">
                                    <span>Lihat File</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>

                            <!-- Laporan Akhir (Conditional) -->
                            @if($pengajuan->file_laporan_akhir)
                                <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-emerald-50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-biogen-medium flex items-center justify-center">
                                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-800">Laporan Akhir Magang</p>
                                            <p class="text-[10px] text-gray-400">Status Laporan: <span class="font-bold text-biogen-medium">{{ $pengajuan->laporan_status }}</span></p>
                                        </div>
                                    </div>
                                    <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'laporan_akhir']) }}" target="_blank"
                                        class="text-xs font-bold text-biogen-medium hover:text-biogen-dark underline flex items-center space-x-1">
                                        <span>Lihat File</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            @endif

                            <!-- Surat Keterangan Selesai (Conditional) -->
                            @if($pengajuan->file_surat_keterangan)
                                <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-100 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center shadow">
                                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-emerald-900">Surat Keterangan Selesai Magang</p>
                                            <p class="text-[10px] text-emerald-600 font-medium">Dokumen Resmi BRMP Biogen</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_keterangan']) }}" target="_blank"
                                        class="text-xs font-bold text-emerald-700 hover:text-emerald-950 underline flex items-center space-x-1">
                                        <span>Unduh Bukti</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ===== UPLOAD LAPORAN AKHIR SECTION ===== --}}
                    @if($pengajuan->status === 'Sedang Magang')
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- Card Header --}}
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm font-sans">Unggah Laporan Akhir Magang</h3>
                                        <p class="text-[10px] text-gray-400">Syarat wajib penyelesaian program magang</p>
                                    </div>
                                </div>
                                {{-- Status Badge --}}
                                @if($pengajuan->laporan_status === 'Menunggu Review')
                                    <span class="inline-flex items-center space-x-1.5 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 inline-block"></span>
                                        <span>Menunggu Review</span>
                                    </span>
                                @elseif($pengajuan->laporan_status === 'Ditolak')
                                    <span class="inline-flex items-center space-x-1.5 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                        <span>Ditolak – Upload Ulang</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1.5 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                                        <span>Belum Diunggah</span>
                                    </span>
                                @endif
                            </div>

                            <div class="p-6">
                                {{-- Ditolak Alert --}}
                                @if($pengajuan->laporan_status === 'Ditolak')
                                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <div>
                                            <p class="text-xs font-bold text-red-800">Laporan Akhir Anda Ditolak</p>
                                            <p class="text-xs text-red-600 mt-0.5 leading-relaxed">Petugas telah meninjau laporan Anda dan menyatakan tidak memenuhi syarat. Silakan unggah ulang laporan yang telah diperbaiki.</p>
                                        </div>
                                    </div>
                                @elseif($pengajuan->laporan_status === 'Menunggu Review')
                                    <div class="mb-5 p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <div>
                                            <p class="text-xs font-bold text-yellow-800">Laporan Sedang Ditinjau Petugas</p>
                                            <p class="text-xs text-yellow-700 mt-0.5 leading-relaxed">Laporan Anda telah berhasil diunggah dan sedang menunggu tinjauan dari petugas pembimbing. Harap tunggu notifikasi lebih lanjut.</p>
                                        </div>
                                    </div>
                                @endif

                                {{-- Upload Form (tampil jika belum ada laporan atau ditolak) --}}
                                @if($pengajuan->laporan_status === null || $pengajuan->laporan_status === 'Ditolak')
                                    {{-- Panduan Upload --}}
                                    <ul class="mb-5 space-y-1.5 text-xs text-gray-500">
                                        <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-biogen-medium shrink-0 inline-block"></span><span>Format file: <strong class="text-gray-700">PDF saja</strong></span></li>
                                        <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-biogen-medium shrink-0 inline-block"></span><span>Ukuran maksimal: <strong class="text-gray-700">2 MB</strong></span></li>
                                        <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-biogen-medium shrink-0 inline-block"></span><span>Pastikan laporan sudah ditandatangani dan dicap resmi sebelum diunggah</span></li>
                                    </ul>

                                    <form method="POST" action="{{ route('pengguna.pengajuan.laporan.store', $pengajuan->public_id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center bg-gray-50 hover:border-biogen-medium hover:bg-emerald-50/30 transition-all duration-200 cursor-pointer group"
                                             onclick="document.getElementById('input_laporan').click()">
                                            <svg class="w-10 h-10 text-gray-300 group-hover:text-biogen-medium mx-auto mb-2 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            <p class="text-xs font-bold text-gray-600 group-hover:text-biogen-medium transition-colors duration-200">Klik untuk memilih file PDF</p>
                                            <p class="text-[10px] text-gray-400 mt-1" id="laporan_filename">Belum ada file yang dipilih</p>
                                        </div>
                                        <input type="file" id="input_laporan" name="file_laporan_akhir" accept="application/pdf" class="hidden" required
                                               onchange="document.getElementById('laporan_filename').textContent = this.files[0] ? this.files[0].name : 'Belum ada file yang dipilih'; document.getElementById('btn_kirim_laporan').disabled = false;">

                                        <button type="submit" id="btn_kirim_laporan"
                                            class="mt-4 w-full bg-biogen-medium hover:bg-biogen-light text-white text-sm font-bold py-3 rounded-xl shadow transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            <span class="flex items-center justify-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                                <span>Kirim Laporan Akhir</span>
                                            </span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- SKM Survey Questionnaire Form (Conditional for Selesai) -->
                    @if($pengajuan->status === 'Selesai')
                        @if(!$pengajuan->skmJawabans()->exists())
                            <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 mt-6">
                                <h3 class="font-bold text-gray-800 text-base mb-2 font-sans">Survei Kepuasan Masyarakat (IKM / SKM)</h3>
                                <p class="text-xs text-gray-400 leading-relaxed mb-6">
                                    Mohon berikan penilaian objektif Anda terhadap kualitas pelayanan magang/PKL BRMP Biogen untuk perbaikan sarana kami.
                                </p>

                                <form method="POST" action="{{ route('pengguna.pengajuan.skm.store', $pengajuan->public_id) }}" class="space-y-6">
                                    @csrf
                                    <div class="space-y-4">
                                        @foreach($activeSkmQuestions as $q)
                                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                                <p class="text-xs font-bold text-gray-700 mb-3">{{ $q->urutan }}. {{ $q->teks_pertanyaan }}</p>
                                                <div class="flex items-center space-x-4">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="flex items-center space-x-1 cursor-pointer">
                                                            <input type="radio" name="ratings[{{ $q->id }}]" value="{{ $i }}" class="text-biogen-medium focus:ring-biogen-medium border-gray-300" required>
                                                            <span class="text-xs font-semibold text-gray-600">{{ $i }}</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                                <div class="flex justify-between text-[9px] text-gray-400 mt-1 max-w-xs">
                                                    <span>Sangat Tidak Setuju (1)</span>
                                                    <span>Sangat Setuju (5)</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Saran -->
                                    <div class="mt-4">
                                        <label for="saran" class="block text-xs font-bold text-gray-600 mb-2">Kritik & Saran Perbaikan</label>
                                        <textarea id="saran" name="saran" rows="3"
                                            class="w-full rounded-xl border border-gray-200 text-xs text-gray-800 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition"
                                            placeholder="Masukkan saran tambahan jika ada..."></textarea>
                                    </div>

                                    <div class="flex justify-end pt-4 border-t border-gray-100">
                                        <button type="submit" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow transition-colors">
                                            Kirim Jawaban Survei
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="bg-emerald-50 border border-emerald-100 text-emerald-900 rounded-2xl p-6 mt-6">
                                <h3 class="font-bold text-base font-sans text-emerald-950 flex items-center">
                                    <svg class="w-5 h-5 text-emerald-600 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Terima Kasih Atas Partisipasi Anda!
                                </h3>
                                <p class="text-xs text-emerald-700 mt-1.5 leading-relaxed">
                                    Anda telah mengisi survei kepuasan masyarakat (SKM) untuk pengajuan magang ini. Masukan Anda sangat berharga bagi peningkatan pelayanan kami.
                                </p>
                                @if($pengajuan->skm_saran)
                                    <div class="mt-4 p-4 rounded-xl bg-white/70 border border-emerald-200/50 text-xs text-emerald-900">
                                        <p class="font-bold">Saran Anda:</p>
                                        <p class="mt-1 italic">"{{ $pengajuan->skm_saran }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Right: Timeline / History Logs & Cancel Option -->
                <div class="space-y-6">
                    <!-- Timeline Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-gray-800 text-base mb-6 font-sans">Timeline Status</h3>
                        
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($statusLogs as $index => $log)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <!-- Icon Circle -->
                                                <div>
                                                    @php
                                                        $circleColor = match($log->status) {
                                                            'Menunggu Verifikasi' => 'bg-yellow-500 ring-8 ring-yellow-50',
                                                            'Disetujui' => 'bg-green-500 ring-8 ring-green-50',
                                                            'Ditolak' => 'bg-red-500 ring-8 ring-red-50',
                                                            'Terjadwal' => 'bg-purple-500 ring-8 ring-purple-50',
                                                            'Sedang Magang' => 'bg-cyan-500 ring-8 ring-cyan-50',
                                                            'Selesai' => 'bg-blue-500 ring-8 ring-blue-50',
                                                            'Dibatalkan' => 'bg-gray-500 ring-8 ring-gray-50',
                                                            default => 'bg-gray-500 ring-8 ring-gray-50'
                                                        };
                                                    @endphp
                                                    <span class="h-8 w-8 rounded-full flex items-center justify-center {{ $circleColor }}">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <!-- Content -->
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-xs font-bold text-gray-800">{{ $log->status }}</p>
                                                        @if($log->catatan)
                                                            <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">{{ $log->catatan }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-[10px] text-gray-400 whitespace-nowrap pt-0.5">
                                                        {{ $log->created_at->translatedFormat('d M H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Cancel Application Button (Conditional) -->
                    @php
                        $cancellable = in_array($pengajuan->status, ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal']);
                    @endphp
                    @if($cancellable)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                            <h4 class="font-bold text-sm text-gray-700 mb-2">Batalkan Pengajuan?</h4>
                            <p class="text-xs text-gray-400 leading-relaxed mb-4">Anda masih bisa membatalkan pengajuan ini sebelum status beralih ke "Sedang Magang".</p>
                            
                            <form method="POST" action="{{ route('pengguna.pengajuan.cancel', $pengajuan->public_id) }}" 
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan magang ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold py-2.5 rounded-xl border border-red-200 transition-colors">
                                    Batalkan Pengajuan
                                </button>
                            </form>
                        </div>
                    @endif                    <!-- Post-Approval SKM & Biodata Gate -->
                    @if($pengajuan->status === 'Disetujui')
                        @if(!$pengajuan->skmJawabans()->exists() || !$pengajuan->biodata()->exists())
                            <div class="bg-white rounded-2xl border border-amber-250 shadow-sm p-6 text-center mt-6">
                                <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3 text-amber-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <h4 class="font-bold text-sm text-gray-805 mb-2">Lengkapi Persyaratan Magang</h4>
                                <p class="text-xs text-gray-400 leading-relaxed mb-4">Pengajuan Anda telah disetujui. Lengkapi kuesioner dan biodata di bawah ini agar jadwal magang Anda resmi diaktifkan dan status berubah menjadi <strong>Terjadwal</strong>.</p>
                                
                                <div class="space-y-3">
                                    @if(!$pengajuan->skmJawabans()->exists())
                                        <a href="{{ route('pengguna.gate.skm', $pengajuan->id) }}" class="block w-full bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold py-2.5 rounded-xl transition shadow-sm">
                                            Isi Kuesioner SKM
                                        </a>
                                    @else
                                        <div class="block w-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold py-2.5 rounded-xl">
                                            Kuesioner SKM (Selesai ✓)
                                        </div>
                                    @endif

                                    @if(!$pengajuan->biodata()->exists())
                                        @if($pengajuan->skmJawabans()->exists())
                                            <a href="{{ route('pengguna.gate.biodata', $pengajuan->id) }}" class="block w-full bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold py-2.5 rounded-xl transition shadow-sm">
                                                Isi Formulir Biodata
                                            </a>
                                        @else
                                            <button type="button" class="w-full bg-gray-100 text-gray-400 border border-gray-200 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed flex items-center justify-center space-x-1.5" title="Selesaikan Kuesioner SKM terlebih dahulu" disabled>
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                <span>Isi Formulir Biodata (Terkunci)</span>
                                            </button>
                                        @endif
                                    @else
                                        <div class="block w-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold py-2.5 rounded-xl">
                                            Formulir Biodata (Selesai ✓)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.publik>
