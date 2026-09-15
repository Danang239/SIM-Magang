<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengajuan Magang Ditangguhkan/Ditolak</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f5f6f8;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        .header {
            background-color: #b91c1c; /* Crimson Red for negative actions */
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            color: #374151;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 18px;
            color: #111827;
            margin-top: 0;
            font-weight: 700;
        }
        .reason-box {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
            color: #991b1b;
            font-size: 14px;
        }
        .reason-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .btn {
            display: block;
            background-color: #b91c1c;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #991b1b;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
            border-top: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BRMP BIOGEN</h1>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #fecaca; font-weight: bold; text-transform: uppercase;">Hasil Verifikasi Pengajuan</p>
        </div>
        <div class="content">
            <h2>Halo, {{ $pengajuan->user->name }}</h2>
            <p>Terima kasih telah mengajukan permohonan magang/PKL di BRMP Biogen.</p>
            
            <p>Setelah meninjau berkas administrasi dan surat pengantar yang Anda lampirkan untuk pengajuan nomor <strong>{{ $pengajuan->nomor_pengajuan }}</strong>, kami memberitahukan bahwa berkas Anda saat ini <strong>BELUM BISA DISETUJUI / DITOLAK</strong> karena alasan berikut:</p>
            
            <div class="reason-box">
                <div class="reason-title">Catatan Alasan Verifikator:</div>
                <p style="margin: 0; font-style: italic;">"{{ $catatan ?? 'Berkas administrasi tidak lengkap atau tidak terbaca dengan jelas.' }}"</p>
            </div>

            <p><strong>Langkah Selanjutnya:</strong> Anda dapat mendaftar kembali dengan memperbaiki atau mengunggah ulang surat pengantar yang valid melalui formulir pendaftaran magang di portal kami.</p>

            <a href="{{ route('login') }}" class="btn">Masuk ke Portal Peserta</a>
        </div>
        <div class="footer">
            SIP Biogen &copy; {{ date('Y') }} BRMP Biogen - Kementerian Pertanian RI<br>
            Jl. Tentara Pelajar No. 3A, Bogor, Jawa Barat
        </div>
    </div>
</body>
</html>
