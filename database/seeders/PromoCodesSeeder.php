<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PromoCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            PromoCode::create([
                'code' => "PROMO10{$i}",
                'discount_percent' => $i * 5,
                'discount_fix' => null,
                'max_discount' => 50000.00,
                'start_at' => now()->subDays(2),
                'end_at' => now()->addDays(30),
                'usage_limit' => 100,
            ]);
        }
    }
}
