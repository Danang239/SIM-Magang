<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengajuan Magang Baru Masuk</title>
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
        .details-box {
            background-color: #f9fafb;
            border: 1px solid #f3f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .details-label {
            color: #6b7280;
            font-weight: 600;
        }
        .details-val {
            color: #111827;
            font-weight: 700;
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
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #a7f3d0; font-weight: bold; text-transform: uppercase;">Notifikasi Pengajuan Baru</p>
        </div>
        <div class="content">
            <h2>Halo, Pembimbing Bidang</h2>
            <p>Terdapat pengajuan pendaftaran program magang baru yang masuk ke bidang Anda. Silakan melakukan peninjauan berkas calon peserta magang ini.</p>
            
            <p>Berikut adalah detail pengajuan:</p>
            
            <div class="details-box">
                <div class="details-row">
                    <span class="details-label">Nama Pemohon</span>
                    <span class="details-val">{{ $pengajuan->user->name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Nomor Pengajuan</span>
                    <span class="details-val">{{ $pengajuan->nomor_pengajuan }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Bidang Penempatan</span>
                    <span class="details-val">{{ $pengajuan->bidang->nama_bidang }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Tanggal Masuk</span>
                    <span class="details-val">{{ $pengajuan->created_at->translatedFormat('d F Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Durasi Magang</span>
                    <span class="details-val">{{ $pengajuan->durasi_bulan }} Bulan</span>
                </div>
            </div>

            <a href="{{ route('petugas.verifikasi.show', $pengajuan->public_id) }}" class="btn">Tinjau & Verifikasi Pengajuan</a>
        </div>
        <div class="footer">
            SIM-MAGANG &copy; {{ date('Y') }} BRMP Biogen - Kementerian Pertanian RI<br>
            Jl. Tentara Pelajar No. 3A, Bogor, Jawa Barat
        </div>
    </div>
</body>
</html>
