<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengajuan Magang Disetujui</title>
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
            border: 1px border #e5e7eb;
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
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #a7f3d0; font-weight: bold; text-transform: uppercase;">Penerimaan Magang & PKL</p>
        </div>
        <div class="content">
            <h2>Halo, {{ $pengajuan->user->name }}</h2>
            <p>Selamat! Kami senang memberitahu Anda bahwa pengajuan magang/PKL Anda di BRMP Biogen telah <strong>DISETUJUI</strong> oleh petugas verifikasi kami.</p>
            
            <p>Berikut adalah ringkasan detail penempatan Anda:</p>
            
            <div class="details-box">
                <div class="details-row">
                    <span class="details-label">Nomor Pengajuan</span>
                    <span class="details-val">{{ $pengajuan->nomor_pengajuan }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Bidang Penempatan</span>
                    <span class="details-val">{{ $pengajuan->bidang->nama_bidang }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Tanggal Mulai</span>
                    <span class="details-val">{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Rencana Selesai</span>
                    <span class="details-val">{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai_rencana)->translatedFormat('d F Y') }}</span>
                </div>
                @if($pengajuan->bidang->pembimbing)
                    <div class="details-row" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e5e7eb;">
                        <span class="details-label">Pembimbing Lapangan</span>
                        <span class="details-val">{{ $pengajuan->bidang->pembimbing->name }}</span>
                    </div>
                @endif
            </div>

            <p style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; font-size: 13px; color: #78350f; border-radius: 4px;">
                <strong>PENTING:</strong> Agar jadwal magang Anda resmi diaktifkan dan status berubah menjadi <strong>Terjadwal</strong>, Anda wajib masuk ke portal website dan melengkapi <strong>Kuesioner SKM</strong>.
            </p>

            <p>Jika Anda memerlukan informasi lebih lanjut, silakan hubungi unit pelayanan kami melalui WhatsApp di +628111756776 atau surel di magangbiogen@gmail.com.</p>

            <a href="{{ route('pengguna.pengajuan.show', $pengajuan->public_id) }}" class="btn">Lengkapi SKM Sekarang</a>
        </div>
        <div class="footer">
            SIP Biogen &copy; {{ date('Y') }} BRMP Biogen - Kementerian Pertanian RI<br>
            Jl. Tentara Pelajar No. 3A, Bogor, Jawa Barat
        </div>
    </div>
</body>
</html>
