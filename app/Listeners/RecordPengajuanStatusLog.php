<?php

namespace App\Listeners;

use App\Events\PengajuanStatusChanged;
use App\Models\PengajuanStatusLog;

class RecordPengajuanStatusLog
{
    /**
     * Handle the event.
     */
    public function handle(PengajuanStatusChanged $event): void
    {
        PengajuanStatusLog::create([
            'pengajuan_id' => $event->pengajuan->id,
            'status' => $event->pengajuan->status,
            'catatan' => $event->catatan,
            'created_by' => $event->createdBy,
        ]);
    }
}
