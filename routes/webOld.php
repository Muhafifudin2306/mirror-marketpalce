<?php

use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\ChatController;

// ------- ABOUT PAGE --------
Route::get('/about', function () {
    return view('landingpage.about');
});

Route::post('/hitung-ongkir', [App\Http\Controllers\OngkirController::class, 'cekOngkir']);


// ------- FAQ PAGE --------
Route::get('/faq', function () {
    return view('landingpage.faq');
});

// ------- LANDING PAGE -------
Route::get('/produk', function () {
    return view('landingpage.produk');
});

Route::get('/order-guide', function () {
    return view('landingpage.order_guide');
});

Route::get('/contact', function () {
    return view('landingpage.contact');
});

Route::get('/products', [ProductController::class, 'filterProduk'])->name('landingpage.products');
Route::get('/chats', [ChatController::class, 'index'])->name('landingpage.chats');
Route::get('/promo', [ProductController::class, 'bukuDiskon']);
// Route::get('/', function () {
//     return view('landingpage.home');
// });
Route::get('/', [ProductController::class, 'home']);

// Route::get('/detail/{id}', [ProductController::class, 'detailBuku'])->name('landingpage.buku_detail');
Route::get('/product/{product:slug}', [ProductController::class, 'detailProduk'])->name('landingpage.produk_detail');
Route::post('/product/beli', [ProductController::class, 'beliProduk'])->name('orders.store')->middleware('auth');

Route::get('/keranjang',        [CartController::class,'index'])->name('cart.index')->middleware('auth');
Route::post('/keranjang/add/{product}', [CartController::class,'add'])->name('cart.add')->middleware('auth');
Route::post('/keranjang/update/{item}',[CartController::class,'update'])->name('cart.update')->middleware('auth');
Route::delete('/keranjang/remove/{item}',[CartController::class,'remove'])->name('cart.remove')->middleware('auth');
Route::post('/cart/{orderProduct}', [CartController::class, 'updateQty'])->name('cart.clear')->middleware('auth');

Route::post('/checkout/item/{item}', [CartController::class, 'checkoutItem'])->name('checkout.item')->middleware('auth');
Route::post('/checkout/pay/{order}', [CartController::class, 'processPayment'])->name('checkout.pay')->middleware('auth');

Route::post('/checkout/payment-success/{order}', [CartController::class, 'paymentSuccess'])->name('checkout.payment-success')->middleware('auth');
Route::post('/midtrans/callback', [CartController::class, 'paymentCallback'])->name('midtrans.callback');
Route::get('/snap', function () {
    return view('snap');
});
// Route::get('/keranjang', [UserController::class, 'keranjang'])->name('keranjang')->middleware('auth');
// Route::post('/tambah-ke-keranjang/{id}', [PesananController::class, 'tambahKeKeranjang'])->name('tambah.ke.keranjang')->middleware('auth');
// Route::delete('/keranjang/{id}', [PesananController::class, 'destroy'])->name('keranjang.destroy')->middleware('auth');
Route::get('/pustaka', [UserController::class, 'pustaka'])->name('pustaka')->middleware('auth');
Route::get('/ebook/read/{id}', [ProductController::class, 'read'])->name('ebook.read');
Route::post('/checkout', [UserController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
// Route::post('/readall', [ProfileController::class, 'readAll'])->name('readAll');
Route::post('/readnotif/{id}', [ProfileController::class, 'markNotificationAsRead'])->name('updateNotification')->middleware('auth');

Route::get('/ubah_profil/{id}', [UserController::class, 'ubahProfil'])->name('landingpage.profile_edit');
// routes/web.php
Route::get('/pdf-viewer', function (Request $request) {
    return view('landingpage.pdf-viewer');
});


// ------- ADMIN PAGE -------
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('adminpage.home');
    Route::get('/buku', [ProductController::class, 'index']);
    Route::resource('buku', ProductController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('pesanan', PesananController::class);
    Route::resource('user', UserController::class);
    Route::get('/buku-excel', [ProductController::class, 'bukuExcel']);
    Route::get('/pesanan-excel', [PesananController::class, 'pesananExcel']);

    Route::prefix('product')->name('adminProduct.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'adminIndex'])->name('index');
        Route::post('/create', [App\Http\Controllers\ProductController::class, 'adminStore'])->name('store');
        Route::put('/update/{label}', [App\Http\Controllers\ProductController::class, 'adminUpdate'])->name('update');
        Route::delete('/{label}', [App\Http\Controllers\ProductController::class, 'adminDestroy'])->name('destroy');
    });

    // Route::get('/admin', [DashboardController::class, 'index'])->name('adminpage.home');
    // Route::get('/product', [ProductController::class, 'index']);
    // Route::resource('product', ProductController::class);
    // Route::resource('label', KategoriController::class);
    // Route::resource('', PelangganController::class);
    // Route::resource('penerbit', PenerbitController::class);
    // Route::resource('pesanan', PesananController::class);
    // Route::resource('user', UserController::class);

    // Notifications routes
    

    // Route::get('/profile', [NotificationController::class, 'index'])->name('notif');
});

// ------- AUTHENTICATION -------
Auth::routes();

Route::get('/paynow', [UserController::class, 'pay'])->name('pay_now');
Route::get('/invoice/{id}', [PesananController::class, 'invoice'])->name('invoice');

Route::get('pesanan/delete/{id}', [PesananController::class, 'destroy'])->name('pesanan_delete');
Route::post('/keranjang_pesanan', [UserController::class, 'checkout'])->name('keranjang_pesanan');