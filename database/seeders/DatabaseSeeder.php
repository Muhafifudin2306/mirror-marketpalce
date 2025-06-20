<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LabelSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            FinishingSeeder::class,
            OrderSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
