<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test IDOR Protection on private files download.
     */
    public function test_idor_protection_on_private_files(): void
    {
        Storage::fake('local');

        $userA = User::factory()->create();
        $userA->assignRole('Pengguna');

        $userB = User::factory()->create();
        $userB->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application for User A
        $pathA = Storage::disk('local')->putFile('surat-pengantar', UploadedFile::fake()->create('surat.pdf', 100));

        $pengajuanA = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-55555555555a',
            'nomor_pengajuan' => 'PKL-2026-7001',
            'user_id' => $userA->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'IT',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => $pathA,
        ]);

        // User B tries to download User A's file -> Forbidden (403)
        $response = $this->actingAs($userB)->get(route('pengajuan.file', [
            'public_id' => $pengajuanA->public_id,
            'type' => 'surat_pengantar'
        ]));
        $response->assertStatus(403);

        // User A can download their own file -> OK (200)
        $responseSuccess = $this->actingAs($userA)->get(route('pengajuan.file', [
            'public_id' => $pengajuanA->public_id,
            'type' => 'surat_pengantar'
        ]));
        $responseSuccess->assertStatus(200);
    }

    /**
     * Test MIME Sniffing check rejects malicious fake PDF extension.
     */
    public function test_mime_sniffing_rejects_fake_pdf(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application in "Sedang Magang" status
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-66666666666b',
            'nomor_pengajuan' => 'PKL-2026-7002',
            'user_id' => $user->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'IT',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(2)->toDateString(),
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // Upload fake PDF containing text (which guesser sniffs as text/plain, not application/pdf)
        $fakePdfFile = UploadedFile::fake()->create('malicious.pdf', 100, 'text/plain');

        $response = $this->actingAs($user)->post(route('pengguna.pengajuan.laporan.store', $pengajuan->public_id), [
            'file_laporan_akhir' => $fakePdfFile,
        ]);

        $response->assertSessionHasErrors(['file_laporan_akhir']);
        $this->assertDatabaseMissing('pengajuans', [
            'id' => $pengajuan->id,
            'laporan_status' => 'Menunggu Review',
        ]);
    }

    /**
     * Test Login rate limiting blocks after 5 requests.
     */
    public function test_login_rate_limiting(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'wrong.user@mail.com',
                'password' => 'wrong-pass',
            ]);
            $response->assertStatus(302); // Redirect back with error
        }

        // 6th attempt should be rate limited -> 429 Too Many Requests
        $responseLimit = $this->post('/login', [
            'email' => 'wrong.user@mail.com',
            'password' => 'wrong-pass',
        ]);
        $responseLimit->assertStatus(429);
    }
}
