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
        // 1. Create pembimbings table
        Schema::create('pembimbings', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('kuota_default')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Create bidang_pembimbing pivot table
        Schema::create('bidang_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')
                  ->constrained('bidangs')
                  ->cascadeOnDelete();
            $table->foreignId('pembimbing_id')
                  ->constrained('pembimbings')
                  ->cascadeOnDelete();
            $table->integer('kuota')->default(5);
            $table->timestamps();

            $table->unique(['bidang_id', 'pembimbing_id']);
        });

        // 3. Migrate data from old Petugas users into pembimbings
        $userMap = []; // old_user_id => new_pembimbing_id
        
        // Find users with role Petugas or referenced in bidang_petugas
        $petugasUsers = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereColumn('model_has_roles.model_id', 'users.id')
                    ->where('roles.name', 'Petugas');
            })
            ->orWhereExists(function ($query) {
                if (Schema::hasTable('bidang_petugas')) {
                    $query->select(DB::raw(1))
                        ->from('bidang_petugas')
                        ->whereColumn('bidang_petugas.petugas_id', 'users.id');
                }
            })
            ->get();

        foreach ($petugasUsers as $pUser) {
            $pembimbingId = DB::table('pembimbings')->insertGetId([
                'nama' => $pUser->name,
                'email' => $pUser->email,
                'no_hp' => $pUser->no_hp ?? null,
                'jabatan' => 'Pembimbing Lapangan / Peneliti',
                'kuota_default' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $userMap[$pUser->id] = $pembimbingId;
        }

        // If no pembimbing migrated yet, seed default default pembimbing
        if (empty($userMap)) {
            $defaultPembimbing = [
                ['nama' => 'Dr. Ir. Mastur, M.Si.', 'email' => 'mastur@biogen.go.id', 'jabatan' => 'Peneliti Utama'],
                ['nama' => 'Dr. Sustiprijatno, M.Si.', 'email' => 'sustiprijatno@biogen.go.id', 'jabatan' => 'Peneliti Madya'],
                ['nama' => 'Dr. Ika Roostika, S.P., M.Si.', 'email' => 'ika.roostika@biogen.go.id', 'jabatan' => 'Peneliti Madya'],
            ];
            foreach ($defaultPembimbing as $dp) {
                DB::table('pembimbings')->insert([
                    'nama' => $dp['nama'],
                    'email' => $dp['email'],
                    'jabatan' => $dp['jabatan'],
                    'kuota_default' => 5,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Migrate old bidang_petugas to bidang_pembimbing
        if (Schema::hasTable('bidang_petugas')) {
            $oldPivots = DB::table('bidang_petugas')->get();
            foreach ($oldPivots as $pivot) {
                if (isset($userMap[$pivot->petugas_id])) {
                    DB::table('bidang_pembimbing')->updateOrInsert(
                        [
                            'bidang_id' => $pivot->bidang_id,
                            'pembimbing_id' => $userMap[$pivot->petugas_id],
                        ],
                        [
                            'kuota' => $pivot->kuota ?? 5,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }

        // Link all existing bidangs to at least all active pembimbings if empty
        $pembimbingIds = DB::table('pembimbings')->pluck('id')->toArray();
        $bidangIds = DB::table('bidangs')->pluck('id')->toArray();
        foreach ($bidangIds as $bId) {
            $hasPivot = DB::table('bidang_pembimbing')->where('bidang_id', $bId)->exists();
            if (!$hasPivot && count($pembimbingIds) > 0) {
                foreach ($pembimbingIds as $pId) {
                    DB::table('bidang_pembimbing')->updateOrInsert(
                        ['bidang_id' => $bId, 'pembimbing_id' => $pId],
                        ['kuota' => 5, 'created_at' => now(), 'updated_at' => now()]
                    );
                }
            }
        }

        // 5. Update pengajuans table foreign key
        Schema::table('pengajuans', function (Blueprint $table) {
            // Drop foreign key if exists
            try {
                $table->dropForeign(['pembimbing_id']);
            } catch (\Exception $e) {
                // Ignore if not exists
            }
        });

        // Remap pengajuans.pembimbing_id
        foreach ($userMap as $oldUserId => $newPembimbingId) {
            DB::table('pengajuans')
                ->where('pembimbing_id', $oldUserId)
                ->update(['pembimbing_id' => $newPembimbingId]);
        }

        Schema::table('pengajuans', function (Blueprint $table) {
            $table->foreign('pembimbing_id')
                  ->references('id')
                  ->on('pembimbings')
                  ->nullOnDelete();
        });

        // 6. Drop old bidang_petugas table
        Schema::dropIfExists('bidang_petugas');

        // 7. Remove Petugas role & its role assignments from Spatie tables
        $petugasRole = DB::table('roles')->where('name', 'Petugas')->first();
        if ($petugasRole) {
            DB::table('model_has_roles')->where('role_id', $petugasRole->id)->delete();
            DB::table('role_has_permissions')->where('role_id', $petugasRole->id)->delete();
            DB::table('roles')->where('id', $petugasRole->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['pembimbing_id']);
        });

        Schema::dropIfExists('bidang_pembimbing');
        Schema::dropIfExists('pembimbings');
    }
};
