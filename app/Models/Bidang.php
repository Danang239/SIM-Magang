<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_bidang', 'deskripsi', 'jenjang', 'kategori', 'pembimbing_id', 'kapasitas', 'is_active', 'gambar'])]
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
     * Relasi ke Pembimbing (Many-to-Many via bidang_pembimbing pivot).
     */
    public function pembimbings(): BelongsToMany
    {
        return $this->belongsToMany(Pembimbing::class, 'bidang_pembimbing')
            ->withPivot('kuota')
            ->withTimestamps();
    }

    /**
     * Total kapasitas bidang (penjumlahan kuota seluruh pembimbing di bidang ini).
     */
    public function getKapasitasTotalAttribute(): int
    {
        if ($this->pembimbings()->exists()) {
            return (int) $this->pembimbings()->sum('bidang_pembimbing.kuota');
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
