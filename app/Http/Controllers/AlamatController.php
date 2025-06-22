<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function getProvinsi()
    {
        $data = DB::table('d_provinsi')
                    ->orderBy('nama')
                    ->get(['id', 'nama as text']);
        return response()->json(['result' => $data]);
    }

    public function getKabKota(Request $request)
    {
        $data = DB::table('d_kabkota')
                    ->where('d_provinsi_id', $request->d_provinsi_id)
                    ->orderBy('nama')
                    ->get(['id', 'nama as text']);
        return response()->json(['result' => $data]);
    }

    public function getKecamatan(Request $request)
    {
        $data = DB::table('d_kecamatan')
                    ->where('d_kabkota_id', $request->d_kabkota_id)
                    ->orderBy('nama')
                    ->get(['id', 'nama as text']);
        return response()->json(['result' => $data]);
    }

    public function getKodePos(Request $request)
    {
        $data = DB::table('d_kodepos')
                    ->where('d_kabkota_id', $request->d_kabkota_id)
                    ->where('d_kecamatan_id', $request->d_kecamatan_id)
                    ->orderBy('kodepos')
                    ->get(['id', 'kodepos as text']);
        return response()->json(['result' => $data]);
    }
}

