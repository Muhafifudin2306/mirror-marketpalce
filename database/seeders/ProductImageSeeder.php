<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('id');

        foreach ($productIds as $productId) {
            DB::table('product_images')->insert([
                [
                    'product_id' => $productId,
                    'image_product' => 'produk-' . $productId . '_1.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'image_product' => 'produk-' . $productId . '_3.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'image_product' => 'produk-' . $productId . '_4.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'image_product' => 'produk-' . $productId . '_5.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
