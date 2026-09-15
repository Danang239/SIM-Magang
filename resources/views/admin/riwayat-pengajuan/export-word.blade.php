<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <meta charset="utf-8">
    <title>Form-1 & Form-2 - {{ $pengajuan->nomor_pengajuan }}</title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page Section1 {
            size: 595.3pt 841.9pt; /* A4 */
            margin: 1cm 1.5cm 1cm 1.5cm;
            mso-header-margin: 35.4pt;
            mso-footer-margin: 35.4pt;
            mso-paper-source: 0;
        }
        div.Section1 {
            page: Section1;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5pt;
            line-height: 1.35;
            color: #111827;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .top-banner {
            background-color: #e5e7eb;
            border: 1px solid #9ca3af;
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            padding: 6px 0;
            margin-bottom: 10px;
        }
        .form-code {
            font-size: 9.5pt;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .doc-header-title {
            text-align: center;
            font-size: 11.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 9.5pt;
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 4px;
        }
        .form-table td {
            padding: 3px 2px;
            vertical-align: top;
            font-size: 9.5pt;
        }
        .label-col {
            width: 32%;
        }
        .sep-col {
            width: 3%;
            text-align: center;
        }
        .val-col {
            width: 65%;
        }
        .photo-cell {
            width: 95px;
            text-align: center;
            vertical-align: top;
            padding-right: 12px;
        }
        .photo-box {
            width: 85px;
            height: 120px;
            border: 1px solid #111827;
            text-align: center;
            line-height: 120px;
            font-size: 8pt;
            font-weight: bold;
        }
        .statement-text {
            margin-top: 10px;
            margin-bottom: 8px;
            font-size: 9pt;
            text-align: justify;
        }
        .sig-table {
            width: 100%;
            margin-top: 10px;
        }
        .sig-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }
        .sig-space {
            height: 60px;
        }
        .footer-notes {
            margin-top: 10px;
            font-size: 7.5pt;
        }
        .electronic-seal {
            margin-top: 8px;
            border-top: 1px solid #9ca3af;
            padding-top: 4px;
            font-size: 7pt;
            text-align: center;
            color: #4b5563;
        }
        .rule-list {
            margin: 6px 0 8px 0;
            padding-left: 20px;
            font-size: 9pt;
        }
        .rule-list li {
            margin-bottom: 4px;
            text-align: justify;
        }
    </style>
</head>
<body>
<div class="Section1">

    <!-- ======================================================= -->
    <!-- HALAMAN 1: FORM-1 PT -->
    <!-- ======================================================= -->
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

    <div class="section-title">A. DATA PRIBADI</div>
    <table>
        <tr>
            <td class="photo-cell">
                @if(!empty($fotoBase64))
                    <img src="{{ $fotoBase64 }}" width="85" height="120" style="border: 1px solid #111827;" alt="Pas Foto 4x6">
                @else
                    <div class="photo-box">Foto Berwarna<br>4 x 6</div>
                @endif
            </td>
            <td style="vertical-align: top; width: 80%;">
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

    <div class="section-title">B. ASAL {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'SEKOLAH' : 'PERGURUAN TINGGI' }}</div>
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
            <td class="label-col">Nama {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Guru' : 'Dosen' }} Pembimbing</td>
            <td class="sep-col">:</td>
            <td class="val-col">{{ $pengajuan->nama_dosen_pembimbing ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Pembimbing dari BRMP Biogen</td>
            <td class="sep-col">:</td>
            <td class="val-col">{{ $pengajuan->pembimbing?->nama ?: 'Ditetapkan oleh BRMP Biogen' }}</td>
        </tr>
    </table>

    <div class="statement-text">
        Menyatakan bahwa data tersebut adalah data yang sebenarnya, dan saya bersedia mendapatkan sanksi apabila tidak benar.
    </div>

    <table class="sig-table">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div>Bogor, {{ $pengajuan->created_at->translatedFormat('d F Y') }}</div>
                <div>Tanda tangan</div>
                <div class="sig-space">
                    @if(!empty($ttdBase64))
                        <img src="{{ $ttdBase64 }}" width="110" alt="Tanda Tangan Digital">
                    @endif
                </div>
                <div style="font-weight: bold;">( {{ $pengajuan->user->name }} )</div>
            </td>
        </tr>
    </table>

    <!-- PAGE BREAK TO FORM-2 -->
    <br clear="all" style="page-break-before:always" />

    <!-- ======================================================= -->
    <!-- HALAMAN 2: FORM-2 PT (SURAT PERNYATAAN) -->
    <!-- ======================================================= -->
    <div class="form-code">
        Form-2 {{ strtolower($pengajuan->jenjang) === 'siswa' ? 'Siswa' : 'PT' }}
    </div>

    <div class="doc-header-title">
        SURAT PERNYATAAN
    </div>

    @php
        $dayName = $pengajuan->created_at->translatedFormat('l');
        $dateNum = $pengajuan->created_at->translatedFormat('j');
        $monthName = $pengajuan->created_at->translatedFormat('F');
        $yearNum = $pengajuan->created_at->translatedFormat('Y');
    @endphp

    <div style="margin-bottom: 8px;">
        Hari ini hari <strong>{{ $dayName }}</strong> tanggal <strong>{{ $dateNum }}</strong> bulan <strong>{{ $monthName }}</strong> tahun <strong>{{ $yearNum }}</strong>
    </div>

    <div style="font-weight: bold; margin-bottom: 6px;">
        Saya yang bertanda tangan di bawah ini
    </div>

    <table class="form-table" style="margin-left: 15px; width: 95%;">
        <tr>
            <td class="label-col">Nama</td>
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

    <div style="margin-top: 8px; margin-bottom: 4px;">
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

    <div class="statement-text">
        Demikian pernyataan ini saya buat dengan sadar tanpa paksaan. Apabila di kemudian hari diketahui bahwa saya menyalahi/bertindak melanggar isi pernyataan ini, saya bersedia dituntut berdasarkan aturan yang berlaku.
    </div>

    <table class="sig-table" style="margin-top: 15px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <div>Yang membuat pernyataan,</div>
                <div class="sig-space" style="margin-top: 10px;">
                    @if(!empty($ttdBase64))
                        <img src="{{ $ttdBase64 }}" width="110" alt="Tanda Tangan Digital">
                    @endif
                </div>
                <div style="font-weight: bold;">( {{ $pengajuan->user->name }} )</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
