<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user di database
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        // Jenis notifikasi yang tersedia
        $types = ['Pembelian', 'Promo', 'Profil'];

        // Untuk setiap user, buat sejumlah notifikasi contoh
        foreach ($users as $user) {
            // Jumlah notifikasi per user, misal antara 3–6
            $count = rand(3, 6);

            for ($i = 0; $i < $count; $i++) {
                // Pilih type acak
                $type = $types[array_rand($types)];

                // Bangun judul & body sesuai type
                switch ($type) {
                    case 'Pembelian':
                        $head = 'Status Pesanan';
                        $body = 'Pesanan Anda dengan kode SPK' . now()->subDays(rand(1, 7))->format('ymd') . rand(100, 999) . ' telah diproses.';
                        break;

                    case 'Promo':
                        $head = 'Promo Spesial';
                        $body = 'Dapatkan diskon ' . rand(10, 50) . '% untuk semua produk hingga ' . now()->addDays(rand(1, 10))->format('d M Y') . '.';
                        break;

                    case 'Profil':
                        $head = 'Update Profil';
                        $body = 'Profil Anda berhasil diubah pada ' . now()->subDays(rand(1, 3))->format('d M Y') . '.';
                        break;
                }

                Notification::create([
                    'user_id'             => $user->id,
                    'notification_head'   => $head,
                    'notification_body'   => $body,
                    'notification_type'   => $type,
                    'notification_status' => (bool) rand(0, 1), // random terbaca/belum
                    'created_at'          => now()->subMinutes(rand(1, 300)),
                    'updated_at'          => now(),
                ]);
            }
        }
    }
}
