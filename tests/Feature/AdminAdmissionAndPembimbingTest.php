<?php

namespace Tests\Feature;

use App\Mail\PengajuanBaruMasukMail;
use App\Mail\PengajuanBerhasilDaftarMail;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAdmissionAndPembimbingTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test Admin can manage Pembimbing master data and quotas.
     */
    public function test_admin_can_crud_pembimbing_master_data(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        // 1. View Pembimbing index
        $response = $this->actingAs($admin)->get(route('admin.pembimbing.index'));
        $response->assertStatus(200);
        $response->assertSee('Kelola Master Pembimbing');

        // 2. Create Pembimbing
        $bidang = Bidang::first() ?? Bidang::create([
            'nama_bidang' => 'Biologi Molekuler',
            'deskripsi' => 'Deskripsi',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Mahasiswa',
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        $responseCreate = $this->actingAs($admin)->post(route('admin.pembimbing.store'), [
            'nama' => 'Dr. Peneliti Utama, M.Si',
            'nip' => '198001012005011001',
            'email' => 'peneliti.utama@biogen.go.id',
            'no_hp' => '081234567899',
            'jabatan' => 'Peneliti Ahli Utama',
            'is_active' => '1',
            'bidang_ids' => [$bidang->id],
        ]);
        $responseCreate->assertRedirect(route('admin.pembimbing.index'));

        $this->assertDatabaseHas('pembimbings', [
            'nama' => 'Dr. Peneliti Utama, M.Si',
        ]);

        $pembimbing = Pembimbing::where('email', 'peneliti.utama@biogen.go.id')->first();
        $this->assertNotNull($pembimbing);
        $this->assertTrue($pembimbing->bidangs->contains($bidang->id));

        // 3. Update Pembimbing
        $responseUpdate = $this->actingAs($admin)->put(route('admin.pembimbing.update', $pembimbing->id), [
            'nama' => 'Dr. Peneliti Utama, M.Si (Updated)',
            'is_active' => '1',
            'bidang_ids' => [$bidang->id],
        ]);
        $responseUpdate->assertRedirect(route('admin.pembimbing.index'));
        $this->assertEquals('Dr. Peneliti Utama, M.Si (Updated)', $pembimbing->fresh()->nama);
    }

    /**
     * Test submission sends dual emails (applicant validation & admin alert).
     */
    public function test_submission_dispatches_dual_emails(): void
    {
        Storage::fake('local');
        Mail::fake();

        $applicant = User::factory()->create(['email' => 'applicant@test.com']);
        $applicant->assignRole('Pengguna');

        $admin = User::where('email', 'admin@biogen.go.id')->first() ?? User::factory()->create(['email' => 'admin.test@biogen.go.id']);
        if (!$admin->hasRole('Administrator')) {
            $admin->assignRole('Administrator');
        }

        $bidang = Bidang::first() ?? Bidang::create([
            'nama_bidang' => 'Biologi Molekuler',
            'deskripsi' => 'Deskripsi',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Mahasiswa',
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        $pembimbing = Pembimbing::first() ?? Pembimbing::create([
            'nama' => 'Dr. Sustiprijatno',
            'email' => 'sustiprijatno@biogen.go.id',
            'kuota_default' => 5,
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->create('pengantar.pdf', 500, 'application/pdf');
        $fotoDiri = UploadedFile::fake()->image('foto.jpg', 400, 600);

        $response = $this->actingAs($applicant)
            ->withSession([
                'bidang_id' => $bidang->id,
                'pembimbing_id' => $pembimbing->id,
                'career_step1' => [
                    'bidang_id' => $bidang->id,
                    'durasi_bulan' => 3,
                    'keahlian' => 'Molecular Biology',
                    'tanggal_mulai' => now()->addDays(14)->toDateString(),
                    'tanggal_selesai_rencana' => now()->addMonths(3)->toDateString(),
                ]
            ])
            ->post(route('pengguna.career.store'), [
                'foto_diri' => $fotoDiri,
                'nik_ktp' => '3271012345678901',
                'no_hp' => '081234567890',
                'instansi' => 'Institut Pertanian Bogor',
                'program_studi' => 'Agronomi',
                'nim_nisn' => 'A1234567',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2002-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Raya Dramaga',
                'nama_pimpinan_instansi' => 'Rektor IPB',
                'alamat_instansi' => 'Kampus IPB Dramaga',
                'kontak_instansi' => '0251-8622642',
                'tahun_masuk' => '2021',
                'pendidikan_terakhir' => 'SMA',
                'semester_saat_ini' => '6',
                'judul_magang' => 'Riset Biogen',
                'tujuan_magang' => 'Belajar riset',
                'nama_dosen_pembimbing' => 'Dosen Pembimbing',
                'pembimbing_id' => $pembimbing->id,
                'tanda_tangan_digital' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
                'kontak_darurat_nama' => 'Orang Tua',
                'kontak_darurat_no' => '08123456789',
                'hubungan_kontak_darurat' => 'Ibu',
                'file_surat_pengantar' => $file,
                'syarat_ketentuan' => true,
            ]);

        $response->assertRedirect();

        // 1. Assert email queued to applicant
        Mail::assertQueued(PengajuanBerhasilDaftarMail::class, function ($mail) {
            return $mail->hasTo('applicant@test.com');
        });

        // 2. Assert email queued to Admin
        Mail::assertQueued(PengajuanBaruMasukMail::class, function ($mail) {
            return $mail->hasTo('admin@biogen.go.id');
        });
    }

    /**
     * Test Admin single-door verification flow.
     */
    public function test_admin_single_door_verification(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $applicant = User::factory()->create();
        $applicant->assignRole('Pengguna');

        $bidang = Bidang::first() ?? Bidang::create([
            'nama_bidang' => 'Biologi Molekuler',
            'deskripsi' => 'Deskripsi',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Mahasiswa',
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        $pembimbing = Pembimbing::first() ?? Pembimbing::create([
            'nama' => 'Dr. Sustiprijatno',
            'email' => 'sustiprijatno@biogen.go.id',
            'kuota_default' => 5,
            'is_active' => true,
        ]);

        $pengajuan = Pengajuan::create([
            'public_id' => \Illuminate\Support\Str::uuid(),
            'nomor_pengajuan' => 'PKL-VERIFY-TEST',
            'user_id' => $applicant->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidang->id,
            'pembimbing_id' => $pembimbing->id,
            'keahlian' => 'Lab testing',
            'durasi_bulan' => 2,
            'tanggal_mulai' => now()->addDays(10)->toDateString(),
            'tanggal_selesai_rencana' => now()->addDays(70)->toDateString(),
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat.pdf',
        ]);

        // 1. Admin views verification page
        $response = $this->actingAs($admin)->get(route('admin.riwayat-pengajuan.show', $pengajuan->public_id));
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Pengajuan Ini');

        // 2. Admin approves with Surat Balasan upload
        $suratBalasan = UploadedFile::fake()->create('surat_balasan.pdf', 300, 'application/pdf');

        $responseApprove = $this->actingAs($admin)->post(route('admin.riwayat-pengajuan.verifikasi', $pengajuan->public_id), [
            'action' => 'setujui',
            'file_surat_balasan' => $suratBalasan,
            'pembimbing_id' => $pembimbing->id,
        ]);

        $responseApprove->assertRedirect(route('admin.riwayat-pengajuan.show', $pengajuan->public_id));
        $this->assertEquals('Disetujui', $pengajuan->fresh()->status);
        $this->assertNotNull($pengajuan->fresh()->file_surat_balasan);
    }
}
