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
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bidang');
            $table->text('deskripsi')->nullable();
            $table->enum('jenjang', ['Siswa', 'Mahasiswa']);
            $table->foreignId('pembimbing_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->integer('kapasitas')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
