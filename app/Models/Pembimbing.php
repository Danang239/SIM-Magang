<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'email',
        'no_hp',
        'jabatan',
        'kuota_default',
        'is_active',
    ];

    protected $casts = [
        'kuota_default' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Bidang yang dibimbing oleh pembimbing ini.
     */
    public function bidangs(): BelongsToMany
    {
        return $this->belongsToMany(Bidang::class, 'bidang_pembimbing')
                    ->withPivot('kuota')
                    ->withTimestamps();
    }

    /**
     * Pengajuan magang yang dibimbing oleh pembimbing ini.
     */
    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'pembimbing_id');
    }

    /**
     * Accessor alias for name.
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['nama'] ?? '';
    }
}
