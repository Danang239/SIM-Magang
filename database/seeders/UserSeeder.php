<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Administrator
        $admin = User::create([
            'name' => 'Admin Biogen',
            'email' => 'admin@biogen.go.id',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'instansi' => 'BRMP Biogen',
        ]);
        $admin->assignRole('Administrator');

        // 2. Petugas 1
        $petugas1 = User::create([
            'name' => 'Petugas Budi',
            'email' => 'budi@biogen.go.id',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'instansi' => 'BRMP Biogen',
        ]);
        $petugas1->assignRole('Petugas');

        // 3. Petugas 2
        $petugas2 = User::create([
            'name' => 'Petugas Susi',
            'email' => 'susi@biogen.go.id',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'instansi' => 'BRMP Biogen',
        ]);
        $petugas2->assignRole('Petugas');

        // 4. Pengguna 1 (Mahasiswa)
        $pengguna1 = User::create([
            'name' => 'Danang Tri',
            'email' => 'danang@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '089876543210',
            'instansi' => 'Universitas Indonesia',
            'program_studi' => 'Bioteknologi',
        ]);
        $pengguna1->assignRole('Pengguna');

        // 5. Pengguna 2 (Siswa)
        $pengguna2 = User::create([
            'name' => 'Ahmad Roni',
            'email' => 'roni@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '089876543211',
            'instansi' => 'SMK Negeri 1 Bogor',
            'program_studi' => 'Agribisnis Tanaman',
        ]);
        $pengguna2->assignRole('Pengguna');
    }
}
