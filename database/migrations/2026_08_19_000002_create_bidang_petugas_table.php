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
        Schema::create('bidang_petugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')
                  ->constrained('bidangs')
                  ->cascadeOnDelete();
            $table->foreignId('petugas_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->integer('kuota')->default(5);
            $table->timestamps();

            $table->unique(['bidang_id', 'petugas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_petugas');
    }
};
