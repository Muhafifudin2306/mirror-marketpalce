<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-dashboard',

            'view-product',
            'create-product',
            'edit-product',
            'delete-product',

            'view-order',
            'create-order',
            'edit-order',
            'delete-order',
            'export-order',

            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'export-user',

            'role-management',
            'role-manipulation',
            'user-management',
            'user-manipulation'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
    }
}