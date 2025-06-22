<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dan product
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }
        if (Product::count() === 0) {
            Product::factory()->count(5)->create();
        }

        $products = Product::all();
        $users    = User::all();

        // Buat 10 order contoh
        for ($i = 1; $i <= 10; $i++) {
            // Pilih tanggal acak 0–10 hari lalu
            $date = now()->subDays(rand(0, 10));
            $time = $date->toTimeString();

            // Hitung sequence per hari & per bulan
            $yyMMdd       = $date->format('ymd');
            $dailyCount = Order::whereDate('created_at', $date->toDateString())->count() + 1;
            $monthlyCount = Order::whereMonth('created_at', $date->month)->count() + 1;

            // Format SPK: SPK + YYMMDD + dailyCount(2digit) - monthlyCount(3digit)
            $spk = sprintf(
                'SPK%s%02d-%03d',
                $yyMMdd,
                $dailyCount,
                $monthlyCount
            );

            // Pilih user random
            $user = $users->random();

            // Bangun path design: /path/{username-lower}{YYYYMMDD}.jpg
            $designFilename = Str::slug($user->name, '') . $date->format('Ymd') . $i . '.jpg';

            // Buat order
            $order = Order::create([
                'spk'                => $spk,
                'user_id'            => $user->id,
                'transaction_type'   => rand(0, 1),
                'transaction_method' => rand(0, 2),   // 0=Cash,1=TF,2=QRIS
                'order_design'       => $designFilename,
                'preview_design'     => 'preview-' . $designFilename,
                'paid_at'            => $date->toDateString(),
                'payment_status'     => rand(0, 1),   // 0=Lunas,1=Belum Lunas
                'order_status'       => rand(0, 3),   // 0=Pending,1=Dalam pengerjaan,2=Dalam pengiriman,3=selesai
                'subtotal'           => 0,            // hitung setelahnya
                'discount_percent'   => rand(0, 20),  // contoh 0–20%
                'discount_fix'       => null,
                'deadline_date'      => $date->toDateString(),
                'deadline_time'      => $time,
                'express'            => rand(0, 1),
                'delivery_method'    => 'JNE',
                'needs_proofing'     => rand(0, 1),
                'pickup_status'      => rand(0, 1),
                'notes'              => 'Tolong kasih nama ' . $user->name . ' yang besar di tengah ya',
            ]);

            // Tambah produk di order
            $subtotal = 0;
            foreach (range(1, rand(1, 3)) as $j) {
                $product = $products->random();
                $qty     = rand(1, 5);
                $price   = $product->price ?? rand(5000, 20000);
                $lineTotal = $qty * $price;

                OrderProduct::create([
                    'order_id'       => $order->id,
                    'product_id'     => $product->id,
                    'material_type'  => 'Art Paper 150gr',
                    'finishing_type' => 'Laminating Doff',
                    'length'         => rand(10, 50),
                    'width'          => rand(10, 50),
                    'qty'            => $qty,
                    'subtotal'       => $lineTotal,
                ]);

                $subtotal += $lineTotal;
            }

            // Update subtotal final di order
            $order->update(['subtotal' => $subtotal]);
        }
    }
}
