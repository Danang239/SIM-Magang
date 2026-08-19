<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\PengajuanStatusLog;
use App\Models\User;
use App\Mail\PengajuanDisetujuiMail;
use App\Mail\PengajuanDitolakMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PetugasVerifikasiTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test viewing Petugas dashboard.
     */
    public function test_petugas_dashboard_can_be_rendered(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $response = $this->actingAs($petugas)->get(route('petugas.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Operasional');
    }

    /**
     * Test viewing verification queue list.
     */
    public function test_verifikasi_queue_can_be_rendered(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $response = $this->actingAs($petugas)->get(route('petugas.verifikasi.index'));
        $response->assertStatus(200);
        $response->assertSee('Antrean Verifikasi Berkas');
    }

    /**
     * Test verifikasi approve flow (Setujui).
     */
    public function test_petugas_can_approve_application(): void
    {
        Mail::fake();

        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-555555555555',
            'nomor_pengajuan' => 'PKL-2026-9001',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Larave',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $response = $this->actingAs($petugas)->post(route('petugas.verifikasi.process', $pengajuan->public_id), [
            'action' => 'setujui',
            'catatan' => 'Berkas lengkap.',
        ]);

        $response->assertRedirect(route('petugas.verifikasi.index'));
        
        // Assert status changed to Disetujui
        $this->assertEquals('Disetujui', $pengajuan->fresh()->status);

        // Assert audit log created
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Disetujui',
            'created_by' => $petugas->id,
        ]);

        // Assert in-app notification created
        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $applicant->id,
            'judul' => 'Pembaruan Status Pengajuan',
        ]);

        // Assert mail was queued
        Mail::assertQueued(PengajuanDisetujuiMail::class, function ($mail) use ($applicant) {
            return collect($mail->to)->contains('address', $applicant->email);
        });
    }

    /**
     * Test verification rejection fails if catatan is missing.
     */
    public function test_petugas_cannot_reject_without_catatan(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-666666666666',
            'nomor_pengajuan' => 'PKL-2026-9002',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'React',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $response = $this->actingAs($petugas)->post(route('petugas.verifikasi.process', $pengajuan->public_id), [
            'action' => 'tolak',
            'catatan' => '', // Missing notes
        ]);

        $response->assertSessionHasErrors('catatan');
        $this->assertEquals('Menunggu Verifikasi', $pengajuan->fresh()->status);
    }

    /**
     * Test verification rejection success (Tolak).
     */
    public function test_petugas_can_reject_application_with_catatan(): void
    {
        Mail::fake();

        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-777777777777',
            'nomor_pengajuan' => 'PKL-2026-9003',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Vue',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(4)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $response = $this->actingAs($petugas)->post(route('petugas.verifikasi.process', $pengajuan->public_id), [
            'action' => 'tolak',
            'catatan' => 'Surat pengantar tidak terbaca, mohon unggah file PDF yang jelas.',
        ]);

        $response->assertRedirect(route('petugas.verifikasi.index'));

        // Assert status changed to Ditolak
        $this->assertEquals('Ditolak', $pengajuan->fresh()->status);

        // Assert log entry with comment
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Ditolak',
            'catatan' => 'Surat pengantar tidak terbaca, mohon unggah file PDF yang jelas.',
            'created_by' => $petugas->id,
        ]);

        // Assert mail was queued
        Mail::assertQueued(PengajuanDitolakMail::class, function ($mail) use ($applicant) {
            return $mail->hasTo($applicant->email) && $mail->catatan === 'Surat pengantar tidak terbaca, mohon unggah file PDF yang jelas.';
        });
    }
}
