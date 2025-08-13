<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; 

class OngkirController extends Controller
{
    public function cekOngkir(Request $request)
    {
        $user = Auth::user();
        
        $addressOption = $request->input('address_option', 'profile');
        
        if ($addressOption === 'pickup') {
            return response()->json([
                'price' => [],
                'details' => []
            ]);
        }
        
        if ($addressOption === 'custom') {
            $destination = $request->input('custom_postal_code');
        } else {
            $destination = $user->postal_code;
        }
        
        if (!$destination) {
            $destination = $request->destination ?? $user->postal_code;
        }
        
        $weight = $request->weight ?? 1000;

        $response = Http::withHeaders([
            'key' => env('RAJA_ONGKIR_KEY'),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => '50211',
            'destination' => $destination,
            'weight' => $weight,
            'courier' => 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse',
            'price' => 'lowest'
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return response()->json([
                'price' => $result['data']['price'] ?? [],
                'details' => $result['data']
            ]);
        }

        return response()->json(['error' => 'Gagal hitung ongkir'], 500);
    }

}
