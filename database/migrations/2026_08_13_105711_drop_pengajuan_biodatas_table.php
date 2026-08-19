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
        Schema::dropIfExists('pengajuan_biodatas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pengajuan_biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')
                  ->constrained('pengajuans')
                  ->cascadeOnDelete();
            $table->string('nim_nisn');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('kontak_darurat_nama');
            $table->string('kontak_darurat_no');
            $table->string('hubungan_kontak_darurat');
            $table->timestamps();
        });
    }
};
