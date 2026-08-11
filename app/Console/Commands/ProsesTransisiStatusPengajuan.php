<?php

namespace App\Console\Commands;

use App\Models\Pengajuan;
use App\Services\PengajuanService;
use App\Mail\ReminderLaporanTelatMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ProsesTransisiStatusPengajuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:proses-transisi-status-pengajuan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan transisi status pengajuan magang otomatis berdasarkan tanggal, serta mengirim email pengingat laporan akhir yang telat';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected PengajuanService $pengajuanService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $this->info("Memulai proses transisi status pengajuan magang harian: {$today}");

        // 1. Transisi: Disetujui -> Terjadwal
        // Semua pengajuan yang disetujui diposisikan ke status Terjadwal
        $disetujuans = Pengajuan::where('status', 'Disetujui')->get();
        $this->info("Menemukan " . $disetujuans->count() . " pengajuan berstatus Disetujui untuk ditransisikan.");
        foreach ($disetujuans as $p) {
            $this->pengajuanService->ubahStatus(
                $p,
                'Terjadwal',
                'Transisi otomatis ke status Terjadwal setelah verifikasi disetujui.',
                null // Null actor represents automated scheduler action
            );
        }

        // 2. Transisi: Terjadwal -> Sedang Magang
        // Terjadi jika tanggal_mulai <= hari ini
        $magangMulai = Pengajuan::where('status', 'Terjadwal')
            ->where('tanggal_mulai', '<=', $today)
            ->get();
        
        $this->info("Menemukan " . $magangMulai->count() . " pengajuan Terjadwal yang siap masuk masa aktif magang.");
        foreach ($magangMulai as $p) {
            $this->pengajuanService->ubahStatus(
                $p,
                'Sedang Magang',
                'Transisi otomatis: Hari pertama pelaksanaan magang/PKL telah tiba.',
                null
            );
        }

        // 3. Pengingat Keterlambatan Laporan
        // Status Sedang Magang, tanggal_selesai_rencana < hari ini, laporan_status bukan Menunggu Review / Diterima
        $laporanTelats = Pengajuan::where('status', 'Sedang Magang')
            ->where('tanggal_selesai_rencana', '<', $today)
            ->where(function ($q) {
                $q->whereNull('laporan_status')
                  ->orWhereNotIn('laporan_status', ['Menunggu Review', 'Diterima']);
            })
            ->with('user')
            ->get();

        $this->info("Menemukan " . $laporanTelats->count() . " peserta aktif yang terlambat melapor.");
        foreach ($laporanTelats as $p) {
            if ($p->user && $p->user->email) {
                Mail::to($p->user->email)->queue(new ReminderLaporanTelatMail($p));
            }
        }

        $this->info('Proses transisi status pengajuan magang selesai.');
    }
}
