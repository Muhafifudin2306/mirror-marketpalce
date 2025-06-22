<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class ImportIndonesiaRegions extends Command
{
    protected $signature = 'import:regions';
    protected $description = 'Import data wilayah Indonesia dari API (provinsi, kabupaten, kecamatan, kelurahan)';

    public function handle()
    {
        $this->info("Memulai import wilayah Indonesia...");
        try {
            $provinces = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json')->json();

            if (!is_array($provinces)) {
                $this->error("Gagal mengambil data provinsi.");
                return;
            }

            foreach ($provinces as $prov) {
                try {
                    $this->info("provinceId: {$prov['id']}");
                    $province = Province::updateOrCreate(
                        ['id' => $prov['id']],
                        [
                            'nama' => $prov['nama'],
                            'latitude' => $prov['latitude'],
                            'longitude' => $prov['longitude'],
                        ]
                    );

                    $regencies = Http::get("https://ibnux.github.io/data-indonesia/kota/{$province->id}.json")->json();
                    if (!is_array($regencies)) continue;

                    foreach ($regencies as $reg) {
                        try {
                            $this->info("regId: {$reg['id']}");
                            $regency = Regency::updateOrCreate(
                                ['id' => $reg['id']],
                                [
                                    'province_id' => $province->id,
                                    'nama' => $reg['nama'],
                                    'latitude' => $reg['latitude'],
                                    'longitude' => $reg['longitude'],
                                ]
                            );

                            $districts = Http::get("https://ibnux.github.io/data-indonesia/kecamatan/{$regency->id}.json")->json();
                            if (!is_array($districts)) continue;

                            foreach ($districts as $dist) {
                                try {
                                    $this->info("distId: {$dist['id']}");
                                    $district = District::updateOrCreate(
                                        ['id' => $dist['id']],
                                        [
                                            'province_id' => $province->id,
                                            'regency_id' => $regency->id,
                                            'nama' => $dist['nama'],
                                            'latitude' => $dist['latitude'],
                                            'longitude' => $dist['longitude'],
                                        ]
                                    );

                                    $villages = Http::get("https://ibnux.github.io/data-indonesia/kelurahan/{$district->id}.json")->json();
                                    if (!is_array($villages)) continue;

                                    foreach ($villages as $village) {
                                        try {
                                            $this->info("villageId: {$village['id']}");
                                            Village::updateOrCreate(
                                                ['id' => $village['id']],
                                                [
                                                    'province_id' => $province->id,
                                                    'regency_id' => $regency->id,
                                                    'district_id' => $district->id,
                                                    'nama' => $village['nama'],
                                                    'latitude' => $village['latitude'],
                                                    'longitude' => $village['longitude'],
                                                ]
                                            );
                                        } catch (\Throwable $e) {
                                            $this->warn("Gagal simpan kelurahan {$village['id']}: " . $e->getMessage());
                                            continue;
                                        }
                                    }
                                } catch (\Throwable $e) {
                                    $this->warn("Gagal simpan kecamatan {$dist['id']}: " . $e->getMessage());
                                    continue;
                                }
                            }
                        } catch (\Throwable $e) {
                            $this->warn("Gagal simpan kabupaten {$reg['id']}: " . $e->getMessage());
                            continue;
                        }
                    }
                } catch (\Throwable $e) {
                    $this->warn("Gagal simpan provinsi {$prov['id']}: " . $e->getMessage());
                    continue;
                }
            }
        } catch (\Throwable $e) {
            $this->error("Gagal mengambil data provinsi utama: " . $e->getMessage());
        }

        $this->info("Import selesai!");
    }
}
