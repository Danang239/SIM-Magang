<?php

namespace App\Console\Commands;

use App\Models\Pengajuan;
use App\Services\PengajuanService;
use Illuminate\Console\Command;
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
    protected $description = 'Melakukan transisi status pengajuan magang otomatis berdasarkan tanggal';

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

        // 3. Transisi: Sedang Magang -> Selesai
        $magangSelesai = Pengajuan::where('status', 'Sedang Magang')
            ->where('tanggal_selesai_rencana', '<', $today)
            ->get();

        $this->info("Menemukan " . $magangSelesai->count() . " pengajuan yang telah melewati batas tanggal selesai.");
        foreach ($magangSelesai as $p) {
            $this->pengajuanService->ubahStatus(
                $p,
                'Selesai',
                'Transisi otomatis: Masa pelaksanaan PKL telah selesai.',
                null
            );
        }

        $this->info('Proses transisi status pengajuan magang selesai.');
    }
}
