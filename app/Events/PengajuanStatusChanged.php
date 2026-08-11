<?php

namespace App\Events;

use App\Models\Pengajuan;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengajuanStatusChanged
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Pengajuan $pengajuan,
        public ?string $catatan = null,
        public ?int $createdBy = null
    ) {}
}
