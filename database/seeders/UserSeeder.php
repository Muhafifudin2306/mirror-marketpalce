<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'phone' => '081234567890',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'address' => 'Jl. Mayapada',
                'postal_code' => '13460',
                'role' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@gmail.com',
                'phone' => '081234567892',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'address' => 'Jl. Mayapada',
                'postal_code' => '13460',
                'role' => 'Staff',
                'password' => Hash::make('staff123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'phone' => '081234567891',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'address' => 'Jl. Mayapada',
                'postal_code' => '13460',
                'role' => 'Customer',
                'password' => Hash::make('customer123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hanief Wardhana',
                'email' => 'hanief@gmail.com',
                'phone' => '081234567893',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'address' => 'Jl. Mayapada',
                'postal_code' => '13460',
                'role' => 'Admin',
                'password' => Hash::make('hanief123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muhammad Afifudin',
                'email' => 'afif@gmail.com',
                'phone' => '081234567894',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'address' => 'Jl. Mayapada',
                'postal_code' => '13460',
                'role' => 'Admin',
                'password' => Hash::make('afif12345'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
