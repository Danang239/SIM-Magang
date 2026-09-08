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
        if (User::count() > 0) {
            return;
        }

        // 1. Administrator
        $admin = User::create([
            'name' => 'Admin Biogen',
            'email' => 'admin@biogen.go.id',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'instansi' => 'BRMP Biogen',
        ]);
        $admin->assignRole('Administrator');

        // 2. Pengguna 1 (Mahasiswa)
        $pengguna1 = User::create([
            'name' => 'Danang Tri',
            'email' => 'danang@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '089876543210',
            'instansi' => 'Universitas Indonesia',
            'program_studi' => 'Bioteknologi',
        ]);
        $pengguna1->assignRole('Pengguna');

        // 3. Pengguna 2 (Siswa)
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
