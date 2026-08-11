<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\User;
use App\Mail\LaporanDiterimaMail;
use App\Mail\LaporanDitolakMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanAkhirReviewTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test user uploads report, petugas reviews it (accepts & rejects).
     */
    public function test_user_upload_report_and_petugas_accepts_review(): void
    {
        Storage::fake('local');
        Mail::fake();

        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application in "Sedang Magang" status
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-555555555555',
            'nomor_pengajuan' => 'PKL-2026-7001',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Laravel Coding',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonths(1)->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(2)->toDateString(),
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // --- Step 1: User uploads final report ---
        $fakePdf = UploadedFile::fake()->create('report.pdf', 500, 'application/pdf');

        $response = $this->actingAs($applicant)->post(route('pengguna.pengajuan.laporan.store', $pengajuan->public_id), [
            'file_laporan_akhir' => $fakePdf,
        ]);

        $response->assertRedirect();
        $this->assertEquals('Menunggu Review', $pengajuan->fresh()->laporan_status);
        $this->assertNotNull($pengajuan->fresh()->file_laporan_akhir);
        Storage::disk('local')->assertExists($pengajuan->fresh()->file_laporan_akhir);

        // Verify staff alert notification
        $this->assertDatabaseHas('notifikasis', [
            'judul' => 'Ulasan Laporan Akhir Baru',
        ]);

        // --- Step 2: Petugas views review queue ---
        $response = $this->actingAs($petugas)->get(route('petugas.review-laporan.index'));
        $response->assertStatus(200);
        $response->assertSee($pengajuan->nomor_pengajuan);

        // --- Step 3: Petugas accepts the report and uploads finish certificate ---
        $fakeCert = UploadedFile::fake()->create('certificate.pdf', 800, 'application/pdf');

        $response = $this->actingAs($petugas)->post(route('petugas.review-laporan.process', $pengajuan->public_id), [
            'action' => 'terima',
            'file_surat_keterangan' => $fakeCert,
        ]);

        $response->assertRedirect(route('petugas.review-laporan.index'));
        $this->assertEquals('Diterima', $pengajuan->fresh()->laporan_status);
        $this->assertEquals('Selesai', $pengajuan->fresh()->status);
        $this->assertNotNull($pengajuan->fresh()->file_surat_keterangan);
        Storage::disk('local')->assertExists($pengajuan->fresh()->file_surat_keterangan);

        // Assert audit trail log for Selesai
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Selesai',
        ]);

        // Assert mail was queued to applicant
        Mail::assertQueued(LaporanDiterimaMail::class, function ($mail) use ($applicant) {
            return $mail->hasTo($applicant->email);
        });
    }

    /**
     * Test Petugas rejects report with revision comments.
     */
    public function test_petugas_can_reject_report_with_revises(): void
    {
        Storage::fake('local');
        Mail::fake();

        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application with pending report review
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-666666666666',
            'nomor_pengajuan' => 'PKL-2026-7002',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Vue',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonths(1)->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(2)->toDateString(),
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat.pdf',
            'file_laporan_akhir' => 'laporan.pdf',
            'laporan_status' => 'Menunggu Review',
        ]);

        // Reject report without reason (validation failure)
        $response = $this->actingAs($petugas)->post(route('petugas.review-laporan.process', $pengajuan->public_id), [
            'action' => 'tolak',
            'catatan' => '',
        ]);
        $response->assertSessionHasErrors('catatan');
        $this->assertEquals('Menunggu Review', $pengajuan->fresh()->laporan_status);

        // Reject report with reason
        $response = $this->actingAs($petugas)->post(route('petugas.review-laporan.process', $pengajuan->public_id), [
            'action' => 'tolak',
            'catatan' => 'Mohon lengkapi bagian kesimpulan.',
        ]);

        $response->assertRedirect(route('petugas.review-laporan.index'));
        $this->assertEquals('Ditolak', $pengajuan->fresh()->laporan_status);
        $this->assertEquals('Sedang Magang', $pengajuan->fresh()->status); // Remains Sedang Magang

        // Assert audit trail log created for rejection comments
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Sedang Magang',
            'catatan' => 'Laporan Akhir DITOLAK. Catatan revisi: Mohon lengkapi bagian kesimpulan.',
        ]);

        // Assert user receives in-app alert
        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $applicant->id,
            'judul' => 'Laporan Akhir Ditangguhkan',
        ]);

        // Assert mail was queued
        Mail::assertQueued(LaporanDitolakMail::class, function ($mail) use ($applicant) {
            return $mail->hasTo($applicant->email) && $mail->catatan === 'Mohon lengkapi bagian kesimpulan.';
        });
    }
}
