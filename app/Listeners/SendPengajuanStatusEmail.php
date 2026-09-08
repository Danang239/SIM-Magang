<?php

namespace App\Listeners;

use App\Events\PengajuanStatusChanged;
use App\Mail\PengajuanDisetujuiMail;
use App\Mail\PengajuanDitolakMail;
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
            Mail::to($user->email)->queue(new PengajuanDisetujuiMail($pengajuan->id));
        } elseif ($pengajuan->status === 'Ditolak') {
            Mail::to($user->email)->queue(new PengajuanDitolakMail($pengajuan->id, $event->catatan));
        }
    }
}
