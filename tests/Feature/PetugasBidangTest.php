<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasBidangTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test Petugas can access index.
     */
    public function test_petugas_can_view_bidang_index(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $response = $this->actingAs($petugas)->get(route('petugas.bidang.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Bidang Penempatan');
    }

    /**
     * Test Administrator can access index (superset access).
     */
    public function test_admin_can_view_bidang_index(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $response = $this->actingAs($admin)->get(route('petugas.bidang.index'));
        $response->assertStatus(200);
    }

    /**
     * Test Pengguna role is denied access (403).
     */
    public function test_pengguna_cannot_view_bidang_index(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $response = $this->actingAs($user)->get(route('petugas.bidang.index'));
        $response->assertStatus(403);
    }

    /**
     * Test Petugas can create a new bidang.
     */
    public function test_petugas_can_create_bidang(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $pembimbing = User::factory()->create();
        $pembimbing->assignRole('Petugas');

        $response = $this->actingAs($petugas)->post(route('petugas.bidang.store'), [
            'nama_bidang' => 'Divisi Pemuliaan Genetika',
            'deskripsi' => 'Lab bioteknologi terpadu.',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $pembimbing->id,
            'kapasitas' => 8,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('petugas.bidang.index'));
        $this->assertDatabaseHas('bidangs', [
            'nama_bidang' => 'Divisi Pemuliaan Genetika',
            'kategori' => 'Pertanian',
            'kapasitas' => 8,
            'pembimbing_id' => $pembimbing->id,
        ]);
    }

    /**
     * Test Petugas can edit a bidang.
     */
    public function test_petugas_can_update_bidang(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $bidang = Bidang::first();
        $this->assertNotNull($bidang);

        $response = $this->actingAs($petugas)->put(route('petugas.bidang.update', $bidang->id), [
            'nama_bidang' => 'Nama Baru Bidang',
            'deskripsi' => 'Deskripsi baru.',
            'jenjang' => 'Siswa',
            'kategori' => 'Non Pertanian',
            'pembimbing_id' => $bidang->pembimbing_id,
            'kapasitas' => 12,
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('petugas.bidang.index'));
        $this->assertDatabaseHas('bidangs', [
            'id' => $bidang->id,
            'nama_bidang' => 'Nama Baru Bidang',
            'kapasitas' => 12,
            'is_active' => 0,
        ]);
    }

    /**
     * Test Petugas can delete a bidang with no associated applications.
     */
    public function test_petugas_can_delete_unused_bidang(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        // Create a new unused bidang
        $bidang = Bidang::create([
            'nama_bidang' => 'Bidang Sementara',
            'deskripsi' => 'Akan segera dihapus.',
            'jenjang' => 'Siswa',
            'kapasitas' => 5,
            'is_active' => 1,
        ]);

        $response = $this->actingAs($petugas)->delete(route('petugas.bidang.destroy', $bidang->id));
        $response->assertRedirect(route('petugas.bidang.index'));
        
        $this->assertDatabaseMissing('bidangs', [
            'id' => $bidang->id,
        ]);
    }

    /**
     * Test Petugas cannot delete a bidang with associated applications.
     */
    public function test_petugas_cannot_delete_used_bidang(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $bidang = Bidang::first();
        $user = User::factory()->create();

        // Create an application linked to this bidang
        $pengajuan = Pengajuan::create([
            'public_id' => '22222222-3333-4444-5555-666666666666',
            'nomor_pengajuan' => 'PKL-2026-8801',
            'user_id' => $user->id,
            'jenjang' => $bidang->jenjang,
            'bidang_id' => $bidang->id,
            'keahlian' => 'Lab skill',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $response = $this->actingAs($petugas)->from(route('petugas.bidang.index'))->delete(route('petugas.bidang.destroy', $bidang->id));
        $response->assertRedirect(route('petugas.bidang.index'));
        $response->assertSessionHas('error');

        // Bidang should still exist
        $this->assertDatabaseHas('bidangs', [
            'id' => $bidang->id,
        ]);
    }
}
