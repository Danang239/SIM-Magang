<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Tahunan Magang {{ $year }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0b5e3c;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #0b5e3c;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 11px;
            margin: 5px 0 0 0;
            color: #555555;
            font-weight: normal;
        }
        .title {
            text-align: center;
            margin-bottom: 25px;
        }
        .title h3 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 5px 0;
        }
        .summary-label {
            font-weight: bold;
            color: #555555;
            width: 40%;
        }
        .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #0b5e3c;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0b5e3c;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th {
            background-color: #0b5e3c;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 6px 10px;
            border: 1px solid #0b5e3c;
        }
        table.data-table td {
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 9px;
            color: #777777;
        }
        .signature-section {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="header">
        <h1>Balai Besar Pengujian Standar Instrumen Bioteknologi</h1>
        <h2>Badan Standardisasi Instrumen Pertanian - Kementerian Pertanian RI</h2>
        <div style="font-size: 9px; color: #888888; margin-top: 3px;">Jl. Tentara Pelajar No. 3A, Bogor 16111 | Telp: (0251) 8337975</div>
    </div>

    <!-- Judul Laporan -->
    <div class="title">
        <h3>Laporan Rekapitulasi Tahunan Program Magang & PKL</h3>
        <div style="font-size: 11px; margin-top: 5px; font-weight: bold; color: #555555;">TAHUN ANGGARAN {{ $year }}</div>
    </div>

    <!-- Ringkasan Kinerja -->
    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td class="summary-label">Total Pengajuan Masuk</td>
                <td class="summary-value">: {{ $totalSubmissions }} Pendaftar</td>
            </tr>
            <tr>
                <td class="summary-label">Rata-rata Indeks Kepuasan (SKM)</td>
                <td class="summary-value">: {{ $skmAverage }} / 5.00</td>
            </tr>
        </table>
    </div>

    <!-- Statistik Berdasarkan Status -->
    <div class="section-title">1. Statistik Status Pengajuan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 70%;">Status Pengajuan</th>
                <th style="width: 30%; text-align: right;">Jumlah Pendaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statusStats as $status => $count)
                <tr>
                    <td>{{ $status }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Distribusi Per Bidang -->
    <div class="section-title">2. Distribusi Pendaftar per Bidang Penempatan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">No.</th>
                <th style="width: 60%;">Nama Bidang Penempatan</th>
                <th style="width: 30%; text-align: right;">Jumlah Pendaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bidangStats as $index => $bidang)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $bidang->nama_bidang }} ({{ $bidang->jenjang }})</td>
                    <td style="text-align: right; font-weight: bold;">{{ $bidang->pengajuans_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan & Metadata -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Bogor, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold; margin-top: 5px;">Kepala Bagian Tata Usaha</p>
            <div class="signature-space"></div>
            <p style="text-decoration: underline; font-weight: bold;">Dr. Ir. Mastur, M.Si.</p>
            <p>NIP. 19660308 199303 1 002</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        Dicetak secara otomatis oleh SIM-MAGANG BB-Biogen pada {{ $generatedAt }}
    </div>
</body>
</html>
