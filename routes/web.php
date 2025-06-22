<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportOrderExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/error', function () {
    return view('error.index');
})->name('error');
Route::get('orders/{id}/invoice', [App\Http\Controllers\InvoiceController::class, 'invoice'])->name('invoice');
Route::post('/cek-ongkir', [App\Http\Controllers\OngkirController::class, 'cekOngkir']);

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/index-json', [App\Http\Controllers\DashboardController::class, 'indexJson']);
    Route::get('/dashboard/index-category-json', [App\Http\Controllers\DashboardController::class, 'getPerMonthPerCategory']);
    Route::middleware('role:Super Admin|Owner')->group(function () {
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::post('/create', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
        Route::put('/update/{label}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
        Route::delete('/{label}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [App\Http\Controllers\OrderController::class, 'pesananIndex'])->name('index');
        Route::get('/data-json', [App\Http\Controllers\OrderController::class, 'pesananIndexJson']);
        Route::get('/detail/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('show');
        Route::get('/create', [App\Http\Controllers\OrderController::class, 'create'])->name('create');
        Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\OrderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('destroy');
        Route::get('{id}/invoices', [App\Http\Controllers\InvoiceController::class, 'invoice'])->name('invoice');
        Route::post('/{id}/verify', [App\Http\Controllers\OrderController::class, 'verify'])->name('verify');
        Route::post('/{id}/production', [App\Http\Controllers\OrderController::class, 'production'])->name('production-shortcut');
        Route::get('/payment', [App\Http\Controllers\OrderController::class, 'paymentIndex'])->name('payment');
        Route::get('/payment-detail/{id}', [App\Http\Controllers\OrderController::class, 'paymentShow'])->name('paymentShow');
        Route::post('/{id}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{id}/confirm-payment', [App\Http\Controllers\OrderController::class, 'confirmPayment'])->name('confirmPayment');
        Route::post('/{id}/payment-pelunasan', [App\Http\Controllers\OrderController::class, 'finishPelunasanPayment'])->name('finishPelunasanPayment');

        Route::get('/verification', [App\Http\Controllers\OrderController::class, 'orderVerifIndex'])->name('orderVerif');
        Route::get('/verification-detail/{id}', [App\Http\Controllers\OrderController::class, 'orderVerifShow'])->name('orderVerifShow');
        Route::post('/{id}/confirm-verification', [App\Http\Controllers\OrderController::class, 'confirmOrderVerif'])->name('confirmOrderVerif');
        Route::get('/production', [App\Http\Controllers\OrderController::class, 'productionIndex'])->name('production');
        Route::get('/production-detail/{id}', [App\Http\Controllers\OrderController::class, 'productionShow'])->name('productionShow');
        Route::post('/{id}/confirm-production', [App\Http\Controllers\OrderController::class, 'confirmProduction'])->name('confirmProduction');
        
        Route::get('/shipping', [App\Http\Controllers\OrderController::class, 'shippingIndex'])->name('shipping');
        Route::get('/shipping-detail/{id}', [App\Http\Controllers\OrderController::class, 'shippingShow'])->name('shippingShow');
        Route::post('/{id}/shipping-pelunasan', [App\Http\Controllers\OrderController::class, 'finishPelunasanShipping'])->name('finishPelunasanShipping');
        Route::post('/{id}/confirm-shipping', [App\Http\Controllers\OrderController::class, 'confirmShipping'])->name('confirmShipping');
        Route::post('/{id}/confirm-shippinh-payment', [App\Http\Controllers\OrderController::class, 'confirmPaymentShipping'])->name('confirmPaymentShipping');
        Route::post('/{id}/complete-shipping', [App\Http\Controllers\OrderController::class, 'completeShipping'])->name('completeShipping');
        Route::get('/completed', [App\Http\Controllers\OrderController::class, 'completedIndex'])->name('completed');
        Route::get('/completed-detail/{id}', [App\Http\Controllers\OrderController::class, 'completedShow'])->name('completedShow');
        Route::get('/canceled', [App\Http\Controllers\OrderController::class, 'canceledIndex'])->name('canceled');
        Route::get('/canceled-detail/{id}', [App\Http\Controllers\OrderController::class, 'canceledShow'])->name('canceledShow');
        Route::post('/{id}/confirm-canceled', [App\Http\Controllers\OrderController::class, 'confirmCanceled'])->name('confirmCanceled');

        Route::get('/export', [App\Http\Controllers\ExportOrderExportController::class, 'orderExport'])->name('export');
    });

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
    ]);

    Route::get('/export-users', [ExportOrderExportController::class, 'export']);
    // Route::middleware('role:Super Admin')->group(function () {
    // });
});
