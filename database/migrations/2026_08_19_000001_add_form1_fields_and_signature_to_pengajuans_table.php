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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('foto_diri')->nullable()->after('user_id');
            $table->string('nik_ktp')->nullable()->after('nim_nisn');
            $table->string('nama_pimpinan_instansi')->nullable()->after('hubungan_kontak_darurat');
            $table->text('alamat_instansi')->nullable()->after('nama_pimpinan_instansi');
            $table->string('kontak_instansi')->nullable()->after('alamat_instansi');
            $table->string('fakultas')->nullable()->after('kontak_instansi');
            $table->string('tahun_masuk')->nullable()->after('fakultas');
            $table->string('pendidikan_terakhir')->nullable()->after('tahun_masuk');
            $table->string('semester_saat_ini')->nullable()->after('pendidikan_terakhir');
            $table->string('judul_magang')->nullable()->after('semester_saat_ini');
            $table->text('tujuan_magang')->nullable()->after('judul_magang');
            $table->string('nama_dosen_pembimbing')->nullable()->after('tujuan_magang');
            $table->longText('tanda_tangan_digital')->nullable()->after('nama_dosen_pembimbing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
