<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('petugas.review-laporan.index') }}" class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-biogen-medium transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Antrean Ulasan</span>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 font-sans mt-3">Tinjau Laporan Akhir</h2>
        <p class="text-xs text-gray-400 mt-1">Periksa berkas laporan akhir yang dikirimkan oleh pemohon sebelum menerbitkan Surat Keterangan Selesai.</p>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <p class="font-bold">Gagal memproses keputusan:</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ openReviewModal: false, reviewAction: 'terima' }">
        <!-- Details Card (Left 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Diri Pemohon -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Data Diri Peserta Magang
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-gray-400 font-medium">Nama Lengkap</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Asal Sekolah / Kampus</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->instansi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Program Studi / Jurusan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->user->program_studi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">No. Pengajuan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm tracking-wider">{{ $pengajuan->nomor_pengajuan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Bidang Penempatan</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->bidang->nama_bidang }} ({{ $pengajuan->jenjang }})</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Tanggal Mulai - Selesai</p>
                        <p class="font-bold text-gray-800 mt-1 text-sm">
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d M Y') }} s/d
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai_rencana)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulir Biodata Gate -->
            @if($pengajuan->biodata)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Formulir Biodata Peserta
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <p class="text-gray-400 font-medium">NIM / NISN</p>
                            <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->biodata->nim_nisn }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Tempat, Tanggal Lahir</p>
                            <p class="font-bold text-gray-800 mt-1 text-sm">
                                {{ $pengajuan->biodata->tempat_lahir }}, {{ $pengajuan->biodata->tanggal_lahir->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Jenis Kelamin</p>
                            <p class="font-bold text-gray-800 mt-1 text-sm">{{ $pengajuan->biodata->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-medium">Kontak Darurat</p>
                            <p class="font-bold text-gray-800 mt-1 text-sm">
                                {{ $pengajuan->biodata->kontak_darurat_nama }} ({{ $pengajuan->biodata->hubungan_kontak_darurat }}) - {{ $pengajuan->biodata->kontak_darurat_no }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-400 font-medium">Alamat Domisili</p>
                            <p class="font-bold text-gray-800 mt-1 text-sm leading-relaxed">{{ $pengajuan->biodata->alamat }}</p>
                        </div>
                    </div>
                </div>
            <!-- Hasil Kuesioner SKM -->
            @if($pengajuan->skmJawabans()->exists())
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mt-6">
                    <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.371 1.24.588 1.81l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.17 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.883c-.783-.57-.37-1.81.588-1.81h4.906a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        Hasil Kuesioner SKM (Kepuasan Masyarakat)
                    </h3>
                    <div class="space-y-4">
                        @foreach($pengajuan->skmJawabans()->with('pertanyaan')->get() as $jawaban)
                            <div class="flex items-start justify-between text-xs pb-3 border-b border-gray-50 last:border-b-0">
                                <div class="max-w-md">
                                    <p class="font-semibold text-gray-700">{{ $jawaban->pertanyaan->teks_pertanyaan }}</p>
                                </div>
                                <div class="flex items-center space-x-1 shrink-0 bg-emerald-50 text-biogen-medium font-bold px-2.5 py-1 rounded-lg border border-emerald-150">
                                    <span>Skor: {{ $jawaban->rating }}</span>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($pengajuan->skm_saran)
                            <div class="mt-4 p-4 rounded-xl bg-gray-50 border border-gray-100 text-xs">
                                <p class="font-bold text-gray-700">Saran / Masukan Tambahan:</p>
                                <p class="text-gray-600 mt-1 italic">"{{ $pengajuan->skm_saran }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Box (Right 1 Column) -->
        <div class="space-y-6">
            <!-- Berkas Laporan Box -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-3 font-sans flex items-center">
                        <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Berkas Laporan Akhir
                    </h3>
                    <p class="text-[11px] text-gray-400 leading-relaxed mb-4">Pastikan isi dokumen laporan akhir magang telah disetujui secara lisan oleh pembimbing divisi sebelum diterima resmi.</p>
                </div>
                
                <a href="{{ route('pengajuan.file', [$pengajuan->public_id, 'laporan_akhir']) }}" target="_blank"
                    class="w-full text-center bg-gray-50 border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 text-biogen-medium text-xs font-bold py-3 rounded-xl transition-all flex items-center justify-center space-x-2">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Buka Berkas Laporan (PDF)</span>
                </a>
            </div>

            <!-- Decisions Action Box -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-4 font-sans">Ulas Laporan</h3>
                
                <div class="space-y-3">
                    <!-- Approve Button -->
                    <button type="button" @click="reviewAction = 'terima'; openReviewModal = true;"
                        class="w-full text-center bg-biogen-medium hover:bg-biogen-light text-white text-xs font-bold py-3 rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        Terima & Terbitkan Sertifikat
                    </button>

                    <!-- Reject Button -->
                    <button type="button" @click="reviewAction = 'tolak'; openReviewModal = true;"
                        class="w-full text-center bg-red-50 hover:bg-red-100 text-red-650 text-xs font-bold py-3 rounded-xl border border-red-200 transition-colors">
                        Tolak & Minta Revisi
                    </button>
                </div>
            </div>
        </div>

        <!-- Decision Modal (Alpine.js overlay) -->
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="openReviewModal" x-cloak x-transition>
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 transition-opacity" @click="openReviewModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <!-- Icon Alert -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                            :class="reviewAction === 'terima' ? 'bg-emerald-100 text-biogen-medium' : 'bg-red-100 text-red-600'">
                            <template x-if="reviewAction === 'terima'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="reviewAction === 'tolak'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </template>
                        </div>
                        <h4 class="text-base font-bold text-gray-800 font-sans"
                            x-text="reviewAction === 'terima' ? 'Konfirmasi Terima Laporan' : 'Konfirmasi Tolak Laporan'">
                        </h4>
                    </div>

                    <form method="POST" action="{{ route('petugas.review-laporan.process', $pengajuan->public_id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="action" :value="reviewAction">

                        <!-- Case 1: Acceptance requires uploading a certificate -->
                        <div class="mb-5" x-show="reviewAction === 'terima'">
                            <p class="text-xs text-gray-400 leading-relaxed mb-4">
                                Laporan akhir dinyatakan sah. Untuk menyelesaikan program magang secara formal, unggah berkas **Surat Keterangan Selesai Magang / Sertifikat** resmi (format PDF, maks 2MB).
                            </p>
                            <label for="file_surat_keterangan" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                Berkas Surat Keterangan / Sertifikat <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_surat_keterangan" name="file_surat_keterangan" accept="application/pdf"
                                class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 bg-gray-50 focus:ring-biogen-medium focus:border-biogen-medium focus:ring-2 outline-none"
                                :required="reviewAction === 'terima'">
                        </div>

                        <!-- Case 2: Rejection requires entering revision comments -->
                        <div class="mb-5" x-show="reviewAction === 'tolak'">
                            <p class="text-xs text-gray-400 leading-relaxed mb-4">
                                Berkas laporan akan dikembalikan ke peserta. Masukkan rincian catatan revisi agar dapat disesuaikan kembali.
                            </p>
                            <label for="catatan" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                Catatan Revisi / Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="catatan" name="catatan" rows="4"
                                class="w-full rounded-xl border border-gray-200 text-xs text-gray-800 px-4 py-3 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none resize-none transition"
                                placeholder="Contoh: Format lampiran laporan salah, mohon tambahkan tanda tangan pembimbing lapangan divisi."
                                :required="reviewAction === 'tolak'">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Buttons actions -->
                        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-150">
                            <button type="button" @click="openReviewModal = false"
                                class="px-4 py-2 border border-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                :class="reviewAction === 'terima' ? 'bg-biogen-medium hover:bg-biogen-light' : 'bg-red-650 hover:bg-red-700 bg-red-600'"
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
