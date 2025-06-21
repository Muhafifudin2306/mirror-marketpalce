<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => 'Bagaimana cara melakukan pemesanan?',
            'answer'   => 'Anda bisa melakukan pemesanan melalui halaman produk, kemudian klik tombol beli.',
            'type'     => 'Pembelian',
        ]);

        Faq::create([
            'question' => 'Bagaimana cara mengganti password akun saya?',
            'answer'   => 'Masuk ke halaman profil dan klik "Ubah Password".',
            'type'     => 'Akun',
        ]);

        Faq::create([
            'question' => 'Apakah saya bisa upload desain sendiri?',
            'answer'   => 'Ya, saat checkout Anda bisa mengupload file desain Anda.',
            'type'     => 'Desain',
        ]);

        Faq::create([
            'question' => 'Bagaimana sistem keamanan data pengguna?',
            'answer'   => 'Kami mengenkripsi data penting dan tidak menyimpan informasi sensitif seperti kartu kredit.',
            'type'     => 'Keamanan',
        ]);

        Faq::create([
            'question' => 'Bagaimana cara menghubungi customer service?',
            'answer'   => 'Kunjungi halaman Kontak atau kirim email ke cs@example.com.',
            'type'     => 'Kontak',
        ]);
    }
}
