<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.riwayat-pengajuan.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-emerald-700 transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar Riwayat</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Detail Riwayat Pengajuan Magang</h2>
        <p class="text-xs text-gray-400 mt-1">Tampilan arsip pengajuan magang secara lengkap (Read-Only).</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile & Submission Details (Left) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Applicant Details Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Data Diri Pemohon
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-gray-400 font-medium">Nama Lengkap</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">NIM / NISN</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->nim_nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">
                            {{ $pengajuan->tempat_lahir ?? '-' }}, {{ $pengajuan->tanggal_lahir ? $pengajuan->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Jenis Kelamin</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Asal Sekolah / Kampus</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->instansi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Program Studi / Jurusan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->program_studi ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-400 font-medium">Alamat Lengkap</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm leading-relaxed">{{ $pengajuan->alamat ?? '-' }}</p>
                    </div>
                </div>

                <h4 class="font-bold text-gray-800 text-xs mb-3 mt-6 uppercase tracking-wider text-gray-400">Kontak Darurat</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <div>
                        <p class="text-gray-400 font-medium">Nama Kontak</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $pengajuan->kontak_darurat_nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">No. Telepon / WA</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $pengajuan->kontak_darurat_no ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Hubungan</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $pengajuan->hubungan_kontak_darurat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Internship Request Details -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Detail Penempatan Magang
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-4">
                    <div>
                        <p class="text-gray-400 font-medium">No. Pengajuan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm tracking-wider">{{ $pengajuan->nomor_pengajuan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Jenjang & Kategori</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->jenjang }} ({{ $pengajuan->bidang->kategori }})</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Bidang Penempatan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->bidang->nama_bidang }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Durasi Magang</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->durasi_bulan }} Bulan</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Tanggal Pelaksanaan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">
                            {{ $pengajuan->tanggal_mulai ? $pengajuan->tanggal_mulai->translatedFormat('d M Y') : '-' }} 
                            s/d 
                            {{ $pengajuan->tanggal_selesai_rencana ? $pengajuan->tanggal_selesai_rencana->translatedFormat('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Pembimbing Lapangan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->bidang->pembimbing?->name ?? 'Belum Ditentukan' }}</p>
                    </div>
                </div>

                <div class="text-xs">
                    <p class="text-gray-400 font-medium mb-1.5">Keahlian / Kompetensi:</p>
                    <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 font-semibold">
                        {{ $pengajuan->keahlian }}
                    </p>
                </div>
            </div>

            <!-- Timeline Status Logs -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-6 font-sans border-b border-gray-100 pb-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat Timeline Status
                </h3>
                
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($statusLogs as $idx => $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-emerald-50 border-2 border-emerald-500 flex items-center justify-center ring-8 ring-white">
                                                <!-- Small dot -->
                                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                                            </span>
                                        </div>
                                        <div class="flex-grow pt-1.5 flex justify-between space-x-4 text-xs">
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $log->status }}</p>
                                                <p class="text-gray-400 mt-0.5 leading-relaxed">{{ $log->catatan }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1 font-semibold">Diproses oleh: {{ $log->user?->name ?? 'System' }}</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-gray-400 text-[10px] font-semibold">
                                                <time>{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Files & Status Card (Right) -->
        <div class="space-y-6">
            <!-- Current Status Box -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status Saat Ini</p>
                @php
                    $badgeColor = match($pengajuan->status) {
                        'Disetujui' => 'bg-green-500 text-white',
                        'Menunggu Verifikasi' => 'bg-yellow-500 text-white',
                        'Ditolak' => 'bg-red-500 text-white',
                        'Terjadwal' => 'bg-purple-500 text-white',
                        'Sedang Magang' => 'bg-cyan-500 text-white',
                        'Selesai' => 'bg-blue-500 text-white',
                        'Dibatalkan' => 'bg-gray-500 text-white',
                        default => 'bg-gray-550 text-white'
                    };
                @endphp
                <div class="inline-block px-4 py-2 rounded-full text-sm font-extrabold tracking-widest uppercase {{ $badgeColor }} shadow-sm">
                    {{ $pengajuan->status }}
                </div>
            </div>

            <!-- Documents Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans">Dokumen Lampiran</h3>
                
                <div class="space-y-3">
                    <!-- Surat Pengantar -->
                    <div class="p-3 bg-gray-50 border border-gray-150 rounded-xl flex items-center justify-between text-xs">
                        <div>
                            <p class="font-bold text-gray-800">Surat Pengantar</p>
                            <p class="text-[10px] text-gray-400">PDF / Gambar Instansi</p>
                        </div>
                        <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']) }}" target="_blank"
                            class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-lg border border-emerald-150 transition-colors">
                            Buka
                        </a>
                    </div>

                    <!-- Surat Balasan -->
                    @if($pengajuan->file_surat_balasan)
                        <div class="p-3 bg-gray-50 border border-gray-150 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-gray-800">Surat Balasan</p>
                                <p class="text-[10px] text-gray-400">PDF Resmi Penerimaan</p>
                            </div>
                            <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_balasan']) }}" target="_blank"
                                class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-lg border border-emerald-150 transition-colors">
                                Buka
                            </a>
                        </div>
                    @endif

                    <!-- Laporan Akhir -->
                    @if($pengajuan->file_laporan_akhir)
                        <div class="p-3 bg-gray-50 border border-gray-150 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-gray-800">Laporan Akhir</p>
                                <p class="text-[10px] text-gray-400">PDF Laporan Kerja</p>
                            </div>
                            <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'laporan_akhir']) }}" target="_blank"
                                class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-lg border border-emerald-150 transition-colors">
                                Buka
                            </a>
                        </div>
                    @endif

                    <!-- Surat Keterangan Selesai -->
                    @if($pengajuan->file_surat_keterangan)
                        <div class="p-3 bg-emerald-50 border border-emerald-150 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-emerald-950">Surat Keterangan Selesai</p>
                                <p class="text-[10px] text-emerald-600">Dokumen Sertifikat Kelulusan</p>
                            </div>
                            <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_keterangan']) }}" target="_blank"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1 rounded-lg transition-colors">
                                Buka
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.internal>
