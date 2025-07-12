<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    CartController,
    ChatController,
    UserController,
    CustomerController,
    PesananController,
    ProductController,
    ProfileController,
    KategoriController,
    PenerbitController,
    DashboardController,
    DiscountController,
    FaqController,
    HomeController,
    NewsletterController,
    PelangganController,
    NotificationController,
    OngkirController,
    OrderController,
    PromoCodeController,
    TestimonialController,
    BannerController,
    BlogController,
    SettingController,
    Auth\PasswordResetController,
};

// ----------------------------------
// Public Pages (Landing)
// ----------------------------------
Route::get('/', [ProductController::class, 'home'])->name('landingpage.home');
Route::get('/about', [TestimonialController::class, 'about'])->name('landingpage.about');
Route::get('/faq', [FaqController::class, 'landingpage'])->name('landingpage.faq');
Route::get('/order-guide', function () {
    return view('landingpage.order_guide');
})->name('landingpage.order_guide');

Route::get('/kebijakan-privasi', [SettingController::class, 'kebijakanIndex'])->name('kebijakan_index');
Route::get('/syarat-penggunaan', [SettingController::class, 'penggunaanIndex'])->name('penggunaan_index');

Route::get('/articles', [BlogController::class, 'articles'])->name('landingpage.article_index');
Route::get('/article/{slug}', [BlogController::class, 'show'])->name('landingpage.article_show');

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
    Route::get('/checkout/order/{order}', [CartController::class, 'checkoutOrder'])->name('checkout.order');
    Route::post('/checkout/pay/{order}', [CartController::class, 'processPayment'])->name('checkout.pay');
    Route::post('/checkout/payment-success/{order}', [CartController::class, 'paymentSuccess'])->name('checkout.payment-success');
    
    // User Profile & Notifications
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/readnotif/{id}', [ProfileController::class, 'markNotificationAsRead'])->name('profile.readnotif');
    Route::get('/chats', [ChatController::class, 'index'])->name('landingpage.chats');
    Route::patch('/chats/{chat}/mark-as-read', [ChatController::class, 'markAsRead'])->name('chats.markAsRead');
    Route::get('/order/{order}', [ProfileController::class, 'showOrder'])->name('order.show');
    Route::delete('/order/{order}/cancel', [ProfileController::class, 'cancelOrder'])->name('order.cancel');
    
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

        Route::patch('{label}/toggle-live', [ProductController::class, 'toggleLabelLive'])->name('toggle-live');
        Route::patch('product/{product}/toggle-live', [ProductController::class, 'toggleProductLive'])->name('toggle-product-live');
    });
    // CMS Users
    Route::resource('user', UserController::class);

    Route::resource('customer', CustomerController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    Route::resource('newsletter', NewsletterController::class);

    Route::resource('promocode', PromoCodeController::class);

    Route::resource('testimonial', TestimonialController::class);

    Route::resource('banner', BannerController::class);

    Route::resource('faq', FaqController::class);

    Route::resource('discount', DiscountController::class);

    Route::get('discount/products/{labelId}', [DiscountController::class, 'productsByLabel'])->name('discount.products');

    Route::prefix('article')->group(function () {
        Route::get('/',               [BlogController::class,'index'])->name('blog.index');
        Route::get('/add',            [BlogController::class,'create'])->name('blog.create');
        Route::post('/store',         [BlogController::class,'store'])->name('blog.store');
        Route::get('/edit/{item}',  [BlogController::class,'edit'])->name('blog.edit');
        Route::PUT('update/{item}',  [BlogController::class,'update'])->name('blog.update');
        Route::delete('remove/{item}',[BlogController::class,'destroy'])->name('blog.destroy');
    });

    Route::prefix('setting')->group(function () {
        Route::get('/',               [SettingController::class,'index'])->name('setting.index');
        Route::get('/add',            [SettingController::class,'create'])->name('setting.create');
        Route::post('/store',         [SettingController::class,'store'])->name('setting.store');
        Route::get('/edit/{item}',  [SettingController::class,'edit'])->name('setting.edit');
        Route::PUT('update/{item}',  [SettingController::class,'update'])->name('setting.update');
        Route::delete('remove/{item}',[SettingController::class,'destroy'])->name('setting.destroy');
    });
});

Route::get('/password/request', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
Route::get('/password/success', [PasswordResetController::class, 'showSuccessPage'])->name('password.success');

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