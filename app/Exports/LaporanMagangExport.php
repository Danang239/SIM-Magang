<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanMagangExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected int $year
    ) {}

    /**
     * Return collection of submissions for the selected year.
     */
    public function collection()
    {
        return Pengajuan::whereYear('created_at', $this->year)
            ->with(['user', 'bidang'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Define header columns.
     */
    public function headings(): array
    {
        return [
            'Nomor Pengajuan',
            'Nama Peserta',
            'Email',
            'No. HP',
            'Instansi',
            'Program Studi',
            'NIM/NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Kontak Darurat Nama',
            'Kontak Darurat No',
            'Hubungan Kontak Darurat',
            'Bidang Penempatan',
            'Jenjang',
            'Durasi (Bulan)',
            'Tanggal Mulai',
            'Tanggal Selesai Rencana',
            'Status Utama',
            'Status Laporan',
            'Saran SKM'
        ];
    }

    /**
     * Map each record to spreadsheet columns.
     */
    public function map($row): array
    {
        return [
            $row->nomor_pengajuan,
            $row->user->name,
            $row->user->email,
            $row->user->no_hp ?? '-',
            $row->user->instansi ?? '-',
            $row->user->program_studi ?? '-',
            $row->nim_nisn ?? '-',
            $row->tempat_lahir ?? '-',
            $row->tanggal_lahir ? $row->tanggal_lahir->toDateString() : '-',
            $row->jenis_kelamin ?? '-',
            $row->alamat ?? '-',
            $row->kontak_darurat_nama ?? '-',
            $row->kontak_darurat_no ?? '-',
            $row->hubungan_kontak_darurat ?? '-',
            $row->bidang->nama_bidang,
            $row->jenjang,
            $row->durasi_bulan,
            $row->tanggal_mulai ? $row->tanggal_mulai->toDateString() : '-',
            $row->tanggal_selesai_rencana ? $row->tanggal_selesai_rencana->toDateString() : '-',
            $row->status,
            $row->laporan_status ?? 'Belum Ada',
            $row->skm_saran ?? '-'
        ];
    }
}
