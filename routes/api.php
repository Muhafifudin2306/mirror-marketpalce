<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlamatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/hitung-ongkir', [App\Http\Controllers\OngkirController::class, 'cekOngkir']);

Route::get('/provinsi', [AlamatController::class, 'getProvinsi']);
Route::get('/kabkota', [AlamatController::class, 'getKabKota']);
Route::get('/kecamatan', [AlamatController::class, 'getKecamatan']);
Route::get('/kodepos', [AlamatController::class, 'getKodePos']);