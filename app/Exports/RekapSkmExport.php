<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapSkmExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pertanyaans;
    protected $startDate;
    protected $endDate;

    public function __construct(
        protected int $year,
        protected int $quarter
    ) {
        $this->pertanyaans = \App\Models\SkmPertanyaan::where('is_active', true)->orderBy('urutan', 'asc')->get();

        // Calculate quarter dates
        $startMonth = (($quarter - 1) * 3) + 1;
        $this->startDate = \Carbon\Carbon::create($year, $startMonth, 1)->startOfDay();
        $this->endDate = $this->startDate->copy()->addMonths(3)->subDay()->endOfDay();
    }

    /**
     * Return collection of submissions with SKM answers in the period.
     */
    public function collection()
    {
        return Pengajuan::whereHas('skmJawabans', function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->with(['user', 'bidang', 'skmJawabans'])
            ->get();
    }

    /**
     * Define header columns dynamically based on active SKM questions.
     */
    public function headings(): array
    {
        $headings = [
            'Nomor Pengajuan',
            'Nama Peserta',
            'Jenis Kelamin',
            'Pendidikan Terakhir',
            'Usia (Tahun)',
            'Pekerjaan',
            'Status Disabilitas',
            'Bidang Penempatan',
            'Tanggal SKM Diisi',
        ];

        foreach ($this->pertanyaans as $p) {
            $headings[] = $p->teks_pertanyaan;
        }

        $headings[] = 'Saran / Masukan';

        return $headings;
    }

    /**
     * Map each record to spreadsheet columns.
     */
    public function map($row): array
    {
        $usia = $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->age . ' Thn' : '-';

        $map = [
            $row->nomor_pengajuan,
            $row->user->name,
            $row->jenis_kelamin ?? '-',
            $row->pendidikan_terakhir ?? $row->jenjang,
            $usia,
            'Siswa / Mahasiswa',
            $row->status_disabilitas ?? 'Bukan Penyandang Disabilitas',
            $row->bidang->nama_bidang,
            $row->skmJawabans->first()?->created_at ? $row->skmJawabans->first()->created_at->toDateString() : '-',
        ];

        // Map rating to each question ID
        $jawabanMap = $row->skmJawabans->pluck('rating', 'skm_pertanyaan_id')->all();

        foreach ($this->pertanyaans as $p) {
            $map[] = $jawabanMap[$p->id] ?? '-';
        }

        $map[] = $row->skm_saran ?? '-';

        return $map;
    }
}
