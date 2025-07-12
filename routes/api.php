<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\ChatController;
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
Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::post('/send-message-admin', [ChatController::class, 'sendMessageAdmin']);

Route::get('/provinsi', [AlamatController::class, 'getProvinsi']);
Route::get('/kabkota', [AlamatController::class, 'getKabKota']);
Route::get('/kecamatan', [AlamatController::class, 'getKecamatan']);
Route::get('/kodepos', [AlamatController::class, 'getKodePos']);

//-------- Midtrans ----------
//Route::post('/midtrans-callback', [PesananController::class, 'callback'])->name('midtrans_callback');
Route::post('/midtrans-callback', [CartController::class, 'paymentCallback'])->name('midtrans_callback');

// handle redirect dari Midtrans
Route::get('/payment/finish', [CartController::class, 'paymentFinish'])->name('payment.finish');

//-------- REST API ----------
Route::middleware(["auth:sanctum"])->group(function(){
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
    Route::post('/pesanan-create', [PesananController::class, 'store']);
    Route::put('/pesanan/{id}', [PesananController::class, 'update']);
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy']);
});

//-------- Auth User REST API ----------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
