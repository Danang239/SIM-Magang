<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTahunanExportTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test Admin can export the PDF report.
     */
    public function test_admin_can_export_laporan_tahunan_pdf(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $response = $this->actingAs($admin)->get(route('admin.laporan-tahunan.export', ['year' => 2026]));
        
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition', 'attachment; filename=Laporan_Rekapitulasi_Tahunan_Magang_2026.pdf');
    }

    /**
     * Test Petugas cannot export the PDF report.
     */
    public function test_petugas_cannot_export_laporan_tahunan_pdf(): void
    {
        $petugas = User::factory()->create();
        $petugas->assignRole('Petugas');

        $response = $this->actingAs($petugas)->get(route('admin.laporan-tahunan.export', ['year' => 2026]));
        $response->assertStatus(403);
    }

    /**
     * Test Pengguna cannot export the PDF report.
     */
    public function test_pengguna_cannot_export_laporan_tahunan_pdf(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        $response = $this->actingAs($user)->get(route('admin.laporan-tahunan.export', ['year' => 2026]));
        $response->assertStatus(403);
    }
}
