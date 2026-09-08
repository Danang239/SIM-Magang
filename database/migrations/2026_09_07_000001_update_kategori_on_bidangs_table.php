<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom kategori menjadi string agar fleksibel mendukung kategori Mahasiswa & Siswa
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE bidangs MODIFY COLUMN kategori VARCHAR(50) NOT NULL DEFAULT 'Mahasiswa'");
        } else {
            Schema::table('bidangs', function (Blueprint $table) {
                $table->string('kategori', 50)->default('Mahasiswa')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE bidangs MODIFY COLUMN kategori VARCHAR(50) NOT NULL DEFAULT 'Pertanian'");
        }
    }
};
