<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Masjid;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role sudah ada
        $roles = ['Super Admin','Admin','Produksi'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        // 1. Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('superadmin123'),
            ]
        );
        $superAdmin->syncRoles('Super Admin');

        // 2. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->syncRoles('Admin');

        // 3. Produksi
        $produksi = User::firstOrCreate(
            ['email' => 'produksi@gmail.com'],
            [
                'name'     => 'Produksi',
                'password' => Hash::make('produksi123'),
            ]
        );
        $produksi->syncRoles('Produksi');

        // 4. Hanips (Super Admin juga)
        $hanips = User::firstOrCreate(
            ['email' => 'hanips@gmail.com'],
            [
                'name'     => 'Hanips',
                'password' => Hash::make('hanips123'),
            ]
        );
        $hanips->syncRoles('Super Admin');
    }
}