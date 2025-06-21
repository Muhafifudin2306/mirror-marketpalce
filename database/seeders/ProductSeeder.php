<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $labels = DB::table('labels')->pluck('id');

        foreach ($labels as $index => $label_id) {
            $productName = 'Produk ' . chr(65 + $index);
            DB::table('products')->insert([
                'uuid' => Str::uuid(),
                'name' => $productName, // Produk A, B, ...
                'label_id' => $label_id,
                'price' => rand(10, 50) * 1000,
                'additional_size' => rand(70, 500),
                'additional_unit' => 'gr',
                'long_product' => rand(10, 50),
                'width_product' => rand(10, 50),
                'min_qty' => rand(1, 10),
                'max_qty' => rand(5, 30),
                'discount_percent' => rand(10, 20),
                'discount_fix' => null,
                'start_discount' => now(),
                'end_discount' => now()->addDays(7),
                'slug' => 'produk-' . Str::slug($productName),
                'production_time' => 'Order 1 - 50 pcs: ' . rand(1, 3) . ' Hari;' . 'Order > 50 pcs: ' . rand(3, 5) . ' Hari',
                'description' => 'Deskripsi untuk produk ' . chr(65 + $index),
                'spesification_desc' => 'Free Design tamplate; Ukuran : 60 x 160 dan 80 x 180; Bahan :; - Flexi Frontlite 340; - Flexi Fronlite Korea 440; - Easy Banner (Bahan lebih kaku kanan kiri tidak lengkung)',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
