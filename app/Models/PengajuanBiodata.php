<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pengajuan_id',
    'nim_nisn',
    'tempat_lahir',
    'tanggal_lahir',
    'jenis_kelamin',
    'alamat',
    'kontak_darurat_nama',
    'kontak_darurat_no',
    'hubungan_kontak_darurat'
])]
class PengajuanBiodata extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Pengajuan.
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
