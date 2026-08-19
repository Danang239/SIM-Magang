<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['nama_bidang', 'deskripsi', 'jenjang', 'kategori', 'pembimbing_id', 'kapasitas', 'is_active', 'jobdesc', 'gambar'])]
class Bidang extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'kapasitas' => 'integer',
        ];
    }

    /**
     * Relasi ke Pembimbing Utama (Legacy single pembimbing).
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    /**
     * Relasi ke Multi-Petugas Pembimbing (Many-to-Many via bidang_petugas pivot).
     */
    public function petugasList(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bidang_petugas', 'bidang_id', 'petugas_id')
            ->withPivot('kuota')
            ->withTimestamps();
    }

    /**
     * Total kapasitas bidang (penjumlahan kuota seluruh petugas di bidang ini).
     */
    public function getKapasitasTotalAttribute(): int
    {
        if ($this->petugasList()->exists()) {
            return (int) $this->petugasList()->sum('bidang_petugas.kuota');
        }

        return (int) $this->kapasitas;
    }

    /**
     * Relasi ke Pengajuan.
     */
    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }
}
