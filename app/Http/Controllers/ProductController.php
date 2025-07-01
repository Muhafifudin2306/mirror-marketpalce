<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Finishing;
use App\Models\Pengarang;
use App\Models\Newsletter;
use Spatie\PdfToImage\Pdf;
use App\Exports\BukuExport;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Http\Controllers\Controller;
use App\Models\Buku; //panggil model
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pesanan; //panggil model
use Illuminate\Support\Facades\Storage;
use App\Models\Kategori; //panggil model
use App\Models\Penerbit; //panggil model
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB; //jika pakai query builder

class ProductController extends Controller
{
    private function applyActiveDiscounts($query)
    {
        // Join pivot + discounts, ambil yang masih aktif
        return $query->with(['images', 'label', 'discounts' => function($q) {
            $q->where('start_discount', '<=', now())
              ->where('end_discount', '>=', now());
        }]);
    }

    public function home(Request $request)
    {
        $banners   = Banner::orderBy('created_at', 'desc')->get();
        $labels    = Label::with('products.images')->get();
        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product');
        $sort      = $request->query('sort');
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();

        // Mulai query, sekarang pakai method pembantu
        $query = $this->applyActiveDiscounts(Product::query());

        if ($productId) {
            $query->where('id', $productId);
            $pageTitle = Product::find($productId)?->name ?: 'Produk';
        }
        elseif ($filter === 'promo') {
            // Filter produk yang punya diskon aktif
            $query->whereHas('discounts');
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $query->where('label_id', $filter);
            $pageTitle = Label::find($filter)?->name ?: 'Produk';
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        if ($search = $request->query('search')) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting masih sama, tapi untuk harga perlu pertimbangkan diskon:
        if ($sort === 'price-desc' || $sort === 'price-asc') {
            // Kalkulasi manual sorting berdasarkan kolom `price` tanpa diskon
            $direction = $sort === 'price-desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        }
        elseif ($sort === 'best-selling') {
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        }
        elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('landingpage.home', compact(
            'labels','products','filter','productId','search','sort','pageTitle','banners','testimonials'
        ));
    }

    // NewsletterController.php
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ]);
        
        Newsletter::create([
            'email' => $request->email
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Email berhasil didaftarkan!'
        ]);
    }

    public function filterProduk(Request $request)
    {
        // Sama seperti home(), bisa refactor jadi satu method jika perlu
        $labels    = Label::with('products.images')->get();
        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product');
        $sort      = $request->query('sort');

        $query = $this->applyActiveDiscounts(Product::query());

        if ($productId) {
            $query->where('id', $productId);
            $pageTitle = Product::find($productId)?->name ?: 'Produk';
        }
        elseif ($filter === 'promo') {
            $query->whereHas('discounts');
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $query->where('label_id', $filter);
            $pageTitle = Label::find($filter)?->name ?: 'Produk';
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        if ($search = $request->query('search')) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        if ($sort === 'price-desc' || $sort === 'price-asc') {
            $direction = $sort === 'price-desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        }
        elseif ($sort === 'best-selling') {
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        }
        elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('landingpage.product_all', compact(
            'labels','products','filter','productId','search','sort','pageTitle'
        ));
    }

    /**
     * Detail buku landingpage
     */
    public function detailProduk(Product $product, Request $request)
    {
        $orderProduct = null;
        $isEdit = false;

        $product->loadCount('orderProducts')
                ->load('label.finishings', 'images', 'discounts');

        $disc = $product->discounts->first(); 
        $base = $product->price;
        $finalBase = $base;

        if ($disc) {
            if ($disc->discount_percent) {
                $finalBase -= $base * ($disc->discount_percent / 100);
            } elseif ($disc->discount_fix) {
                $finalBase -= $disc->discount_fix;
            }
        }

        $bestProducts = Product::with('images')
            ->withCount('orderProducts')
            ->orderByDesc('order_products_count')
            ->limit(4)
            ->get();

        return view('landingpage.product_detail', compact(
            'product',
            'orderProduct',
            'finalBase',
            'bestProducts',
            'isEdit'
        ));
    }

    private function createOrderNotification($order, $status, $invoiceNumber)
    {
        $notificationData = $this->getOrderNotificationContent($status, $invoiceNumber);
        
        if ($notificationData) {
            $notification = new Notification();
            $notification->timestamps = false;
            $notification->forceFill([
                'user_id' => $order->user_id,
                'notification_type' => 'Pembelian',
                'notification_head' => $notificationData['head'],
                'notification_body' => $notificationData['body'],
                'notification_status' => 0, // Unread
                'created_at' => now(),
                'updated_at' => now(),
            ])->save();
        }
    }

    private function getOrderNotificationContent($status, $invoiceNumber)
    {
        $notifications = [
            0 => [
                'head' => 'PESANANMU BERHASIL DIBUAT',
                'body' => "Pesananmu #{$invoiceNumber} berhasil dibuat dan masuk ke keranjang. Segera lakukan pembayaran untuk memproses pesananmu. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            1 => [
                'head' => 'PEMBAYARAN PESANANMU TELAH DIKONFIRMASI',
                'body' => "Pembayaran untuk pesananmu #{$invoiceNumber} telah dikonfirmasi. Pesananmu akan segera diproses. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            2 => [
                'head' => 'PESANANMU LAGI DIPRODUKSI',
                'body' => "Pesananmu #{$invoiceNumber} udah di tahap produksi. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            3 => [
                'head' => 'PESANANMU SEDANG DALAM PENGIRIMAN',
                'body' => "Pesananmu #{$invoiceNumber} sedang dalam proses pengiriman. Pastikan kamu siap menerima pesananmu. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ],
            4 => [
                'head' => 'PESANANMU TELAH SELESAI',
                'body' => "Selamat! Pesananmu #{$invoiceNumber} telah selesai dan sampai tujuan. Terima kasih telah mempercayai layanan kami. Jangan lupa berikan review ya!"
            ],
            9 => [
                'head' => 'PESANANMU TELAH DIBATALKAN',
                'body' => "Maaf, pesananmu #{$invoiceNumber} telah dibatalkan. Jika ada pertanyaan, silakan hubungi customer service kami. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ]
        ];

        return $notifications[$status] ?? null;
    }

    public function beliProduk(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'product_id'      => 'required|exists:products,id',
            'finishing_id'    => 'nullable|exists:finishings,id',
            'express'         => 'required|in:0,1',
            'deadline_time'   => 'nullable|required_if:express,1|date_format:H:i',
            'needs_proofing'  => 'required|in:0,1',
            'proof_qty'       => 'nullable|integer|min:1',
            'order_design'    => 'nullable|file|mimes:jpeg,jpg,png,pdf,zip,rar|max:20480',
            'preview_design'  => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'length'          => 'nullable|numeric|min:0',
            'width'           => 'nullable|numeric|min:0',
            'qty'             => 'required|integer|min:1',
            'notes'           => 'nullable|string|max:1000',
            'order_status'    => 'required|in:0',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::with(['label.finishings', 'discounts'])->findOrFail($validated['product_id']);

            $discount = $product->discounts
                ->where('start_discount', '<=', now())
                ->where('end_discount', '>=', now())
                ->first();

            $today        = now();
            $dailyCount   = Order::whereDate('created_at', $today->toDateString())->count() + 1;
            $monthlyCount = Order::whereMonth('created_at', $today->month)->count() + 1;
            $spkNumber    = sprintf('%s%s%s%02d-%03d', $today->format('y'), $today->format('m'), $today->format('d'), $dailyCount, $monthlyCount);

            $designFileName = $previewFileName = null;

            if ($request->hasFile('order_design')) {
                $file = $request->file('order_design');
                $ext = $file->getClientOriginalExtension();
                $designFileName = $spkNumber . '.' . $ext;
                $file->storeAs('landingpage/img/order_design', $designFileName, 'public');
            }

            if ($request->hasFile('preview_design')) {
                $file = $request->file('preview_design');
                $base = $designFileName ?? ($user->id . '_' . time());
                $previewFileName = 'preview-' . pathinfo($base, PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $previewFileName, 'public');
            }

            $basePrice = $product->price;
            $discountPercent = null;
            $discountFix = null;

            if ($discount) {
                if ($discount->discount_percent) {
                    $discountPercent = $discount->discount_percent;
                    $basePrice -= $basePrice * ($discountPercent / 100);
                } elseif ($discount->discount_fix) {
                    $discountFix = $discount->discount_fix;
                    $basePrice -= $discountFix;
                }
            }

            $finishingPrice = 0;
            $finishingName = null;
            if (!empty($validated['finishing_id']) && $fin = $product->label->finishings->find($validated['finishing_id'])) {
                $finishingPrice = $fin->finishing_price;
                $finishingName  = $fin->finishing_name;
            }

            $area = 1;
            if (in_array($product->additional_unit, ['cm', 'm']) && $validated['length'] && $validated['width']) {
                $l = $validated['length'];
                $w = $validated['width'];
                $area = $product->additional_unit === 'cm'
                    ? ($l / 100) * ($w / 100)
                    : $l * $w;
            }

            $subtotalHpl       = $basePrice * $area * $validated['qty'];
            $subtotalFinishing = $finishingPrice * $validated['qty'];
            $subtotal          = $subtotalHpl + $subtotalFinishing;

            if ($validated['express'] == 1) {
                $subtotal *= 1.5;
            }

            $order = Order::create([
                'spk'               => $spkNumber,
                'user_id'           => $user->id,
                'order_design'      => $designFileName,
                'preview_design'    => $previewFileName,
                'transaction_type'  => 0,
                'transaction_method'=> 0,
                'payment_status'    => 0,
                'order_status'      => 0,
                'subtotal'          => round($subtotal),
                'discount_percent'  => $discountPercent,
                'discount_fix'      => $discountFix,
                'deadline_time'     => $validated['deadline_time'] ?? null,
                'express'           => $validated['express'],
                'needs_proofing'    => $validated['needs_proofing'],
                'proof_qty'         => $validated['proof_qty'] ?? null,
                'pickup_status'     => 0,
                'notes'             => $validated['notes'] ?? null,
            ]);

            OrderProduct::create([
                'order_id'       => $order->id,
                'product_id'     => $validated['product_id'],
                'material_type'  => $product->name,
                'finishing_type' => $finishingName,
                'length'         => $validated['length'] ?? null,
                'width'          => $validated['width'] ?? null,
                'qty'            => $validated['qty'],
                'subtotal'       => round($subtotal),
            ]);

            $this->createOrderNotification($order, 0, $spkNumber);

            DB::commit();

            return redirect()->route('landingpage.produk_detail', $product->slug)
                            ->with('success', 'Order berhasil. Silahkan cek keranjang untuk melanjutkan tahap pembayaran');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()])->withInput();
        }
    }


    // ---- Adminpage (CMS)
    
    public function adminIndex(Request $request)
    {
        $labels = Label::with('products.images', 'finishings')->latest()->get();
        $editingLabel = null;
        if ($request->has('edit')) {
            $editingLabel = Label::with('products.images', 'finishings')->find($request->edit);
        }
        return view('adminpage.product.index', compact('labels', 'editingLabel'));
    }

    public function adminStore(Request $request)
    {
        // dd($request->all(), $request->file('product_images'));
        
        $request->validate([
            'name_label' => 'required|string',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'name.*' => 'required|string',
            'price.*' => 'nullable|numeric',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|array|max:4', // Maksimal 4 gambar per produk
            'product_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $label = Label::create([
            'name' => $request->name_label,
            'size' => $request->size,
            'unit' => $request->unit,
            'desc' => $request->desc,
            'type' => 'standart'
        ]);

        if ($request->has('name')) {
            foreach ($request->name as $index => $productName) {
                $product = Product::create([
                    'label_id' => $label->id,
                    'name' => $productName,
                    'long_product' => $request->long_product[$index] ?? null,
                    'width_product' => $request->width_product[$index] ?? null,
                    'additional_size' => $request->additional_size[$index] ?? null,
                    'additional_unit' => $request->additional_unit[$index] ?? null,
                    'price' => $request->price[$index] ?? null,
                    'min_qty' => $request->min_qty[$index] ?? null,
                    'max_qty' => $request->max_qty[$index] ?? null,
                    'production_time' => $request->production_time[$index] ?? null,
                    'description' => $request->description[$index] ?? null,
                    'spesification_desc' => $request->spesification_desc[$index] ?? null,
                ]);
                $product->slug = Str::slug($productName) . '-' . $product->id;
                $product->save();

                if ($request->hasFile("product_images.{$index}")) {
                    $files = $request->file("product_images.{$index}");
                    
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    
                    $files = array_slice($files, 0, 4);
                    
                    foreach ($files as $imagefile) {
                        if ($imagefile && $imagefile->isValid()) {
                            $path = $imagefile->store('product_images', 'public');
                            $product->images()->create(['image_product' => $path]);
                        }
                    }
                }
            }
        }
        
        if ($request->has('finishing_name')) {
            foreach ($request->finishing_name as $index => $finishingName) {
                if($finishingName) {
                    Finishing::create([
                        'label_id' => $label->id,
                        'finishing_name' => $finishingName,
                        'finishing_price' => $request->finishing_price[$index] ?? null,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Data Produk berhasil ditambahkan.');
    }

    public function adminUpdate(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name_label' => 'required|string',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'name' => 'required|array|min:1',
            'name.*' => 'required|string',
            'price.*' => 'nullable|numeric',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|array|max:4',
            'product_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|array',
            'existing_images.*.*' => 'nullable|string',
        ]);
        
        $label->update([
            'name' => $validated['name_label'],
            'size' => $validated['size'],
            'unit' => $request->input('unit'),
            'desc' => $validated['desc'],
        ]);

        $existingProductIds = $label->products()->pluck('id')->toArray();
        $submittedProductIds = [];

        foreach ($validated['name'] as $i => $nm) {
            $productId = $request->product_id[$i] ?? null;
            $productData = [
                'name' => $nm,
                'long_product' => $request->input('long_product')[$i] ?? null,
                'width_product' => $request->input('width_product')[$i] ?? null,
                'additional_size' => $request->additional_size[$i] ?? null,
                'additional_unit' => $request->additional_unit[$i] ?? null,
                'price' => $validated['price'][$i] ?? null,
                'min_qty' => $request->input('min_qty')[$i] ?? null,
                'max_qty' => $request->input('max_qty')[$i] ?? null,
                'production_time' => $request->production_time[$i] ?? null,
                'description' => $request->description[$i] ?? null,
                'spesification_desc' => $request->spesification_desc[$i] ?? null,
                'slug' => Str::slug($nm)
            ];

            $product = $label->products()->updateOrCreate(['id' => $productId], $productData);

            if (!$product->slug || !Str::endsWith($product->slug, "-{$product->id}")) {
                $product->slug = Str::slug($nm) . '-' . $product->id;
                $product->save();
            }
            
            $submittedProductIds[] = $product->id;

            $existingImages = $product->images;
            $keptImages = $request->input("existing_images.{$i}", []);
            foreach ($existingImages as $image) {
                if (!in_array($image->id, $keptImages)) {
                    Storage::disk('public')->delete($image->image_product);
                    $image->delete();
                }
            }

            if ($request->hasFile("product_images.{$i}")) {
                $files = $request->file("product_images.{$i}");
                
                if (!is_array($files)) {
                    $files = [$files];
                }
                
                $currentImageCount = $product->images()->count();
                $availableSlots = 4 - $currentImageCount;
                
                $files = array_slice($files, 0, $availableSlots);
                
                foreach ($files as $imagefile) {
                    if ($imagefile && $imagefile->isValid()) {
                        $path = $imagefile->store('product_images', 'public');
                        $product->images()->create(['image_product' => $path]);
                    }
                }
            }
        }
        
        $productsToDelete = array_diff($existingProductIds, $submittedProductIds);
        if (!empty($productsToDelete)) {
            $products = Product::whereIn('id', $productsToDelete)->with('images')->get();
            foreach ($products as $product) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_product);
                }
            }
            Product::destroy($productsToDelete);
        }

        $label->finishings()->delete();
        if ($request->has('finishing_name')) {
            foreach ($request->input('finishing_name') as $i => $nm) {
                if ($nm) {
                    $label->finishings()->create([
                        'finishing_name' => $nm,
                        'finishing_price' => $request->input('finishing_price')[$i] ?? null,
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.product.index')->with('success', 'Data berhasil di-update.');
    }


    public function adminDestroy(Label $label)
    {
        $products = Product::where('label_id', $label->id)->with('images')->get();
        foreach($products as $product) {
            foreach($product->images as $image) {
                Storage::disk('public')->delete($image->image_product);
            }
        }

        $label->delete();

        Product::where('label_id', $label->id)->delete();
        Finishing::where('label_id', $label->id)->delete();

        return redirect()->route('admin.product.index')->with('success', 'Data berhasil dihapus.');
    }
    
}
