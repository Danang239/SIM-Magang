<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PenggunaDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test displaying the dashboard.
     */
    public function test_dashboard_redirects_to_home(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $response = $this->actingAs($user)->get(route('pengguna.dashboard'));
        $response->assertRedirect(route('home'));
    }

    public function test_home_page_displays_laboratorium_cards(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Bidang PKL');
        $response->assertSee('Kategori Mahasiswa');
    }

    /**
     * Test riwayat page renders for pengguna and shows only their own data.
     */
    public function test_riwayat_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $response = $this->actingAs($user)->get(route('pengguna.riwayat'));
        $response->assertStatus(200);
        $response->assertSee('Riwayat Pengajuan');
    }

    /**
     * Test secure UUID details view and IDOR check.
     */
    public function test_detail_view_idor_protection(): void
    {
        $user1 = User::factory()->create();
        $user1->assignRole('Pengguna');

        $user2 = User::factory()->create();
        $user2->assignRole('Pengguna');

        $bidang = Bidang::first();
        $pengajuan1 = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-111111111111',
            'nomor_pengajuan' => 'PKL-2026-9901',
            'user_id' => $user1->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Skill A',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // User1 should be able to view their own pengajuan
        $response = $this->actingAs($user1)->get(route('pengguna.pengajuan.show', $pengajuan1->public_id));
        $response->assertStatus(200);
        $response->assertSee($pengajuan1->nomor_pengajuan);

        // User2 should NOT be able to view User1's pengajuan (fails with 404 or 403)
        $response = $this->actingAs($user2)->get(route('pengguna.pengajuan.show', $pengajuan1->public_id));
        $response->assertStatus(404);
    }

    /**
     * Test secure document download permissions.
     */
    public function test_secure_file_download_permissions(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('private-surat.pdf', 'dummy content');

        $user1 = User::factory()->create();
        $user1->assignRole('Pengguna');

        $user2 = User::factory()->create();
        $user2->assignRole('Pengguna');

        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $bidang = Bidang::first();
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-222222222222',
            'nomor_pengajuan' => 'PKL-2026-9902',
            'user_id' => $user1->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Skill B',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'private-surat.pdf',
        ]);

        // Owner (user1) can download
        $response = $this->actingAs($user1)->get(route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']));
        $response->assertStatus(200);

        // Other user (user2) cannot download
        $response = $this->actingAs($user2)->get(route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']));
        $response->assertStatus(403);

        // Administrator can download
        $response = $this->actingAs($admin)->get(route('pengajuan.file', [$pengajuan->public_id, 'surat_pengantar']));
        $response->assertStatus(200);
    }

    /**
     * Test self-cancellation.
     */
    public function test_user_can_cancel_their_own_application(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $bidang = Bidang::first();
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-333333333333',
            'nomor_pengajuan' => 'PKL-2026-9903',
            'user_id' => $user->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Skill C',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $response = $this->actingAs($user)->post(route('pengguna.pengajuan.cancel', $pengajuan->public_id));
        $response->assertRedirect(route('pengguna.pengajuan.show', $pengajuan->public_id));
        
        $this->assertEquals('Dibatalkan', $pengajuan->fresh()->status);
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Dibatalkan',
            'catatan' => 'Dibatalkan secara mandiri oleh pemohon.',
        ]);
    }

    /**
     * Test custom profile details updates.
     */
    public function test_user_can_update_profile_with_custom_fields(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'no_hp' => '08111111111',
            'instansi' => 'IPB',
            'program_studi' => 'Agronomi',
        ]);

        $avatar = UploadedFile::fake()->image('avatar.jpg', 300, 300);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => $user->email,
            'no_hp' => '08222222222',
            'instansi' => 'UGM',
            'program_studi' => 'Teknologi Informasi',
            'foto_profil' => $avatar,
        ]);

        $response->assertRedirect(route('profile.edit'));
        
        $user = $user->fresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('08222222222', $user->no_hp);
        $this->assertEquals('UGM', $user->instansi);
        $this->assertEquals('Teknologi Informasi', $user->program_studi);
        $this->assertNotNull($user->foto_profil);

        Storage::disk('public')->assertExists($user->foto_profil);
    }
}
