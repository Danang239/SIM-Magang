<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'no_hp', 'instansi', 'program_studi', 'foto_profil', 'google_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Pengajuan (User punya banyak Pengajuan).
     */
    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }

    /**
     * Relasi ke Notifikasi (User punya banyak Notifikasi).
     */
    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Relasi ke Bidang sebagai Pembimbing (Petugas membimbing banyak Bidang).
     */
    public function bidangs(): HasMany
    {
        return $this->hasMany(Bidang::class, 'pembimbing_id');
    }

    /**
     * Relasi ke Multi-Bidang Bimbingan (Many-to-Many via bidang_petugas pivot).
     */
    public function bidangBimbingan(): BelongsToMany
    {
        return $this->belongsToMany(Bidang::class, 'bidang_petugas', 'petugas_id', 'bidang_id')
            ->withPivot('kuota')
            ->withTimestamps();
    }

    /**
     * Relasi ke Pengajuan yang dibimbing oleh Petugas ini.
     */
    public function pengajuanBimbingan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'pembimbing_id');
    }
}
