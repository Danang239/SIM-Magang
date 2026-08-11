<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('nomor_pengajuan')->unique();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->enum('jenjang', ['Siswa', 'Mahasiswa']);
            $table->foreignId('bidang_id')
                  ->constrained('bidangs')
                  ->restrictOnDelete();
            $table->text('keahlian');
            $table->integer('durasi_bulan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai_rencana');
            $table->enum('status', [
                'Menunggu Verifikasi',
                'Disetujui',
                'Ditolak',
                'Terjadwal',
                'Sedang Magang',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu Verifikasi');
            $table->text('catatan_petugas')->nullable();
            $table->string('file_surat_pengantar');
            $table->string('file_laporan_akhir')->nullable();
            $table->enum('laporan_status', [
                'Belum Ada',
                'Menunggu Review',
                'Diterima',
                'Ditolak'
            ])->default('Belum Ada')->nullable();
            $table->string('file_surat_keterangan')->nullable();
            $table->text('skm_saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
