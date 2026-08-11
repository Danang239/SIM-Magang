<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('petugas.verifikasi.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Antrean</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Detail Peninjauan Berkas</h2>
        <p class="text-xs text-gray-400 mt-1">Periksa kelengkapan berkas pemohon sebelum memberikan keputusan persetujuan.</p>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <p class="font-bold">Gagal memproses tindakan:</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ openDecisionModal: false, decisionType: 'setujui' }">
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
                        <p class="text-gray-400 font-medium">Nomor HP / WhatsApp</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->no_hp ?? '-' }}</p>
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
                        <p class="text-gray-400 font-medium">Alamat Email</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Application Request Details -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Detail Pengajuan Magang
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-4">
                    <div>
                        <p class="text-gray-400 font-medium">No. Pengajuan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm tracking-wider">{{ $pengajuan->nomor_pengajuan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Jenjang Program</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->jenjang }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Bidang Penempatan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->bidang->nama_bidang }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Rencana Durasi</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->durasi_bulan }} Bulan</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Rencana Tanggal Mulai</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Rencana Tanggal Selesai</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai_rencana)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                <!-- Keahlian -->
                <div class="text-xs">
                    <p class="text-gray-400 font-medium mb-1.5">Keahlian / Kompetensi yang Dikuasai:</p>
                    <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 font-semibold">
                        {{ $pengajuan->keahlian }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Document Preview & Verification Form (Right) -->
        <div class="space-y-6">
            <!-- Surat Pengantar Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-3 font-sans flex items-center">
                        <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Surat Pengantar Instansi
                    </h3>
                    <p class="text-[11px] text-gray-400 leading-relaxed mb-4">Pastikan surat bertanda tangan resmi dari pimpinan instansi/sekolah asal serta berkas valid.</p>
                </div>
                
                <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']) }}" target="_blank"
                    class="w-full text-center bg-gray-50 border border-gray-255 hover:bg-emerald-50 text-biogen-medium text-xs font-bold py-3 rounded-xl transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Buka File Surat Pengantar</span>
                </a>
            </div>

            <!-- Decisions Action Box -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans">Verifikasi Keputusan</h3>
                
                <div class="space-y-3">
                    <!-- Approve Button -->
                    <button type="button" @click="decisionType = 'setujui'; openDecisionModal = true;"
                        class="w-full text-center bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold py-3 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        Setujui Pengajuan
                    </button>

                    <!-- Reject Button -->
                    <button type="button" @click="decisionType = 'tolak'; openDecisionModal = true;"
                        class="w-full text-center bg-red-50 hover:bg-red-100 text-red-650 text-xs font-bold py-3 rounded-xl border border-red-200 transition-colors">
                        Tolak Pengajuan
                    </button>
                </div>
            </div>
        </div>

        <!-- Decision Modal (Alpine.js overlay) -->
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="openDecisionModal" x-cloak x-transition>
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 transition-opacity" @click="openDecisionModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <!-- Icon Alert -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                            :class="decisionType === 'setujui' ? 'bg-emerald-100 text-biogen-medium' : 'bg-red-100 text-red-600'">
                            <template x-if="decisionType === 'setujui'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="decisionType === 'tolak'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </template>
                        </div>
                        <h4 class="text-base font-bold text-gray-800 font-sans"
                            x-text="decisionType === 'setujui' ? 'Konfirmasi Setujui Pengajuan' : 'Konfirmasi Tolak Pengajuan'">
                        </h4>
                    </div>

                    <p class="text-xs text-gray-400 leading-relaxed mb-5"
                        x-text="decisionType === 'setujui'
                            ? 'Dengan menyetujui, sistem akan mengirim email konfirmasi resmi dan menetapkan kuota penempatan.'
                            : 'Mengembalikan berkas magang ini. Masukkan alasan penolakan yang rinci agar dapat diperbaiki oleh pendaftar.'">
                    </p>

                    <form method="POST" action="{{ route('petugas.verifikasi.process', $pengajuan->public_id) }}">
                        @csrf
                        <input type="hidden" name="action" :value="decisionType">

                        <!-- Notes Area -->
                        <div class="mb-6">
                            <label for="catatan" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                Catatan / Keterangan Verifikator <span x-show="decisionType === 'tolak'" class="text-red-500">*</span>
                            </label>
                            <textarea id="catatan" name="catatan" rows="4"
                                class="w-full rounded-xl border border-gray-200 text-xs text-gray-800 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition"
                                :placeholder="decisionType === 'setujui' ? 'Keterangan tambahan jika ada (opsional)...' : 'Contoh: Berkas surat pengantar buram, silakan upload ulang berkas dengan format PDF yang jelas.'"
                                :required="decisionType === 'tolak'">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Buttons actions -->
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" @click="openDecisionModal = false"
                                class="px-4 py-2 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                :class="decisionType === 'setujui' ? 'bg-biogen-medium hover:bg-biogen-light' : 'bg-red-655 hover:bg-red-700 bg-red-600'"
                                class="px-5 py-2 text-white rounded-xl text-xs font-bold shadow transition-colors">
                                Kirim Keputusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.internal>
