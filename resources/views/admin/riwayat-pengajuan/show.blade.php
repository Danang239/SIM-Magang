<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.riwayat-pengajuan.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-emerald-700 transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar Riwayat & Pengajuan</span>
        </a>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-3 gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 font-sans">Detail & Verifikasi Pengajuan PKL</h2>
                <p class="text-xs text-gray-400 mt-1">Tinjau kelengkapan berkas pendaftar dan lakukan verifikasi persetujuan pendaftaran.</p>
            </div>
            @php
                $badgeColor = match($pengajuan->status) {
                    'Disetujui' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                    'Menunggu Verifikasi' => 'bg-amber-100 text-amber-800 border border-amber-300',
                    'Ditolak' => 'bg-red-100 text-red-800 border border-red-300',
                    'Terjadwal' => 'bg-purple-100 text-purple-800 border border-purple-300',
                    'Sedang Magang', 'Aktif' => 'bg-blue-100 text-blue-800 border border-blue-300',
                    'Selesai' => 'bg-emerald-600 text-white',
                    'Dibatalkan' => 'bg-gray-100 text-gray-600 border border-gray-300',
                    default => 'bg-gray-100 text-gray-700'
                };
            @endphp
            <div class="inline-flex items-center px-4 py-2 rounded-full text-xs font-extrabold tracking-wider uppercase {{ $badgeColor }} shadow-sm w-fit">
                Status: {{ $pengajuan->status }}
            </div>
        </div>
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
                            {{ $pengajuan->tempat_lahir ?? '-' }}, {{ $pengajuan->tanggal_lahir ? \Carbon\Carbon::parse($pengajuan->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Jenis Kelamin</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Asal Sekolah / Kampus</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->instansi ?? $pengajuan->user->instansi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Program Studi / Jurusan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->program_studi ?? $pengajuan->user->program_studi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Nomor WhatsApp / HP</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Kebutuhan Khusus / Disabilitas</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->status_disabilitas ?? 'Tidak Ada' }}</p>
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
                    Detail Penempatan PKL
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-4">
                    <div>
                        <p class="text-gray-400 font-medium">No. Pengajuan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm tracking-wider">{{ $pengajuan->nomor_pengajuan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Jenjang & Kategori</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->jenjang }} ({{ $pengajuan->bidang->kategori ?? '-' }})</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Bidang Penempatan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->bidang->nama_bidang ?? '-' }}</p>
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
                        <p class="font-bold text-emerald-700 mt-1 text-sm">{{ $pengajuan->pembimbing?->nama ?? 'Belum Ditentukan' }}</p>
                    </div>
                </div>

                <div class="text-xs">
                    <p class="text-gray-400 font-medium mb-1.5">Keahlian / Kompetensi Calon Peserta:</p>
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
                                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                                            </span>
                                        </div>
                                        <div class="flex-grow pt-1.5 flex justify-between space-x-4 text-xs">
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $log->status }}</p>
                                                <p class="text-gray-500 mt-0.5 leading-relaxed">{{ $log->catatan }}</p>
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

        <!-- Files & Action Verification Panel (Right) -->
        <div class="space-y-6">
            <!-- Form Aksi Verifikasi (Jika Menunggu Verifikasi) -->
            @if($pengajuan->status === 'Menunggu Verifikasi')
                <div class="bg-white rounded-2xl border-2 border-biogen-medium shadow-md p-6" x-data="{ action: 'setujui' }">
                    <div class="flex items-center space-x-2 text-biogen-dark border-b border-gray-100 pb-3 mb-4">
                        <svg class="w-5 h-5 text-biogen-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="font-bold text-sm">Verifikasi Pengajuan Ini</h3>
                    </div>

                    <form action="{{ route('admin.riwayat-pengajuan.verifikasi', $pengajuan->public_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Konfirmasi / Pilih Pembimbing -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Pembimbing Lapangan
                            </label>
                            <select name="pembimbing_id" class="w-full text-xs rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-biogen-medium outline-none bg-white">
                                <option value="">-- Tetapkan Pembimbing --</option>
                                @foreach($pembimbings as $p)
                                    <option value="{{ $p->id }}" {{ old('pembimbing_id', $pengajuan->pembimbing_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }} ({{ $p->jabatan ?? 'Pembimbing' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Keputusan -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Keputusan Verifikasi <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center justify-center p-2.5 rounded-xl border cursor-pointer font-bold text-xs transition"
                                    :class="action === 'setujui' ? 'border-emerald-600 bg-emerald-50 text-emerald-800' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                                    <input type="radio" name="action" value="setujui" x-model="action" class="sr-only">
                                    <span>Setujui (Terima)</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 rounded-xl border cursor-pointer font-bold text-xs transition"
                                    :class="action === 'tolak' ? 'border-red-600 bg-red-50 text-red-800' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                                    <input type="radio" name="action" value="tolak" x-model="action" class="sr-only">
                                    <span>Tolak</span>
                                </label>
                            </div>
                        </div>

                        <!-- Upload Surat Balasan (Hanya jika Setujui) -->
                        <div x-show="action === 'setujui'" class="space-y-2 pt-2">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                                Upload Surat Balasan Resmi (PDF) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file_surat_balasan" accept="application/pdf"
                                class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-biogen-medium hover:file:bg-emerald-100">
                            <p class="text-[10px] text-gray-400">Surat balasan akan dapat diunduh oleh peserta setelah mengisi form survei SKM.</p>
                        </div>

                        <!-- Catatan / Alasan Penolakan -->
                        <div x-show="action === 'tolak'" class="space-y-2 pt-2">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                                Alasan / Catatan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="catatan" rows="3" class="w-full text-xs rounded-xl border border-gray-200 p-3 focus:ring-2 focus:ring-biogen-medium outline-none"
                                placeholder="Jelaskan alasan penolakan berkas atau instruksi perbaikan untuk peserta..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs text-white shadow-sm transition"
                            :class="action === 'setujui' ? 'bg-biogen-medium hover:bg-biogen-dark' : 'bg-red-600 hover:bg-red-700'">
                            <span x-text="action === 'setujui' ? 'Konfirmasi Setujui Pengajuan' : 'Konfirmasi Tolak Pengajuan'"></span>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Documents Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans">Dokumen Lampiran</h3>
                
                <div class="space-y-3">
                    <!-- Surat Pengantar -->
                    <div class="p-3 bg-gray-50 border border-gray-150 rounded-xl flex items-center justify-between text-xs">
                        <div>
                            <p class="font-bold text-gray-800">Surat Pengantar Kampus</p>
                            <p class="text-[10px] text-gray-400">PDF / Dokumen Permohonan</p>
                        </div>
                        <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']) }}" target="_blank"
                            class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-lg border border-emerald-150 transition-colors">
                            Buka
                        </a>
                    </div>

                    <!-- Surat Balasan -->
                    @if($pengajuan->file_surat_balasan)
                        <div class="p-3 bg-emerald-50/60 border border-emerald-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-emerald-900">Surat Balasan Penerimaan</p>
                                <p class="text-[10px] text-emerald-600">PDF Resmi dari Admin</p>
                            </div>
                            <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_balasan']) }}" target="_blank"
                                class="bg-biogen-medium hover:bg-biogen-dark text-white font-bold px-3 py-1 rounded-lg transition-colors">
                                Unduh
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.internal>
