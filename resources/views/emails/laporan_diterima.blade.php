<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Akhir Diterima</title>
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
            background-color: #0b5e3c;
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
        .success-box {
            background-color: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
            color: #065f46;
            font-size: 14px;
        }
        .success-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .btn {
            display: block;
            background-color: #0b5e3c;
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
            background-color: #2f9a32;
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
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #a7f3d0; font-weight: bold; text-transform: uppercase;">Penyelesaian Magang & PKL</p>
        </div>
        <div class="content">
            <h2>Halo, {{ $pengajuan->user->name }}</h2>
            <p>Selamat! Laporan Akhir Magang Anda untuk pengajuan nomor <strong>{{ $pengajuan->nomor_pengajuan }}</strong> telah ditinjau dan dinyatakan <strong>DITERIMA</strong> secara resmi oleh pembimbing dan petugas BRMP Biogen.</p>
            
            <div class="success-box">
                <div class="success-title">Informasi Penyelesaian:</div>
                <p style="margin: 0;">Status Kelulusan: <strong>SELESAI (LULUS PROGRAM)</strong></p>
                <p style="margin: 5px 0 0 0;">Surat Keterangan: <strong>Sudah Diterbitkan</strong></p>
            </div>

            <p>Dengan diterimanya laporan akhir ini, seluruh administrasi magang Anda telah selesai. Anda dipersilakan mengunduh Surat Keterangan Selesai Magang resmi melalui tautan di bawah ini atau secara langsung melalui menu detail riwayat pengajuan di portal peserta.</p>

            <a href="{{ route('login') }}" class="btn">Masuk Portal & Unduh Surat Keterangan</a>
        </div>
        <div class="footer">
            SIM-MAGANG &copy; {{ date('Y') }} BRMP Biogen - Kementerian Pertanian RI<br>
            Jl. Tentara Pelajar No. 3A, Bogor, Jawa Barat
        </div>
    </div>
</body>
</html>
