<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $discount = Discount::create([
                'name' => "Diskon #{$i}",
                'discount_percent' => rand(1, 8) * 5,
                'discount_fix' => null,
                'start_discount' => now()->subDays(rand(0,5)),
                'end_discount' => now()->addDays(rand(5,15)),
            ]);

            $productId = $productIds[$i-1] ?? Arr::random($productIds);
            $discount->products()->attach($productId);
        }
    }
}
