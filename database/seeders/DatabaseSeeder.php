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
            DiscountSeeder::class,
            PromoCodesSeeder::class,
            OrderSeeder::class,
            NotificationSeeder::class,
            FaqSeeder::class,
            TestimonialsSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
