<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['teks_pertanyaan', 'urutan', 'is_active'])]
class SkmPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'skm_pertanyaan';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    /**
     * Relasi ke SkmJawaban.
     */
    public function skmJawabans(): HasMany
    {
        return $this->hasMany(SkmJawaban::class, 'skm_pertanyaan_id');
    }
}
