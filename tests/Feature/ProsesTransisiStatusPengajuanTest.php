<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\User;
use App\Mail\ReminderLaporanTelatMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Tests\TestCase;

class ProsesTransisiStatusPengajuanTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test full automated status transitions.
     */
    public function test_automated_status_transitions(): void
    {
        Mail::fake();

        $user1 = User::factory()->create();
        $user1->assignRole('Pengguna');

        $user2 = User::factory()->create();
        $user2->assignRole('Pengguna');

        $user3 = User::factory()->create();
        $user3->assignRole('Pengguna');

        $bidang = Bidang::first();

        // 1. Application that is Approved (Disetujui) should transition to Terjadwal
        $pApproved = Pengajuan::create([
            'public_id' => '11111111-1111-1111-1111-111111111111',
            'nomor_pengajuan' => 'PKL-2026-8001',
            'user_id' => $user1->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'PHP',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->addDays(5)->toDateString(), // Future
            'tanggal_selesai_rencana' => now()->addMonths(3)->toDateString(),
            'status' => 'Disetujui',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // 2. Application that is Scheduled (Terjadwal) with start date reached today/past should transition to Sedang Magang
        $pScheduled = Pengajuan::create([
            'public_id' => '22222222-2222-2222-2222-222222222222',
            'nomor_pengajuan' => 'PKL-2026-8002',
            'user_id' => $user2->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Ruby',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subDays(1)->toDateString(), // Passed/Reached today
            'tanggal_selesai_rencana' => now()->addMonths(3)->toDateString(),
            'status' => 'Terjadwal',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // 3. Application that is active (Sedang Magang) but finished date passed and no report submitted -> triggers reminder email
        $pOverdue = Pengajuan::create([
            'public_id' => '33333333-3333-3333-3333-333333333333',
            'nomor_pengajuan' => 'PKL-2026-8003',
            'user_id' => $user3->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'keahlian' => 'Python',
            'durasi_bulan' => 3,
            'tanggal_mulai' => now()->subMonths(4)->toDateString(),
            'tanggal_selesai_rencana' => now()->subDays(2)->toDateString(), // Past end date
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat.pdf',
            'laporan_status' => null, // No report uploaded
        ]);

        // Run the command
        $exitCode = Artisan::call('app:proses-transisi-status-pengajuan');
        $this->assertEquals(0, $exitCode);

        // Assert 1: Disetujui became Terjadwal
        $this->assertEquals('Terjadwal', $pApproved->fresh()->status);
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pApproved->id,
            'status' => 'Terjadwal',
        ]);

        // Assert 2: Terjadwal became Sedang Magang
        $this->assertEquals('Sedang Magang', $pScheduled->fresh()->status);
        $this->assertDatabaseHas('pengajuan_status_logs', [
            'pengajuan_id' => $pScheduled->id,
            'status' => 'Sedang Magang',
        ]);

        // Assert 3: Reminder email queued for user 3
        Mail::assertQueued(ReminderLaporanTelatMail::class, function ($mail) use ($user3) {
            return $mail->hasTo($user3->email);
        });
    }
}
