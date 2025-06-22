<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    public function cekOngkir(Request $request)
    {
        // dd(env('RAJA_ONGKIR_KEY'));
        $response = Http::withHeaders([
            'key' => env('RAJA_ONGKIR_KEY'),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => '50211',
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse',
            'price' => 'lowest'
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return response()->json([
                'price' => $result['data']['price'] ?? null,
                'details' => $result['data']
            ]);
        }

        return response()->json(['error' => 'Gagal hitung ongkir'], 500);

    }
}
