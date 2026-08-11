<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareerFormTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test full 4-step wizard career application flow.
     */
    public function test_full_wizard_application_flow(): void
    {
        Storage::fake('local');

        // 1. Authenticate user
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        // Get an active bidang for testing (from seeded data)
        $bidang = Bidang::where('is_active', true)->where('jenjang', 'Mahasiswa')->first();
        $this->assertNotNull($bidang);

        // 2. Step 1: Choose Jenjang (Mahasiswa)
        $response = $this->actingAs($user)
            ->post(route('pengguna.career.step1.store'), [
                'jenjang' => 'Mahasiswa',
            ]);

        $response->assertRedirect(route('pengguna.career.step2'));
        $this->assertEquals('Mahasiswa', session('career_step1.jenjang'));

        // 3. Step 2: Choose Kategori (Pertanian)
        $response = $this->actingAs($user)
            ->post(route('pengguna.career.step2.store'), [
                'kategori' => 'Pertanian',
            ]);

        $response->assertRedirect(route('pengguna.career.step3'));
        $this->assertEquals('Pertanian', session('career_step2.kategori'));

        // 4. Step 3: Choose Bidang
        $response = $this->actingAs($user)
            ->post(route('pengguna.career.step3.store'), [
                'jenjang' => 'Mahasiswa',
                'bidang_id' => $bidang->id,
                'durasi_bulan' => 3,
                'keahlian' => 'Keahlian riset tanaman genetika.',
            ]);

        $response->assertRedirect(route('pengguna.career.step4'));
        $this->assertEquals($bidang->id, session('career_step3.bidang_id'));
        $this->assertEquals(3, session('career_step3.durasi_bulan'));

        // 5. Step 4: Choose Date (e.g. tomorrow)
        $tanggalMulai = now()->addDays(2)->toDateString();
        $response = $this->actingAs($user)
            ->post(route('pengguna.career.step4.store'), [
                'tanggal_mulai' => $tanggalMulai,
            ]);

        $response->assertRedirect(route('pengguna.career.step5'));
        $this->assertEquals($tanggalMulai, session('career_step4.tanggal_mulai'));

        // Get questions for step 5
        $skmQuestions = SkmPertanyaan::where('is_active', true)->get();
        $skmAnswers = [];
        foreach ($skmQuestions as $q) {
            $skmAnswers[$q->id] = 5; // Very Satisfied
        }

        // 6. Step 5: Finalize with SKM & file upload
        $file = UploadedFile::fake()->create('surat_pengantar.pdf', 500, 'application/pdf');

        $response = $this->actingAs($user)
            ->post(route('pengguna.career.store'), [
                'skm' => $skmAnswers,
                'skm_saran' => 'Layanan yang sangat cepat dan profesional.',
                'file_surat_pengantar' => $file,
            ]);

        // Should redirect to konfirmasi
        $response->assertRedirect();
        
        // Assert database values
        $this->assertDatabaseHas('pengajuans', [
            'user_id' => $user->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'durasi_bulan' => 3,
            'status' => 'Menunggu Verifikasi',
            'skm_saran' => 'Layanan yang sangat cepat dan profesional.',
        ]);

        $pengajuan = \App\Models\Pengajuan::where('user_id', $user->id)->first();
        $this->assertNotNull($pengajuan);
        
        // Assert file exists on private storage
        Storage::disk('local')->assertExists($pengajuan->file_surat_pengantar);

        // Assert log entry
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Menunggu Verifikasi',
        ]);
    }
}
