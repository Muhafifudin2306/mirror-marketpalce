<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    CartController,
    ChatController,
    UserController,
    PesananController,
    ProductController,
    ProfileController,
    KategoriController,
    PenerbitController,
    DashboardController,
    HomeController,
    PelangganController,
    NotificationController,
    OngkirController
};

// ----------------------------------
// Public Pages (Landing)
// ----------------------------------
Route::get('/', [ProductController::class, 'home'])->name('landingpage.home');
Route::get('/about', function () {
    return view('landingpage.about');
})->name('landingpage.about');
Route::get('/faq', function () {
    return view('landingpage.faq');
})->name('landingpage.faq');
Route::get('/order-guide', function () {
    return view('landingpage.order_guide');
})->name('landingpage.order_guide');

// Shipping calculation
Route::post('/hitung-ongkir', [OngkirController::class, 'cekOngkir'])->name('ongkir.cek');

// ----------------------------------
// Product Listings & Ordering
// ----------------------------------
Route::get('/products', [ProductController::class, 'filterProduk'])->name('landingpage.products');
Route::get('/product/{product:slug}', [ProductController::class, 'detailProduk'])->name('landingpage.produk_detail');
Route::post('/product/beli', [ProductController::class, 'beliProduk'])->name('orders.store')->middleware('auth');

// ----------------------------------
// Customer Cart & Checkout (Authenticated)
// ----------------------------------
Route::middleware('auth')->group(function () {
    // Cart
    Route::prefix('keranjang')->group(function () {
        Route::get('/',             [CartController::class,'index'])->name('cart.index');
        Route::post('update/{item}',[CartController::class,'update'])->name('cart.update');
        Route::delete('remove/{item}',[CartController::class,'remove'])->name('cart.remove');
        Route::post('itemqty/{orderProduct}', [CartController::class,'updateQty'])->name('cart.clear');
        Route::get('order-product/{orderProduct}/edit', [CartController::class, 'editOrderProduct'])->name('order-product.edit');
        Route::put('order-product/{orderProduct}',    [CartController::class, 'updateOrderProduct'])->name('order-product.update');
    });

    // Checkout
    Route::post('/checkout/item/{item}', [CartController::class, 'checkoutItem'])->name('checkout.item');
    Route::get('/promo/check', [CartController::class, 'check'])->name('promo.check');
    Route::post('/checkout/pay/{order}', [CartController::class, 'processPayment'])->name('checkout.pay');
    Route::post('/checkout/payment-success/{order}', [CartController::class, 'paymentSuccess'])->name('checkout.payment-success');
    Route::get('/checkout/order/{order}', [CartController::class, 'checkoutOrder'])->name('checkout.order');
    Route::get('/promo/check', [CartController::class, 'check'])->name('promo.check');
    
    // User Profile & Notifications
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/readnotif/{id}', [ProfileController::class, 'markNotificationAsRead'])->name('profile.readnotif');
    Route::get('/chats', [ChatController::class, 'index'])->name('landingpage.chats');

    Route::post('/newsletter/subscribe', [ProductController::class, 'subscribe'])->name('newsletter.subscribe');
});

// ----------------------------------
// Midtrans Payment Callback
// ----------------------------------
Route::post('/midtrans/callback', [CartController::class, 'paymentCallback'])->name('midtrans.callback');
Route::get('/snap', function () {
    return view('snap');
});

// ----------------------------------
// Authentication
// ----------------------------------
Auth::routes();

// ----------------------------------
// Admin Dashboard
// ----------------------------------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // CMS Product
    Route::prefix('product')->name('product.')->group(function() {
        Route::get('/',          [ProductController::class, 'adminIndex'])->name('index');
        Route::post('/',         [ProductController::class, 'adminStore'])->name('store');
        Route::put('{label}',    [ProductController::class, 'adminUpdate'])->name('update');
        Route::delete('{label}', [ProductController::class, 'adminDestroy'])->name('destroy');
    });
    // CMS Users
    Route::resource('user', UserController::class);
});

// ----------------------------------
// Deprecated / Unused Routes
// (moved here, kept for backward compatibility)
// ----------------------------------
// Route::post('/checkout', [UserController::class, 'checkout'])->name('checkout');
// Route::get('/invoice/{id}', [PesananController::class, 'invoice'])->name('invoice');
// Route::get('/keranjang',       [CartController::class,'index']); // duplicate kept
// Route::get('/pustaka', [UserController::class, 'pustaka'])->name('pustaka');
// Route::get('/ebook/read/{id}', [ProductController::class, 'read'])->name('ebook.read');
// Route::get('/ubah_profil/{id}', [UserController::class, 'ubahProfil'])->name('landingpage.profile_edit');
// Route::get('/pdf-viewer', function () {
//     return view('landingpage.pdf-viewer');
// });
// Route::get('/produk',         function () { return view('landingpage.produk'); });
// Route::get('/contact',        function () { return view('landingpage.contact'); });
// Route::get('/promo',          [ProductController::class, 'bukuDiskon']);
// Route::get('/buku',           [ProductController::class, 'index']);
// Route::resource('buku',       ProductController::class);
// Route::resource('kategori',   KategoriController::class);
// Route::resource('pelanggan',  PelangganController::class);
// Route::resource('penerbit',   PenerbitController::class);
// Route::resource('pesanan',    PesananController::class);
// Route::get('/buku-excel',     [ProductController::class, 'bukuExcel']);
// Route::get('/pesanan-excel',  [PesananController::class, 'pesananExcel']);
// Route::get('/paynow', [UserController::class, 'pay'])->name('pay_now');
// Route::get('pesanan/delete/{id}', [PesananController::class, 'destroy'])->name('pesanan_delete');
// Route::post('/keranjang_pesanan', [UserController::class, 'checkout'])->name('keranjang_pesanan');