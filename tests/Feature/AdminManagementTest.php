<?php

namespace Tests\Feature;

use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test Administrator has full access to user management, SKM CRUD, and exports.
     */
    public function test_admin_has_full_management_access(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        // 1. User index page load
        $response = $this->actingAs($admin)->get(route('admin.user.index'));
        $response->assertStatus(200);
        $response->assertSee('Kelola Pengguna');

        // 2. Create new Petugas account
        $responseCreate = $this->actingAs($admin)->post(route('admin.user.store'), [
            'name' => 'Petugas Baru',
            'email' => 'new.petugas@mail.com',
            'no_hp' => '0812345678912',
            'instansi' => 'BB-Biogen',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $responseCreate->assertRedirect(route('admin.user.index'));
        
        $newPetugas = User::where('email', 'new.petugas@mail.com')->first();
        $this->assertNotNull($newPetugas);
        $this->assertTrue($newPetugas->hasRole('Petugas'));

        // 3. Edit user info & change role
        $responseEdit = $this->actingAs($admin)->put(route('admin.user.update', $newPetugas->id), [
            'name' => 'Petugas Diedit',
            'email' => 'new.petugas@mail.com',
            'no_hp' => '0812345678912',
            'instansi' => 'Unit Pelayanan Standardisasi',
            'role' => 'Administrator', // Upgrade to Admin
        ]);
        $responseEdit->assertRedirect(route('admin.user.index'));
        $this->assertTrue($newPetugas->fresh()->hasRole('Administrator'));
        $this->assertEquals('Unit Pelayanan Standardisasi', $newPetugas->fresh()->instansi);

        // 4. Delete user
        $responseDelete = $this->actingAs($admin)->delete(route('admin.user.destroy', $newPetugas->id));
        $responseDelete->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseMissing('users', ['id' => $newPetugas->id]);

        // 5. SKM Questions CRUD
        $responseSkmIndex = $this->actingAs($admin)->get(route('admin.skm-pertanyaan.index'));
        $responseSkmIndex->assertStatus(200);

        // Create SKM Question
        $responseSkmCreate = $this->actingAs($admin)->post(route('admin.skm-pertanyaan.store'), [
            'teks_pertanyaan' => 'Apakah sarana laboratorium sangat memadai?',
            'urutan' => 15,
            'is_active' => 1,
        ]);
        $responseSkmCreate->assertRedirect(route('admin.skm-pertanyaan.index'));
        $this->assertDatabaseHas('skm_pertanyaan', [
            'teks_pertanyaan' => 'Apakah sarana laboratorium sangat memadai?',
            'urutan' => 15,
        ]);

        $question = SkmPertanyaan::where('urutan', 15)->first();

        // Update SKM Question
        $responseSkmUpdate = $this->actingAs($admin)->put(route('admin.skm-pertanyaan.update', $question->id), [
            'teks_pertanyaan' => 'Apakah sarana laboratorium modern and sangat memadai?',
            'urutan' => 15,
            'is_active' => 0, // deactivate
        ]);
        $responseSkmUpdate->assertRedirect(route('admin.skm-pertanyaan.index'));
        $this->assertEquals(0, $question->fresh()->is_active);

        // Delete SKM Question
        $responseSkmDelete = $this->actingAs($admin)->delete(route('admin.skm-pertanyaan.destroy', $question->id));
        $responseSkmDelete->assertRedirect(route('admin.skm-pertanyaan.index'));
        $this->assertDatabaseMissing('skm_pertanyaan', ['id' => $question->id]);

        // 6. Excel & CSV Exports
        $responseExcel = $this->actingAs($admin)->get(route('admin.laporan.excel', ['year' => 2026]));
        $responseExcel->assertStatus(200);
        $responseExcel->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $responseCsv = $this->actingAs($admin)->get(route('admin.laporan.csv', ['year' => 2026]));
        $responseCsv->assertStatus(200);
        $responseCsv->assertHeader('content-type', 'text/csv; charset=utf-8');
    }

    /**
     * Test Non-Admin cannot access Administrator routes.
     */
    public function test_non_admin_is_forbidden(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        // Cannot view user listing
        $response = $this->actingAs($user)->get(route('admin.user.index'));
        $response->assertStatus(403);

        // Cannot view SKM configuration
        $responseSkm = $this->actingAs($user)->get(route('admin.skm-pertanyaan.index'));
        $responseSkm->assertStatus(403);

        // Cannot download Excel stats report
        $responseExcel = $this->actingAs($user)->get(route('admin.laporan.excel', ['year' => 2026]));
        $responseExcel->assertStatus(403);
    }
}
