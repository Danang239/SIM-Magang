<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pengajuan_id', 'skm_pertanyaan_id', 'rating'])]
class SkmJawaban extends Model
{
    use HasFactory;

    protected $table = 'skm_jawaban';

    // Hanya menggunakan created_at
    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Relasi ke Pengajuan.
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    /**
     * Relasi ke SkmPertanyaan.
     */
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(SkmPertanyaan::class, 'skm_pertanyaan_id');
    }
}
