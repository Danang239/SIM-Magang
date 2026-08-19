<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkmTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test finished user can submit SKM survey.
     */
    public function test_finished_user_can_submit_skm_survey(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application in "Selesai" status
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-555555555555',
            'nomor_pengajuan' => 'PKL-2026-6001',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Lab experiments',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonths(4)->toDateString(),
            'tanggal_selesai_rencana' => now()->subMonths(1)->toDateString(),
            'status' => 'Selesai',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $activeQuestions = SkmPertanyaan::where('is_active', true)->get();
        $this->assertGreaterThan(0, $activeQuestions->count());

        // Construct ratings payload
        $ratings = [];
        foreach ($activeQuestions as $q) {
            $ratings[$q->id] = 5; // Give perfect score
        }

        $response = $this->actingAs($applicant)->post(route('pengguna.pengajuan.skm.store', $pengajuan->public_id), [
            'status_disabilitas' => 'Bukan Penyandang Disabilitas',
            'ratings' => $ratings,
            'saran' => 'Pelayanan administrasi sangat memuaskan.',
        ]);

        $response->assertRedirect();
        
        // Assert ratings saved in database
        foreach ($activeQuestions as $q) {
            $this->assertDatabaseHas('skm_jawaban', [
                'pengajuan_id' => $pengajuan->id,
                'skm_pertanyaan_id' => $q->id,
                'rating' => 5,
            ]);
        }

        // Assert saran saved in pengajuans table
        $this->assertEquals('Pelayanan administrasi sangat memuaskan.', $pengajuan->fresh()->skm_saran);

        // Assert user cannot submit twice
        $response2 = $this->actingAs($applicant)->post(route('pengguna.pengajuan.skm.store', $pengajuan->public_id), [
            'ratings' => $ratings,
            'saran' => 'Mencoba submit lagi.',
        ]);
        $response2->assertSessionHas('error');

        // Assert admin dashboard loads stats without error
        $responseAdmin = $this->actingAs($admin)->get(route('admin.dashboard'));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Analisis Detail Instrumen SKM');
    }

    /**
     * Test user cannot submit SKM if status is not Selesai.
     */
    public function test_user_cannot_submit_skm_if_not_finished(): void
    {
        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first();

        // Create application in "Sedang Magang" status (not finished)
        $pengajuan = Pengajuan::create([
            'public_id' => '11111111-2222-3333-4444-666666666666',
            'nomor_pengajuan' => 'PKL-2026-6002',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Lab experiments',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonths(1)->toDateString(),
            'tanggal_selesai_rencana' => now()->addMonths(2)->toDateString(),
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        $activeQuestions = SkmPertanyaan::where('is_active', true)->get();
        $ratings = [];
        foreach ($activeQuestions as $q) {
            $ratings[$q->id] = 4;
        }

        $response = $this->actingAs($applicant)->post(route('pengguna.pengajuan.skm.store', $pengajuan->public_id), [
            'ratings' => $ratings,
            'saran' => 'Belum selesai tapi mau isi.',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('skm_jawaban', [
            'pengajuan_id' => $pengajuan->id,
        ]);
    }
}
