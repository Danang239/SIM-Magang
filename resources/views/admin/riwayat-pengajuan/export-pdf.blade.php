<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Form-1 & Form-2 PT - {{ $pengajuan->nomor_pengajuan }}</title>
    <style>
        @page {
            margin: 1cm 1.5cm 1cm 1.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            line-height: 1.28;
            color: #111827;
            margin: 0;
            padding: 0;
        }
        
        .page-break {
            page-break-after: always;
        }

        /* Top Header Container */
        .top-banner {
            background-color: #e5e7eb;
            border: 1px solid #9ca3af;
            text-align: center;
            font-weight: 800;
            font-size: 10.5pt;
            padding: 5px 0;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-code {
            font-size: 8.5pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .doc-header-title {
            text-align: center;
            font-size: 10.5pt;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 8px;
            line-height: 1.25;
        }

        /* Section Title */
        .section-title {
            font-size: 8.5pt;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 5px;
            margin-bottom: 3px;
        }

        /* Data Tables */
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .form-table td {
            padding: 2px 2px;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .label-col {
            width: 32%;
            color: #111827;
            font-weight: normal;
        }
        .sep-col {
            width: 2%;
            text-align: center;
        }
        .val-col {
            width: 66%;
            color: #111827;
        }

        /* Photo Box */
        .photo-container {
            width: 100%;
            border-collapse: collapse;
        }
        .photo-container td {
            vertical-align: top;
            padding: 0;
        }
        .photo-frame {
            width: 85px;
            text-align: center;
            padding-right: 8px;
        }
        .photo-box-border {
            width: 80px;
            height: 115px;
            border: 1.2px solid #111827;
            text-align: center;
            background: #ffffff;
            margin: 0 auto;
        }
        .photo-box-border img {
            width: 80px;
            height: 115px;
            object-fit: cover;
            display: block;
        }
        .photo-box-placeholder {
            width: 80px;
            height: 115px;
            display: table-cell;
            vertical-align: middle;
            font-size: 7.5pt;
            font-weight: bold;
            color: #374151;
            line-height: 1.2;
            padding: 0 4px;
        }

        /* Statement Box */
        .statement-text {
            margin-top: 6px;
            margin-bottom: 6px;
            font-size: 8pt;
            line-height: 1.25;
            text-align: justify;
        }

        /* Signature Table */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .signature-table td {
            vertical-align: top;
            font-size: 8pt;
        }
        .sig-right {
            width: 48%;
            text-align: center;
            margin-left: auto;
        }
        .sig-box-space {
            height: 48px;
            position: relative;
        }
        .sig-box-space img {
            max-height: 46px;
            max-width: 120px;
        }

        /* Footer Notes */
        .footer-notes {
            margin-top: 6px;
            font-size: 7pt;
            line-height: 1.2;
            color: #111827;
        }
        .electronic-seal {
            margin-top: 5px;
            border-top: 0.8px solid #9ca3af;
            padding-top: 3px;
            font-size: 6.5pt;
            text-align: center;
            color: #4b5563;
            line-height: 1.2;
        }

        /* Form-2 Styles */
        .statement-header-title {
            text-align: center;
            font-size: 11pt;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 6px;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        .opening-date {
            font-size: 8.5pt;
            margin-bottom: 6px;
            line-height: 1.35;
        }
        .rule-list {
            margin: 4px 0 6px 0;
            padding-left: 16px;
            font-size: 8pt;
            line-height: 1.25;
        }
        .rule-list li {
            margin-bottom: 3.5px;
            text-align: justify;
        }
        .closing-text {
            font-size: 8pt;
            line-height: 1.25;
            text-align: justify;
            margin-top: 6px;
            margin-bottom: 8px;
        }
        .materai-label {
            font-style: italic;
            font-size: 7.5pt;
            color: #4b5563;
            margin: 8px 0;
        }
    </style>
</head>
<body>

    <!-- ======================================================= -->
    <!-- HALAMAN 1: FORM-1 PT (DATA PESERTA PKL) -->
    <!-- ======================================================= -->
    <div>
        <!-- Top Banner Header -->
        <div class="top-banner">
            Form-1 dan Form-2 untuk {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Siswa / SMK' : 'Perguruan Tinggi' }}
        </div>

        <div class="form-code">
            Form-1 {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Siswa' : 'PT' }}
        </div>

        <div class="doc-header-title">
            DATA PESERTA PKL<br>
            DI BRMP BIOGEN
        </div>

        <!-- A. DATA PRIBADI (Side-by-side with 4x6 Photo) -->
        <div class="section-title">A. DATA PRIBADI</div>
        <table class="photo-container">
            <tr>
                <td class="photo-frame">
                    <div class="photo-box-border">
                        @if(!empty($fotoBase64))
                            <img src="{{ $fotoBase64 }}" alt="Pas Foto 4x6">
                        @else
                            <div class="photo-box-placeholder">
                                Foto Berwarna<br>4 x 6
                            </div>
                        @endif
                    </div>
                </td>
                <td style="width: 82%;">
                    <table class="form-table">
                        <tr>
                            <td class="label-col">Nama Lengkap</td>
                            <td class="sep-col">:</td>
                            <td class="val-col"><strong>{{ $pengajuan->user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label-col">No. KTP/NIK</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $pengajuan->nik_ktp ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">No. Induk {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Siswa' : 'Mahasiswa' }}</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $pengajuan->nim_nisn ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Alamat</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $pengajuan->alamat ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">No. Telepon/HP</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $pengajuan->user->no_hp ?: '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- B. ASAL PERGURUAN TINGGI / SEKOLAH -->
        <div class="section-title" style="margin-top: 4px;">B. ASAL {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'SEKOLAH' : 'PERGURUAN TINGGI' }}</div>
        <table class="form-table">
            <tr>
                <td class="label-col">Nama {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Sekolah' : 'Perguruan Tinggi' }}</td>
                <td class="sep-col">:</td>
                <td class="val-col"><strong>{{ $pengajuan->instansi ?: ($pengajuan->user->instansi ?: '-') }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Nama {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Kepala Sekolah' : 'Rektor Perguruan Tinggi' }}</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->nama_pimpinan_instansi ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Sekolah' : 'Perguruan Tinggi' }}</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->alamat_instansi ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">No. Telepon/Faks./E-mail</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->kontak_instansi ?: '-' }}</td>
            </tr>
            @if(strtolower($pengajuan->jenjang) !== 'siswa')
            <tr>
                <td class="label-col">Fakultas</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->fakultas ?: '-' }}</td>
            </tr>
            @endif
            <tr>
                <td class="label-col">Jurusan / Program Studi</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->program_studi ?: ($pengajuan->user->program_studi ?: '-') }}</td>
            </tr>
            <tr>
                <td class="label-col">Tahun Masuk</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->tahun_masuk ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Pendidikan Terakhir</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->pendidikan_terakhir ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Semester saat ini/Tahun</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->semester_saat_ini ?: '-' }}</td>
            </tr>
        </table>

        <!-- C. MATERI PKL -->
        <div class="section-title">C. MATERI PKL</div>
        <table class="form-table">
            <tr>
                <td class="label-col">Judul PKL*)</td>
                <td class="sep-col">:</td>
                <td class="val-col"><strong>{{ $pengajuan->judul_magang ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Tujuan PKL*)</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->tujuan_magang ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Waktu PKL*)</td>
                <td class="sep-col">:</td>
                <td class="val-col">
                    {{ $pengajuan->tanggal_mulai ? $pengajuan->tanggal_mulai->translatedFormat('d F Y') : '......................' }} 
                    s/d 
                    {{ $pengajuan->tanggal_selesai_rencana ? $pengajuan->tanggal_selesai_rencana->translatedFormat('d F Y') : '......................' }}
                </td>
            </tr>
            <tr>
                <td class="label-col">Nama {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Guru' : 'Dosen' }} Pembimbing dari {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Sekolah' : 'Perguruan Tinggi' }}</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->nama_dosen_pembimbing ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Nama Pembimbing dari BRMP Biogen</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->pembimbing?->nama ?: 'Ditetapkan oleh BRMP Biogen' }}</td>
            </tr>
        </table>

        <!-- Declaration Text -->
        <div class="statement-text">
            Menyatakan bahwa data tersebut adalah data yang sebenarnya, dan saya bersedia mendapatkan sanksi apabila tidak benar.
        </div>

        <!-- Signature Section -->
        <table class="signature-table">
            <tr>
                <td style="width: 52%;">
                    <!-- Left empty space / Verification marker if needed -->
                    @if(in_array($pengajuan->status, ['Disetujui', 'Terjadwal', 'Aktif', 'Selesai']))
                        <div style="margin-top: 15px; border: 1.2px solid #0b5e3c; color: #0b5e3c; padding: 4px 8px; width: 140px; text-align: center; font-size: 7.5pt; font-weight: bold; border-radius: 3px;">
                            TERVERIFIKASI SISTEM<br>
                            <span style="font-size: 6.5pt; color: #4b5563;">BRMP BIOGEN</span>
                        </div>
                    @endif
                </td>
                <td style="width: 48%; text-align: center;">
                    <div>Bogor, {{ $pengajuan->created_at->translatedFormat('d F Y') }}</div>
                    <div style="margin-top: 2px;">Tanda tangan</div>
                    <div class="sig-box-space">
                        @if(!empty($ttdBase64))
                            <img src="{{ $ttdBase64 }}" alt="Tanda Tangan Digital">
                        @endif
                    </div>
                    <div style="font-weight: bold;">({{ $pengajuan->user->name }})</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- ======================================================= -->
    <!-- PAGE BREAK KE HALAMAN 2: FORM-2 PT (SURAT PERNYATAAN) -->
    <!-- ======================================================= -->
    <div class="page-break"></div>

    <div>
        <div class="form-code">
            Form-2 {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Siswa' : 'PT' }}
        </div>

        <div class="statement-header-title">
            SURAT PERNYATAAN
        </div>

        @php
            $dayName = $pengajuan->created_at->translatedFormat('l');
            $dateNum = $pengajuan->created_at->translatedFormat('j');
            $monthName = $pengajuan->created_at->translatedFormat('F');
            $yearNum = $pengajuan->created_at->translatedFormat('Y');
        @endphp

        <div class="opening-date">
            Hari ini hari <strong>{{ $dayName }}</strong> tanggal <strong>{{ $dateNum }}</strong> bulan <strong>{{ $monthName }}</strong> tahun <strong>{{ $yearNum }}</strong>
        </div>

        <div style="font-size: 8.5pt; font-weight: bold; margin-bottom: 4px;">
            Saya yang bertanda tangan di bawah ini
        </div>

        <table class="form-table" style="margin-left: 10px; width: 97%;">
            <tr>
                <td class="label-col" style="width: 32%;">Nama</td>
                <td class="sep-col">:</td>
                <td class="val-col"><strong>{{ $pengajuan->user->name }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Alamat</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->alamat ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Nomor Hp</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->user->no_hp ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">E-mail</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->user->email }}</td>
            </tr>
            <tr>
                <td class="label-col">{{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Sekolah / Jurusan' : 'Universitas/Fakultas/ Jurusan' }}</td>
                <td class="sep-col">:</td>
                <td class="val-col">
                    {{ $pengajuan->instansi ?: ($pengajuan->user->instansi ?: '-') }}
                    @if($pengajuan->fakultas) / {{ $pengajuan->fakultas }} @endif
                    / {{ $pengajuan->program_studi ?: ($pengajuan->user->program_studi ?: '-') }}
                </td>
            </tr>
            <tr>
                <td class="label-col">Nomor Telepon</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->kontak_instansi ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tingkat Pendidikan</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $pengajuan->pendidikan_terakhir ?: (strtolower($pengajuan->jenjang) === 'siswa' ? 'SMK / Sederajat' : 'S1') }}</td>
            </tr>
            <tr>
                <td class="label-col">Judul PKL</td>
                <td class="sep-col">:</td>
                <td class="val-col"><strong>{{ $pengajuan->judul_magang ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Waktu PKL</td>
                <td class="sep-col">:</td>
                <td class="val-col">
                    {{ $pengajuan->tanggal_mulai ? $pengajuan->tanggal_mulai->translatedFormat('d F Y') : '......................' }} 
                    s/d 
                    {{ $pengajuan->tanggal_selesai_rencana ? $pengajuan->tanggal_selesai_rencana->translatedFormat('d F Y') : '......................' }}
                </td>
            </tr>
        </table>

        <div style="font-size: 8.5pt; margin-top: 6px; margin-bottom: 3px;">
            Dengan ini menyatakan bahwa saya:
        </div>

        <ol class="rule-list">
            <li>Akan mengikuti semua peraturan yang berlaku di BRMP Biogen dan semua ketentuan lain yang ditetapkan oleh pimpinan BRMP Biogen.</li>
            <li>Tidak akan mempublikasikan data/informasi hasil PKL dalam bentuk apapun kecuali seizin BRMP Biogen.</li>
            <li>Akan menyelesaikan semua kewajiban dan mengembalikan semua pinjaman yang dilakukan sebelum meminta surat keterangan selesai PKL.</li>
            <li>Akan menyerahkan laporan PKL kepada pembimbing dan bagian administrasi Kelompok Layanan Standar Instrumen BRMP Biogen sebanyak 1 (satu) rangkap sebagai persyaratan memperoleh surat keterangan selesai PKL.</li>
            <li>Tidak akan menuntut BRMP Biogen apabila terjadi sesuatu kecelakaan selama pelaksanaan PKL di BRMP Biogen yang mengakibatkan berbagai hal akibat dari kecelakaan tersebut.</li>
            <li>Akan menyerahkan sepenuhnya mengenai kepemilikan dan Hak Kekayaan Intelektual (HKI) kepada BRMP Biogen bilamana selama PKL dihasilkan sesuatu yang berkaitan dengan HKI.</li>
            <li>Jika terjadi kerusakan alat menjadi tanggung jawab mahasiswa.</li>
        </ol>

        <div class="closing-text">
            Demikian pernyataan ini saya buat dengan sadar tanpa paksaan. Apabila di kemudian hari diketahui bahwa saya menyalahi/bertindak melanggar isi pernyataan ini, saya bersedia dituntut berdasarkan aturan yang berlaku.
        </div>

        <!-- Signature Box for Form-2 -->
        <table class="signature-table" style="margin-top: 10px;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: center;">
                    <div>Yang membuat pernyataan,</div>
                    <div class="sig-box-space" style="margin-top: 8px;">
                        @if(!empty($ttdBase64))
                            <img src="{{ $ttdBase64 }}" alt="Tanda Tangan Digital">
                        @endif
                    </div>
                    <div style="font-weight: bold;">( {{ $pengajuan->user->name }} )</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
