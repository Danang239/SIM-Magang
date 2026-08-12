<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApprovalGateTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test filling out SKM and Biodata forms promotes status to Terjadwal.
     */
    public function test_post_approval_gate_promotes_to_terjadwal(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $bidang = Bidang::where('is_active', true)->first();

        // Create an approved application
        $pengajuan = Pengajuan::create([
            'public_id' => \Illuminate\Support\Str::uuid(),
            'nomor_pengajuan' => 'PKL-TEST-' . rand(1000, 9999),
            'user_id' => $user->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Programming',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addDays(10)->toDateString(),
            'tanggal_selesai_rencana' => now()->addDays(100)->toDateString(),
            'status' => 'Disetujui',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // 1. Visit details page, should see the action gate card and locked Biodata button
        $response = $this->actingAs($user)->get(route('pengguna.pengajuan.show', $pengajuan->public_id));
        $response->assertStatus(200);
        $response->assertSee('Lengkapi Persyaratan Magang');
        $response->assertSee('Isi Formulir Biodata (Terkunci)');

        // 1b. Try to access biodata page directly, should redirect back with error
        $response = $this->actingAs($user)->get(route('pengguna.gate.biodata', $pengajuan->id));
        $response->assertRedirect(route('pengguna.pengajuan.show', $pengajuan->public_id));
        $response->assertSessionHas('error');

        // 2. Submit SKM
        $questions = SkmPertanyaan::where('is_active', true)->get();
        $this->assertNotEmpty($questions);
        $skmPayload = [];
        foreach ($questions as $q) {
            $skmPayload[$q->id] = 5;
        }

        $response = $this->actingAs($user)->post(route('pengguna.gate.skm.store', $pengajuan->id), [
            'skm' => $skmPayload,
            'skm_saran' => 'Komentar saya.',
        ]);

        $response->assertRedirect(route('pengguna.pengajuan.show', $pengajuan->public_id));
        $this->assertDatabaseHas('skm_jawaban', [
            'pengajuan_id' => $pengajuan->id,
            'rating' => 5,
        ]);
        $this->assertEquals('Disetujui', $pengajuan->fresh()->status); // Still approved because biodata is missing

        // 2b. Visit details page again, should now see active "Isi Formulir Biodata" link
        $response = $this->actingAs($user)->get(route('pengguna.pengajuan.show', $pengajuan->public_id));
        $response->assertStatus(200);
        $response->assertSee('Isi Formulir Biodata');
        $response->assertDontSee('Isi Formulir Biodata (Terkunci)');

        // 3. Submit Biodata
        $response = $this->actingAs($user)->post(route('pengguna.gate.biodata.store', $pengajuan->id), [
            'nim_nisn' => '1202203001',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2002-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 10',
            'kontak_darurat_nama' => 'Orang Tua',
            'kontak_darurat_no' => '0812345678',
            'hubungan_kontak_darurat' => 'Ayah',
        ]);

        $response->assertRedirect(route('pengguna.pengajuan.show', $pengajuan->public_id));
        $this->assertDatabaseHas('pengajuan_biodatas', [
            'pengajuan_id' => $pengajuan->id,
            'nim_nisn' => '1202203001',
        ]);

        // 4. Assert status promoted to Terjadwal
        $this->assertEquals('Terjadwal', $pengajuan->fresh()->status);

        // Assert log exists
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'Terjadwal',
        ]);
    }
}
