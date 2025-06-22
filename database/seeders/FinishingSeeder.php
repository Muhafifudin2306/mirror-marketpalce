<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FinishingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('finishings')->insert([
            [
                'id' => 14,
                'label_id' => 33,
                'finishing_name' => 'LPMA1',
                'finishing_price' => '510',
                'created_at' => '2025-06-12 23:27:07',
                'updated_at' => '2025-06-12 23:27:07',
            ],
            [
                'id' => 15,
                'label_id' => 33,
                'finishing_name' => 'FMA1',
                'finishing_price' => '1001',
                'created_at' => '2025-06-12 23:27:07',
                'updated_at' => '2025-06-12 23:27:07',
            ],
            [
                'id' => 16,
                'label_id' => 33,
                'finishing_name' => 'CMA1',
                'finishing_price' => '4100',
                'created_at' => '2025-06-12 23:27:07',
                'updated_at' => '2025-06-12 23:27:07',
            ],
            [
                'id' => 17,
                'label_id' => 2,
                'finishing_name' => 'Mata Ayam',
                'finishing_price' => '2000',
                'created_at' => '2025-06-14 00:31:40',
                'updated_at' => '2025-06-14 00:31:40',
            ],
        ]);
    }
}
