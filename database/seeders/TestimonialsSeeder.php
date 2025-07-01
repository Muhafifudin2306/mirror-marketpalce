<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $samples = [
            [
                'name'       => 'John Doe',
                'location'   => 'New York, USA',
                'feedback'   => 'The service was outstanding and very professional!',
                'photo'      => 'photos/john_doe.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Jane Smith',
                'location'   => 'London, UK',
                'feedback'   => 'Comfortable facilities, I will recommend to my friends.',
                'photo'      => 'photos/jane_smith.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Carlos Gomez',
                'location'   => 'Madrid, Spain',
                'feedback'   => 'Quick and easy process, very understandable.',
                'photo'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('testimonials')->insert($samples);
    }
}
