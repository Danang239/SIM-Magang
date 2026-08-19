<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareerFormTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test full 2-step wizard career application flow.
     */
    public function test_full_wizard_application_flow(): void
    {
        Storage::fake('local');
        Mail::fake();

        // 1. Authenticate user
        $user = User::factory()->create();
        $user->assignRole('Pengguna');

        // Get an active bidang for testing (from seeded data)
        $bidang = Bidang::where('is_active', true)->where('jenjang', 'Mahasiswa')->first();
        $this->assertNotNull($bidang);

        // Put bidang_id into session to simulate choosing it on home page
        session(['bidang_id' => $bidang->id]);

        // 2. Step 1: Fill duration, skills, and start date
        $tanggalMulai = now()->addDays(15)->toDateString();
        $response = $this->actingAs($user)
            ->post(route('pengguna.career.step1.store'), [
                'durasi_bulan' => 3,
                'keahlian' => 'Keahlian riset tanaman genetika.',
                'tanggal_mulai' => $tanggalMulai,
            ]);

        $response->assertRedirect(route('pengguna.career.step2'));
        $this->assertEquals(3, session('career_step1.durasi_bulan'));
        $this->assertEquals('Keahlian riset tanaman genetika.', session('career_step1.keahlian'));
        $this->assertEquals($tanggalMulai, session('career_step1.tanggal_mulai'));

        // 3. Step 2: Fill personal biodata, upload file and finalize
        $file = UploadedFile::fake()->create('surat_pengantar.pdf', 500, 'application/pdf');
        $fotoDiri = UploadedFile::fake()->image('foto_4x6.jpg', 400, 600);

        $response = $this->actingAs($user)
            ->post(route('pengguna.career.store'), [
                'foto_diri' => $fotoDiri,
                'nik_ktp' => '3271012345678901',
                'no_hp' => '081234567890',
                'instansi' => 'Universitas Indonesia',
                'program_studi' => 'Bioteknologi',
                'nim_nisn' => '1234567890',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2002-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Tentara Pelajar No. 3A, Bogor',
                'nama_pimpinan_instansi' => 'Prof. Dr. Rektor UI',
                'alamat_instansi' => 'Jl. Margonda Raya, Depok',
                'kontak_instansi' => '021-7867222',
                'fakultas' => 'Fakultas Matematika dan IPA',
                'tahun_masuk' => '2022',
                'pendidikan_terakhir' => 'SMA',
                'semester_saat_ini' => 'Semester 5',
                'judul_magang' => 'Analisis Perbanyakan Kultur In Vitro',
                'tujuan_magang' => 'Mempelajari teknik isolasi dan regenerasi planlet',
                'nama_dosen_pembimbing' => 'Dr. Pembimbing Kampus, M.Si',
                'tanda_tangan_digital' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
                'kontak_darurat_nama' => 'Ayah Udin',
                'kontak_darurat_no' => '081234567890',
                'hubungan_kontak_darurat' => 'Orang Tua',
                'file_surat_pengantar' => $file,
                'syarat_ketentuan' => true,
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
            'nim_nisn' => '1234567890',
            'tempat_lahir' => 'Bogor',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Tentara Pelajar No. 3A, Bogor',
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
