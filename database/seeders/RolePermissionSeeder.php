<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'kelola bidang',
            'kelola pembimbing',
            'verifikasi pengajuan',
            'kelola pengguna',
            'kelola skm',
            'lihat laporan tahunan',
            'akses dashboard admin',
            'akses dashboard pengguna',
            'buat pengajuan',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create Roles and Assign Permissions
        $admin = Role::findOrCreate('Administrator');
        $admin->givePermissionTo(Permission::all());

        $pengguna = Role::findOrCreate('Pengguna');
        $pengguna->givePermissionTo([
            'akses dashboard pengguna',
            'buat pengajuan',
        ]);
    }
}
