<x-layouts.publik>
    <div class="min-h-screen bg-biogen-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto mt-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 font-sans tracking-tight">Formulir Data Peserta Magang/PKL (Form-1 PT)</h1>
                <p class="text-gray-500 text-sm mt-1">BRMP Biogen — Kementerian Pertanian RI</p>
            </div>

            <!-- Step Indicator -->
            <x-career-steps :current="2" />

            <!-- Ringkasan Pilihan -->
            <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-5 mb-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Ringkasan Pengajuan Bidang</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Bidang Penelitian</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $bidang->nama_bidang }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Jalur / Jenjang</p>
                        <p class="font-bold text-gray-800 mt-0.5">Jalur {{ $bidang->jenjang }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Mulai Magang</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ \Carbon\Carbon::parse($step1['tanggal_mulai'])->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Rencana Selesai</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ \Carbon\Carbon::parse($step1['tanggal_selesai_rencana'])->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Error messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <p class="font-bold mb-2">Mohon lengkapi bagian berikut:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('pengguna.career.store') }}" enctype="multipart/form-data" class="space-y-6" id="form-pengajuan">
                @csrf

                <!-- Panel 1: Unggah Foto Diri 4x6 & A. Data Pribadi -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-6">
                    <h2 class="text-base font-bold text-gray-800 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">A</span>
                        Data Pribadi Peserta
                    </h2>

                    <!-- Upload Foto Berwarna 4x6 -->
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6" x-data="{ photoPreview: null }">
                        <div class="w-28 h-40 shrink-0 overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-200 flex flex-col items-center justify-center text-center relative shadow-sm" style="width: 112px; height: 160px; max-width: 112px; max-height: 160px;">
                            <template x-if="!photoPreview">
                                <div class="p-2">
                                    <svg class="w-7 h-7 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Pas Foto<br>4 x 6</span>
                                </div>
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" alt="Pratinjau Pas Foto 4x6" class="w-full h-full object-cover object-center rounded-xl" style="width: 112px; height: 160px; max-width: 112px; max-height: 160px; object-fit: cover;">
                            </template>
                        </div>
                        <div class="space-y-2 flex-1">
                            <label for="foto_diri" class="block text-xs font-bold text-gray-700">Unggah Pas Foto Berwarna (4x6) <span class="text-red-500">*</span></label>
                            <p class="text-[11px] text-gray-500 leading-relaxed">Wajib mengunggah foto pas diri berwarna latar belakang merah/biru/polos untuk keperluan identitas berkas magang. Foto posisi landscape/potret akan otomatis terpotong simetris 4x6.</p>
                            <input type="file" name="foto_diri" id="foto_diri" accept=".jpg,.jpeg,.png" required
                                class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer"
                                @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            const img = new Image();
                                            img.onload = () => {
                                                const canvas = document.createElement('canvas');
                                                const targetW = 400;
                                                const targetH = 600;
                                                canvas.width = targetW;
                                                canvas.height = targetH;
                                                const ctx = canvas.getContext('2d');
                                                
                                                const targetAspect = 4 / 6;
                                                const origW = img.width;
                                                const origH = img.height;
                                                const origAspect = origW / origH;
                                                
                                                let cropW, cropH, cropX, cropY;
                                                if (origAspect > targetAspect) {
                                                    cropH = origH;
                                                    cropW = origH * targetAspect;
                                                    cropX = (origW - cropW) / 2;
                                                    cropY = 0;
                                                } else {
                                                    cropW = origW;
                                                    cropH = origW / targetAspect;
                                                    cropX = 0;
                                                    cropY = (origH - cropH) / 2;
                                                }
                                                
                                                ctx.drawImage(img, cropX, cropY, cropW, cropH, 0, 0, targetW, targetH);
                                                photoPreview = canvas.toDataURL('image/jpeg', 0.9);
                                            };
                                            img.src = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                ">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_lengkap_display" class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Pemohon</label>
                            <input type="text" id="nama_lengkap_display" value="{{ auth()->user()->name }}" readonly disabled
                                class="w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 text-xs font-bold">
                        </div>

                        <div>
                            <label for="nik_ktp" class="block text-xs font-bold text-gray-700 mb-1">No. KTP / NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_ktp" id="nik_ktp" value="{{ old('nik_ktp') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="16 digit Nomor Induk Kependudukan">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="nim_nisn" class="block text-xs font-bold text-gray-700 mb-1">No. Induk Mahasiswa / Siswa (NIM/NISN) <span class="text-red-500">*</span></label>
                            <input type="text" name="nim_nisn" id="nim_nisn" value="{{ old('nim_nisn') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Nomor Induk dari Kampus/Sekolah">
                        </div>

                        <div>
                            <label for="no_hp" class="block text-xs font-bold text-gray-700 mb-1">No. Telepon / HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: 081234567890">
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Kota tempat lahir">
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs">
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap KTP / Domisili <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="2" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                            placeholder="Alamat domisili lengkap dengan RT/RW, Kelurahan, Kecamatan, Kota & Kode Pos">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <!-- Panel 2: B. Asal Perguruan Tinggi / Sekolah -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-4">
                    <h2 class="text-base font-bold text-gray-800 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">B</span>
                        Asal Perguruan Tinggi / Sekolah
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="instansi" class="block text-xs font-bold text-gray-700 mb-1">Nama Perguruan Tinggi / Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="instansi" id="instansi" value="{{ old('instansi', auth()->user()->instansi) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: Universitas Pakuan / SMK Negeri 1 Bogor">
                        </div>

                        <div>
                            <label for="nama_pimpinan_instansi" class="block text-xs font-bold text-gray-700 mb-1">Nama Rektor / Kepala Sekolah / Pimpinan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pimpinan_instansi" id="nama_pimpinan_instansi" value="{{ old('nama_pimpinan_instansi') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Nama Rektor / Dekan / Kepala Sekolah beserta gelar">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="alamat_instansi" class="block text-xs font-bold text-gray-700 mb-1">Alamat Perguruan Tinggi / Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="alamat_instansi" id="alamat_instansi" value="{{ old('alamat_instansi') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Alamat jalan instansi/kampus">
                        </div>

                        <div>
                            <label for="kontak_instansi" class="block text-xs font-bold text-gray-700 mb-1">No. Telepon / Faks / Email Instansi <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_instansi" id="kontak_instansi" value="{{ old('kontak_instansi') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Nomor telepon atau email resmi fakultas/sekolah">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="fakultas" class="block text-xs font-bold text-gray-700 mb-1">Fakultas (Opsional untuk PT)</label>
                            <input type="text" name="fakultas" id="fakultas" value="{{ old('fakultas') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Misal: Fakultas Matematika & IPA">
                        </div>

                        <div>
                            <label for="program_studi" class="block text-xs font-bold text-gray-700 mb-1">Jurusan / Program Studi <span class="text-red-500">*</span></label>
                            <input type="text" name="program_studi" id="program_studi" value="{{ old('program_studi', auth()->user()->program_studi) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Misal: Ilmu Komputer / Bioteknologi / Agribisnis">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="tahun_masuk" class="block text-xs font-bold text-gray-700 mb-1">Tahun Masuk <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: 2023">
                        </div>

                        <div>
                            <label for="pendidikan_terakhir" class="block text-xs font-bold text-gray-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: SMA / SMK / D3 / S1">
                        </div>

                        <div>
                            <label for="semester_saat_ini" class="block text-xs font-bold text-gray-700 mb-1">Semester Saat Ini / Tahun <span class="text-red-500">*</span></label>
                            <input type="text" name="semester_saat_ini" id="semester_saat_ini" value="{{ old('semester_saat_ini') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: Semester 5 / Kelas XI">
                        </div>
                    </div>
                </div>

                <!-- Panel 3: C. Materi Magang/PKL -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-4">
                    <h2 class="text-base font-bold text-gray-800 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">C</span>
                        Materi Magang / PKL
                    </h2>

                    <div>
                        <label for="judul_magang" class="block text-xs font-bold text-gray-700 mb-1">Judul Magang / PKL <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_magang" id="judul_magang" value="{{ old('judul_magang') }}" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                            placeholder="Judul topik penelitian/praktikum magang yang diajukan">
                    </div>

                    <div>
                        <label for="tujuan_magang" class="block text-xs font-bold text-gray-700 mb-1">Tujuan Magang / PKL <span class="text-red-500">*</span></label>
                        <textarea name="tujuan_magang" id="tujuan_magang" rows="3" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                            placeholder="Jelaskan tujuan dan capaian yang ingin diperoleh selama magang di BRMP Biogen...">{{ old('tujuan_magang') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_dosen_pembimbing" class="block text-xs font-bold text-gray-700 mb-1">Nama Dosen / Guru Pembimbing dari Kampus/Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_dosen_pembimbing" id="nama_dosen_pembimbing" value="{{ old('nama_dosen_pembimbing') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Nama Dosen Pembimbing Lapangan beserta gelar">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pembimbing dari BRMP Biogen</label>
                            <input type="text" value="{{ $bidang->pembimbing ? $bidang->pembimbing->name : 'Ditetapkan oleh BRMP Biogen' }}" readonly disabled
                                class="w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 text-xs font-semibold">
                        </div>
                    </div>
                </div>

                <!-- Panel 4: Kontak Darurat -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-4">
                    <h2 class="text-base font-bold text-gray-800 font-sans border-b border-gray-100 pb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">D</span>
                        Kontak Darurat (Emergency Contact)
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="kontak_darurat_nama" class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Kontak <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama" value="{{ old('kontak_darurat_nama') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Nama wali/kerabat">
                        </div>

                        <div>
                            <label for="kontak_darurat_no" class="block text-xs font-bold text-gray-700 mb-1">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_darurat_no" id="kontak_darurat_no" value="{{ old('kontak_darurat_no') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Contoh: 08123456789">
                        </div>

                        <div>
                            <label for="hubungan_kontak_darurat" class="block text-xs font-bold text-gray-700 mb-1">Hubungan Kontak <span class="text-red-500">*</span></label>
                            <input type="text" name="hubungan_kontak_darurat" id="hubungan_kontak_darurat" value="{{ old('hubungan_kontak_darurat') }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-xs"
                                placeholder="Misal: Ayah / Ibu / Kakak">
                        </div>
                    </div>
                </div>

                <!-- Panel 5: File Surat Pengantar -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6">
                    <h2 class="text-base font-bold text-gray-800 font-sans mb-1 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">E</span>
                        Unggah Surat Pengantar Resmi
                    </h2>
                    <p class="text-xs text-gray-500 mb-4">Wajib mengunggah surat pengantar resmi dari sekolah atau universitas Anda. Format: PDF, JPG, PNG (Maks. 2MB).</p>

                    <div class="border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-300 relative cursor-pointer"
                        :class="isDragging ? 'border-emerald-500 bg-emerald-50/80 scale-[1.01] shadow-lg ring-4 ring-emerald-500/10' : (fileName ? 'border-emerald-400 bg-emerald-50/30' : 'border-gray-200 bg-gray-50/50 hover:border-emerald-400 hover:bg-gray-50')"
                        x-data="{ fileName: '', isDragging: false }"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="
                            isDragging = false;
                            const f = $event.dataTransfer.files[0];
                            if(f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                        ">
                        
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100/80 text-emerald-600 mx-auto mb-3 flex items-center justify-center transition-transform duration-300"
                             :class="isDragging ? 'scale-110 rotate-6 bg-emerald-600 text-white' : ''">
                            <svg class="w-7 h-7" :class="isDragging ? 'animate-bounce' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>

                        <template x-if="!fileName">
                            <div class="space-y-1.5">
                                <p class="text-xs font-bold text-gray-700" x-text="isDragging ? 'Lepaskan file di sini...' : 'Seret & lepas file Surat Pengantar di sini'"></p>
                                <p class="text-[11px] text-gray-400">atau klik tombol di bawah untuk jelajahi berkas</p>
                                <div class="pt-2">
                                    <label for="file_surat_pengantar" class="cursor-pointer bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all duration-200 inline-block">
                                        Pilih Berkas PDF / Gambar
                                    </label>
                                </div>
                            </div>
                        </template>

                        <template x-if="fileName">
                            <div class="p-3 bg-white rounded-xl border border-emerald-200 shadow-sm max-w-md mx-auto flex items-center justify-between space-x-3">
                                <div class="flex items-center space-x-3 truncate">
                                    <div class="p-2 bg-emerald-100 text-emerald-700 rounded-lg shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="text-left truncate">
                                        <p class="text-xs font-bold text-gray-900 truncate" x-text="fileName"></p>
                                        <span class="text-[10px] text-emerald-600 font-semibold">File Siap Diunggah</span>
                                    </div>
                                </div>
                                <button type="button" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0" title="Ganti File" @click="fileName = ''; $refs.fileInput.value = ''">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>

                        <input type="file"
                            id="file_surat_pengantar"
                            name="file_surat_pengantar"
                            accept=".pdf,.jpg,.jpeg,.png"
                            required
                            class="hidden"
                            x-ref="fileInput"
                            @change="fileName = $event.target.files[0]?.name || ''">
                        <p class="text-[9px] text-gray-400 mt-3">Format: PDF, JPG, PNG • Ukuran file maksimal 2MB</p>
                    </div>
                </div>

                <!-- Panel 6: Tanda Tangan Digital Pad (HTML5 Canvas) -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 space-y-4" x-data="signaturePad()">
                    <h2 class="text-base font-bold text-gray-800 font-sans border-b border-gray-100 pb-3 flex items-center justify-between">
                        <span class="flex items-center">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs flex items-center justify-center font-bold mr-2">F</span>
                            Tanda Tangan Digital Pemohon <span class="text-red-500 ml-1">*</span>
                        </span>
                        <button type="button" @click="clearSignature()" class="text-xs text-red-600 hover:text-red-700 font-bold border border-red-200 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                            Hapus Tanda Tangan
                        </button>
                    </h2>
                    <p class="text-xs text-gray-500">Gunakan layar sentuh HP atau kursor mouse laptop Anda untuk menggambar tanda tangan digital di bawah ini.</p>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/50 p-2 relative flex justify-center items-center">
                        <canvas id="signature-canvas" width="600" height="200" class="w-full h-48 bg-white rounded-lg border border-gray-200 cursor-crosshair touch-none shadow-inner"></canvas>
                        <span x-show="isEmpty" class="absolute pointer-events-none text-xs text-gray-400 font-semibold italic">Gambar tanda tangan Anda di sini...</span>
                    </div>

                    <input type="hidden" name="tanda_tangan_digital" id="tanda_tangan_digital" x-model="signatureData" required>
                    <p class="text-[10px] text-gray-400">Dokumen ini akan ditandatangani secara elektronik sebagai bukti sah pengajuan berkas di BRMP Biogen.</p>
                </div>

                <!-- Panel 7: Syarat & Ketentuan Checkbox -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 flex items-start space-x-3" x-data="{}">
                    <input type="checkbox" name="syarat_ketentuan" id="syarat_ketentuan" value="1" required
                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 mt-1">
                    <label for="syarat_ketentuan" class="text-xs text-gray-600 leading-relaxed">
                        Saya telah membaca, memahami, dan menyetujui seluruh isi
                        <button type="button" @click.prevent="$dispatch('open-modal', 'modal-syarat-ketentuan')" class="text-emerald-600 hover:underline font-bold focus:outline-none">
                            Surat Pernyataan &amp; Ketentuan Magang BRMP Biogen
                        </button>
                        serta menyatakan data di atas adalah benar.
                    </label>
                </div>

                <!-- Navigation & Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('pengguna.career.step1', ['resume' => 1]) }}" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-emerald-700 transition-colors font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Kembali</span>
                    </a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-sm hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Pengajuan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Surat Pernyataan Resmi (7 Poin Resmi) -->
    <x-modal name="modal-syarat-ketentuan" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 font-sans flex items-center">
                <svg class="w-6 h-6 me-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Surat Pernyataan Peserta Magang/PKL
            </h2>
            <div class="text-xs text-gray-700 space-y-3 max-h-[28rem] overflow-y-auto leading-relaxed pr-2">
                <p class="font-bold text-gray-900 text-sm mb-3">Dengan ini menyatakan bahwa saya:</p>

                <div class="space-y-3">
                    <!-- Item 1 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            1
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Akan mengikuti semua peraturan yang berlaku di BRMP Biogen dan semua ketentuan lain yang ditetapkan oleh pimpinan BRMP Biogen.
                        </p>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            2
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Tidak akan mempublikasikan data/informasi hasil Magang/PKL dalam bentuk apapun kecuali seizin BRMP Biogen.
                        </p>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            3
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Akan menyelesaikan semua kewajiban dan mengembalikan semua pinjaman yang dilakukan sebelum meminta surat keterangan selesai Magang/PKL.
                        </p>
                    </div>

                    <!-- Item 4 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            4
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Akan menyerahkan laporan Magang/PKL kepada pembimbing dan bagian administrasi Kelompok Layanan Standar Instrumen BRMP Biogen sebanyak 1 (satu) rangkap sebagai persyaratan memperoleh surat keterangan selesai Magang/PKL.
                        </p>
                    </div>

                    <!-- Item 5 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            5
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Tidak akan menuntut BRMP Biogen apabila terjadi sesuatu kecelakaan selama pelaksanaan Magang/PKL di BRMP Biogen yang mengakibatkan berbagai hal akibat dari kecelakaan tersebut.
                        </p>
                    </div>

                    <!-- Item 6 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            6
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Akan menyerahkan sepenuhnya mengenai kepemilikan dan Hak Kekayaan Intelektual (HKI) kepada BRMP Biogen bilamana selama Magang/PKL dihasilkan sesuatu yang berkaitan dengan HKI.
                        </p>
                    </div>

                    <!-- Item 7 -->
                    <div class="flex items-start p-3.5 bg-gray-50 rounded-xl border border-gray-150 shadow-sm hover:border-emerald-200 transition-colors">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mr-3 mt-0.5 shadow-sm">
                            7
                        </div>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            Jika terjadi kerusakan alat menjadi tanggung jawab mahasiswa/siswa.
                        </p>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-xl text-xs text-emerald-900 leading-relaxed italic shadow-sm">
                    "Demikian pernyataan ini saya buat dengan sadar tanpa paksaan. Apabila di kemudian hari diketahui bahwa saya menyalahi/bertindak melanggar isi pernyataan ini, saya bersedia dituntut berdasarkan aturan yang berlaku."
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-6 py-2.5 rounded-xl font-bold transition-all duration-200 shadow">
                    Saya Mengerti &amp; Setuju
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Script Signature Pad Canvas -->
    <script>
        function signaturePad() {
            return {
                isDrawing: false,
                isEmpty: true,
                signatureData: '',
                canvas: null,
                ctx: null,

                init() {
                    this.canvas = document.getElementById('signature-canvas');
                    this.ctx = this.canvas.getContext('2d');
                    this.ctx.lineWidth = 2.5;
                    this.ctx.lineCap = 'round';
                    this.ctx.strokeStyle = '#000000';

                    // Mouse events
                    this.canvas.addEventListener('mousedown', (e) => this.startDrawing(e));
                    this.canvas.addEventListener('mousemove', (e) => this.draw(e));
                    this.canvas.addEventListener('mouseup', () => this.stopDrawing());
                    this.canvas.addEventListener('mouseleave', () => this.stopDrawing());

                    // Touch events
                    this.canvas.addEventListener('touchstart', (e) => {
                        e.preventDefault();
                        const touch = e.touches[0];
                        const rect = this.canvas.getBoundingClientRect();
                        this.startDrawing({ clientX: touch.clientX, clientY: touch.clientY });
                    });
                    this.canvas.addEventListener('touchmove', (e) => {
                        e.preventDefault();
                        const touch = e.touches[0];
                        this.draw({ clientX: touch.clientX, clientY: touch.clientY });
                    });
                    this.canvas.addEventListener('touchend', () => this.stopDrawing());
                },

                getPos(e) {
                    const rect = this.canvas.getBoundingClientRect();
                    const scaleX = this.canvas.width / rect.width;
                    const scaleY = this.canvas.height / rect.height;
                    return {
                        x: (e.clientX - rect.left) * scaleX,
                        y: (e.clientY - rect.top) * scaleY
                    };
                },

                startDrawing(e) {
                    this.isDrawing = true;
                    this.isEmpty = false;
                    const pos = this.getPos(e);
                    this.ctx.beginPath();
                    this.ctx.moveTo(pos.x, pos.y);
                },

                draw(e) {
                    if (!this.isDrawing) return;
                    const pos = this.getPos(e);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.stroke();
                    this.saveSignature();
                },

                stopDrawing() {
                    if (this.isDrawing) {
                        this.isDrawing = false;
                        this.saveSignature();
                    }
                },

                saveSignature() {
                    this.signatureData = this.canvas.toDataURL('image/png');
                },

                clearSignature() {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.signatureData = '';
                    this.isEmpty = true;
                }
            };
        }
    </script>
</x-layouts.publik>
