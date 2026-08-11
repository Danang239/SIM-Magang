<?php

namespace App\Listeners;

use App\Events\PengajuanStatusChanged;
use App\Mail\PengajuanDisetujuiMail;
use App\Mail\PengajuanDitolakMail;
use App\Mail\LaporanDiterimaMail;
use Illuminate\Support\Facades\Mail;

class SendPengajuanStatusEmail
{
    /**
     * Handle the event.
     */
    public function handle(PengajuanStatusChanged $event): void
    {
        $pengajuan = $event->pengajuan;
        $user = $pengajuan->user;

        if (!$user || !$user->email) {
            return;
        }

        if ($pengajuan->status === 'Disetujui') {
            Mail::to($user->email)->queue(new PengajuanDisetujuiMail($pengajuan));
        } elseif ($pengajuan->status === 'Ditolak') {
            Mail::to($user->email)->queue(new PengajuanDitolakMail($pengajuan, $event->catatan));
        } elseif ($pengajuan->status === 'Selesai') {
            Mail::to($user->email)->queue(new LaporanDiterimaMail($pengajuan));
        }
    }
}
