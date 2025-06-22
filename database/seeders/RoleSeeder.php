<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $super = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $produksi = Role::firstOrCreate(['name' => 'Produksi']);

        $allPerms = Permission::all()->pluck('name')->toArray();

        $super->syncPermissions($allPerms);

        $adminPerms = [
            'view-product',
            'create-product',
            'edit-product',

            'view-order',
            'create-order',
            'edit-order',
            'export-order',

            'view-user',
            'create-user',
            'edit-user',
            'export-user',
        ];
        $admin->syncPermissions($adminPerms);

        $produksiPerms = [
            'view-product',
            'create-product',
            'edit-product',
            'view-order',
            'create-order',
            'edit-order',
        ];
        $produksi->syncPermissions($produksiPerms);
    }
}