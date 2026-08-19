<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'public_id',
    'nomor_pengajuan',
    'user_id',
    'jenjang',
    'bidang_id',
    'keahlian',
    'durasi_bulan',
    'tanggal_mulai',
    'tanggal_selesai_rencana',
    'status',
    'catatan_petugas',
    'file_surat_pengantar',
    'file_laporan_akhir',
    'laporan_status',
    'file_surat_keterangan',
    'skm_saran',
    'nim_nisn',
    'tempat_lahir',
    'tanggal_lahir',
    'jenis_kelamin',
    'alamat',
    'kontak_darurat_nama',
    'kontak_darurat_no',
    'hubungan_kontak_darurat',
    'file_surat_balasan',
    'foto_diri',
    'nik_ktp',
    'nama_pimpinan_instansi',
    'alamat_instansi',
    'kontak_instansi',
    'fakultas',
    'tahun_masuk',
    'pendidikan_terakhir',
    'semester_saat_ini',
    'judul_magang',
    'tujuan_magang',
    'nama_dosen_pembimbing',
    'tanda_tangan_digital',
    'pembimbing_id',
    'status_disabilitas'
])]
class Pengajuan extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai_rencana' => 'date',
            'durasi_bulan' => 'integer',
        ];
    }

    /**
     * Relasi ke User (Pemohon).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Pembimbing (Petugas yang dipilih untuk membimbing pengajuan ini).
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    /**
     * Relasi ke Bidang.
     */
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    /**
     * Relasi ke PengajuanStatusLog.
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(PengajuanStatusLog::class);
    }

    /**
     * Relasi ke SkmJawaban.
     */
    public function skmJawabans(): HasMany
    {
        return $this->hasMany(SkmJawaban::class);
    }

    /**
     * Cek apakah formulir biodata dan SKM sudah selesai diisi.
     */
    public function isGateCompleted(): bool
    {
        $skmQuestionsCount = \App\Models\SkmPertanyaan::where('is_active', true)->count();
        $skmAnsweredCount = $this->skmJawabans()->count();

        $skmCompleted = ($skmAnsweredCount >= $skmQuestionsCount && $skmQuestionsCount > 0);

        return $skmCompleted;
    }
}
