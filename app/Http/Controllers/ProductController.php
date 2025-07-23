<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Label;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Finishing;
use App\Models\Newsletter;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
        
        $labels    = Label::where('is_live', true)
                        ->whereHas('products', function($q) {
                            $q->where('is_live', true);
                        })
                        ->with(['products' => function($query) {
                            $query->where('is_live', true)->with('images');
                        }])
                        ->get();
        
        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product');
        $sort      = $request->query('sort');
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        
        $latestBlogs = Blog::where('is_live', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $query = $this->applyActiveDiscounts(Product::query());
        
        $query = $query->where('is_live', true)
                    ->whereHas('label', function($q) {
                        $q->where('is_live', true);
                    });

        $rollBannerProducts = Product::where('is_live', true)
                            ->whereHas('label', function($q) {
                                $q->where('is_live', true)
                                ->whereIn('name', ['Print Outdoor', 'Print Indoor']);
                            })
                            ->with(['images', 'discounts' => function($q) {
                                $q->where('start_discount', '<=', now())
                                ->where('end_discount', '>=', now());
                            }])
                            ->get();

        $promoProducts = Product::where('is_live', true)
                            ->whereHas('label', function($q) {
                                $q->where('is_live', true);
                            })
                            ->whereHas('discounts', function($q) {
                                $q->where('start_discount', '<=', now())
                                ->where('end_discount', '>=', now());
                            })
                            ->with(['images', 'discounts' => function($q) {
                                $q->where('start_discount', '<=', now())
                                ->where('end_discount', '>=', now());
                            }])
                            ->get();

        $hasRollBannerProducts = $rollBannerProducts->count() > 0;
        $hasPromoProducts = $promoProducts->count() > 0;

        if ($productId) {
            $query->where('id', $productId);
            $product = Product::where('is_live', true)
                            ->whereHas('label', function($q) {
                                $q->where('is_live', true);
                            })
                            ->find($productId);
            $pageTitle = $product?->name ?: 'Produk';
        }
        elseif ($filter == 'promo') {
            $query->whereHas('discounts');
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $label = Label::where('is_live', true)->find($filter);
            if ($label) {
                $query->where('label_id', $filter);
                $pageTitle = $label->name;
            } else {
                $pageTitle = 'Semua Produk';
            }
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        if ($search = $request->query('search')) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        if ($sort == 'price-desc' || $sort == 'price-asc') {
            $direction = $sort == 'price-desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        }
        elseif ($sort == 'best-selling') {
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        }
        elseif ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('landingpage.home', compact(
            'labels','products','promoProducts','rollBannerProducts','hasRollBannerProducts','hasPromoProducts','filter','productId','search','sort','pageTitle','banners','testimonials','latestBlogs'
        ));
    }

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
        $labels    = Label::where('is_live', true)
                        ->whereHas('products', function($q) {
                            $q->where('is_live', true);
                        })
                        ->with(['products' => function($query) {
                            $query->where('is_live', true)->with('images');
                        }])
                        ->get();

        $labelsPerPage = 15;
        $totalLabels = $labels->count();
        
        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product');
        $sort      = $request->query('sort');
        $search    = $request->query('search');

        $query = $this->applyActiveDiscounts(Product::query());
        
        $query = $query->where('is_live', true)
                    ->whereHas('label', function($q) {
                        $q->where('is_live', true);
                    });

        if ($productId) {
            $query->where('id', $productId);
            $product = Product::where('is_live', true)
                            ->whereHas('label', function($q) {
                                $q->where('is_live', true);
                            })
                            ->find($productId);
            $pageTitle = $product?->name ?: 'Produk';
        }
        elseif ($filter == 'promo') {
            $query->whereHas('discounts', function($q) {
                $q->where('start_discount', '<=', now())
                ->where('end_discount', '>=', now());
            });
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $label = Label::where('is_live', true)
                        ->whereHas('products', function($q) {
                            $q->where('is_live', true);
                        })
                        ->find($filter);
            if ($label) {
                $query->where('label_id', $filter);
                $pageTitle = $label->name;
            } else {
                $pageTitle = 'Semua Produk';
            }
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        if ($search) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        if ($sort == 'price-desc' || $sort == 'price-asc') {
            $direction = $sort == 'price-desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        }
        elseif ($sort == 'best-selling') {
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        }
        elseif ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        $currentPage = $request->query('page', 1);
        $totalPages = $products->lastPage();
        
        if ($currentPage > $totalPages && $totalPages > 0) {
            $queryParams = $request->except(['page']);
            $queryParams['page'] = 1;
            
            return redirect()->route('landingpage.products', $queryParams);
        }

        return view('landingpage.product_all', compact(
            'labels','products','filter','productId','search','sort','pageTitle','labelsPerPage','totalLabels'
        ));
    }

    public function detailProduk(Product $product, Request $request)
    {
        if (!$product->is_live || !$product->label->is_live) {
            abort(404, 'Produk tidak ditemukan atau tidak tersedia.');
        }

        $orderProduct = null;
        $isEdit = false;

        $product->loadCount('orderProducts')
                ->load([
                    'label.finishings', 
                    'images', 
                    'variants' => function($q) {
                        $q->orderBy('category')->orderBy('value');
                    },
                    'discounts' => function($q) {
                        $q->where('start_discount', '<=', now())
                        ->where('end_discount', '>=', now());
                    }
                ]);

        $finalBase = $product->getDiscountedPrice();
        $bestDiscount = $product->getBestDiscount();

        $variantCategories = collect();
        if ($product->hasVariants()) {
            $variantCategories = $product->variants->groupBy('category')->map(function($variants, $category) {
                return [
                    'category' => $category,
                    'display_name' => ucfirst($category),
                    'variants' => $variants->map(function($variant) {
                        $numericPrice = (float) str_replace(',', '', $variant->price);
                        return [
                            'id' => $variant->id,
                            'value' => $variant->value,
                            'price' => $numericPrice,
                            'formatted_price' => $numericPrice > 0 ? '+' . number_format($numericPrice, 0, ',', '.') : '',
                            'is_available' => $variant->is_available == 1
                        ];
                    })
                ];
            })->values();
        }

        $bestProducts = Product::where('is_live', true)
            ->whereHas('label', function($q) {
                $q->where('is_live', true);
            })
            ->with([
                'images',
                'variants',
                'discounts' => function($q) {
                    $q->where('start_discount', '<=', now())
                    ->where('end_discount', '>=', now());
                }
            ])
            ->withCount('orderProducts')
            ->orderByDesc('order_products_count')
            ->limit(4)
            ->get();

        return view('landingpage.product_detail', compact(
            'product',
            'orderProduct',
            'finalBase',
            'bestProducts',
            'bestDiscount',
            'variantCategories',
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
            'product_id' => 'required|exists:products,id',
            'selected_variants' => 'nullable|array',
            'selected_variants.*' => 'exists:product_variants,id',
            'finishing_id' => 'nullable|exists:finishings,id',
            'express' => 'required|in:0,1',
            'waktu_deadline' => 'nullable|required_if:express,1|date_format:H:i',
            'kebutuhan_proofing' => 'required|in:0,1',
            'proof_qty' => 'nullable|integer|min:1',
            'order_design' => 'required|file|mimes:jpeg,jpg,png,pdf,zip,rar|max:20480',
            'preview_design' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'order_status' => 'required|in:0',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::with(['label.finishings', 'variants', 'discounts'])->findOrFail($validated['product_id']);

            if (!$product->is_live) {
                return back()->withErrors(['error' => 'Produk tidak tersedia untuk pemesanan.'])->withInput();
            }

            if (!$product->label->is_live) {
                return back()->withErrors(['error' => 'Kategori produk tidak tersedia untuk pemesanan.'])->withInput();
            }

            if ($product->hasVariants()) {
                $categories = $product->getAvailableCategories();
                $selectedVariants = $validated['selected_variants'] ?? [];
                
                if (count($selectedVariants) !== count($categories)) {
                    return back()->withErrors(['error' => 'Silakan pilih semua varian yang tersedia.'])->withInput();
                }

                foreach ($selectedVariants as $variantId) {
                    $variant = $product->variants()->find($variantId);
                    if (!$variant || $variant->is_available != 1) {
                        return back()->withErrors(['error' => 'Varian yang dipilih tidak tersedia.'])->withInput();
                    }
                }
            }

            $today = now();
            $dailyCount = Order::whereDate('created_at', $today->toDateString())->count() + 1;
            $monthlyCount = Order::whereMonth('created_at', $today->month)->count() + 1;
            $spkNumber = sprintf('%s%s%s%02d-%03d', $today->format('y'), $today->format('m'), $today->format('d'), $dailyCount, $monthlyCount);

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

            $bestDiscount = $product->getBestDiscount();
            $basePrice = (float) $product->price;

            $discountPercent = null;
            $discountFix = null;

            if ($bestDiscount) {
                if ($bestDiscount->discount_percent) {
                    $discountPercent = $bestDiscount->discount_percent;
                    $basePrice = $basePrice - ($basePrice * ($discountPercent / 100));
                } elseif ($bestDiscount->discount_fix) {
                    $discountFix = $bestDiscount->discount_fix;
                    $basePrice = max(0, $basePrice - $discountFix);
                }
            }

            $variantPrice = 0;
            $variantDetails = [];
            if ($product->hasVariants() && !empty($validated['selected_variants'])) {
                foreach ($validated['selected_variants'] as $variantId) {
                    $variant = $product->variants()->find($variantId);
                    if ($variant) {
                        $numericPrice = (float) str_replace(',', '', $variant->price);
                        $variantPrice += $numericPrice;
                        $variantDetails[] = $variant->category . ': ' . $variant->value;
                    }
                }
            }

            $finishingPrice = 0;
            $finishingName = null;
            if (!empty($validated['finishing_id']) && $fin = $product->label->finishings->find($validated['finishing_id'])) {
                $finishingPrice = $fin->finishing_price;
                $finishingName = $fin->finishing_name;
            }

            $area = 1;
            if ($product->width_product && $product->long_product && isset($validated['length']) && isset($validated['width'])) {
                $l = $validated['length'];
                $w = $validated['width'];
                
                $defaultPanjang = $product->long_product;
                $defaultLebar = $product->width_product;
                
                $finalP = $l <= $defaultPanjang ? 100 : $l;
                $finalL = $w <= $defaultLebar ? 100 : $w;
                
                $area = ($finalP / 100) * ($finalL / 100);
            }

            $productTotal = ($basePrice + $variantPrice) * $area * $validated['qty'];
            $finishingTotal = $finishingPrice * $validated['qty'];
            
            $subtotalWithoutAdd = $productTotal + $finishingTotal;
            
            $subtotal = $subtotalWithoutAdd;
            if ($validated['express'] == 1) {
                $subtotal *= 1.5;
            }

            $calculatedDeadline = null;
            if (isset($validated['waktu_deadline'])) {
                $calculatedDeadline = $today->copy()->addDays(7)->toDateString();
            }

            $order = Order::create([
                'spk' => $spkNumber,
                'user_id' => $user->id,
                'nama_pelanggan' => $user->name ?? null,
                'email_pelanggan' => $user->email ?? null,
                'kontak_pelanggan' => $user->phone ?? null,
                'order_design' => $designFileName,
                'preview_design' => $previewFileName,
                'transaction_type' => 0,
                'transaction_method' => 0,
                'payment_status' => 0,
                'order_status' => 0,
                'subtotal' => round($subtotal),
                'diskon_persen' => $discountPercent,
                'potongan_rp' => $discountFix,
                'waktu_deadline' => $validated['waktu_deadline'] ?? null,
                'deadline' => $calculatedDeadline ?? null,
                'express' => $validated['express'],
                'kebutuhan_proofing' => $validated['kebutuhan_proofing'],
                'proof_qty' => $validated['proof_qty'] ?? null,
                'pickup_status' => 0,
                'notes' => $validated['notes'] ?? null,
                'jenis_transaksi' => 2,
                'metode_transaksi' => 3,
                'metode_transaksi_paid' => 3,
                'tipe_pengambilan' => 1,
                'metode_pengiriman' => 1,
                'alamat' => $user->address ?? null,
                'kode_pos' => $user->postal_code ?? null,
                'provinsi' => $user->province ?? null,
                'kota' => $user->district ?? null,
                'kecamatan' => $user->city ?? null,
                'berat' => 1000,
                'status_pengerjaan' => 'pending',
                'proses_proofing' => 0,
                'proses_produksi' => 0,
                'proses_finishing' => 0,
                'quality_control' => 0,
                'tanggal' => $today->toDateString(),
                'waktu' => $today->toTimeString(),
                'dp' => round($subtotal),
                'full_payment' => round($subtotal),
                'design_link' => $designFileName ? env('APP_URL') . '/storage/landingpage/img/order_design/' . $designFileName : null,
                'preview_link' => $previewFileName ? env('APP_URL') . '/storage/landingpage/img/order_design/' . $previewFileName : null,
            ]);

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $validated['product_id'],
                'jenis_cetakan' => $product->label_id,
                'material_type' => $product->name,
                'jenis_bahan' => $product->id,
                'finishing_type' => $finishingName,
                'jenis_finishing' => $validated['finishing_id'] ?? null,
                'length' => $validated['length'] ?? null,
                'width' => $validated['width'] ?? null,
                'qty' => $validated['qty'],
                'subtotal' => round($subtotalWithoutAdd),
                'desain' => $designFileName ?? null,
                'preview' => $previewFileName ?? null,
                'jumlah_pesanan' => $validated['qty'],
                'panjang' => $validated['length'] ?? null,
                'lebar' => $validated['width'] ?? null,
                'variant_details' => !empty($variantDetails) ? implode(', ', $variantDetails) : null,
                'selected_variants' => !empty($validated['selected_variants']) ? json_encode($validated['selected_variants']) : null,
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
        $labels = Label::with([
            'products.images', 
            'products.variants',
            'finishings'
        ])->latest()->get();
        
        $editingLabel = null;
        if ($request->has('edit')) {
            $editingLabel = Label::with([
                'products.images', 
                'products.variants',
                'finishings'
            ])->find($request->edit);
        }
        
        return view('adminpage.product.index', compact('labels', 'editingLabel'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name_label' => 'required|string',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'is_live_label' => 'nullable|boolean',
            'name.*' => 'required|string',
            'price.*' => 'nullable|numeric',
            'has_variants.*' => 'nullable|boolean',
            'is_live_product.*' => 'nullable|boolean',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|array|max:4',
            'product_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variant_categories' => 'nullable|array',
            'variant_categories.*' => 'nullable|array',
            'variant_values' => 'nullable|array',
            'variant_values.*' => 'nullable|array',
            'variant_prices' => 'nullable|array',
            'variant_prices.*' => 'nullable|array',
            'variant_availability' => 'nullable|array',
            'variant_availability.*' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $label = Label::create([
                'name' => $request->name_label,
                'size' => $request->size,
                'unit' => $request->unit,
                'desc' => $request->desc,
                'type' => 'standart',
                'is_live' => $request->boolean('is_live_label', true)
            ]);

            if ($request->has('name')) {
                foreach ($request->name as $index => $productName) {
                    $hasVariants = $request->boolean("has_variants.{$index}", false);
                    
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
                        'has_category' => $hasVariants ? 1 : 0,
                        'is_live' => $request->boolean("is_live_product.{$index}", true)
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

                    if ($hasVariants && $request->has("variant_categories.{$index}")) {
                        $this->storeProductVariants($product, $request, $index);
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

            DB::commit();
            return redirect()->back()->with('success', 'Data Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function adminUpdate(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name_label' => 'required|string',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'is_live_label' => 'nullable|boolean',
            'name' => 'required|array|min:1',
            'name.*' => 'required|string',
            'price.*' => 'nullable|numeric',
            'has_variants.*' => 'nullable|boolean',
            'is_live_product.*' => 'nullable|boolean',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|array|max:4',
            'product_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|array',
            'existing_images.*.*' => 'nullable|string',
            'variant_ids' => 'nullable|array',
            'variant_ids.*' => 'nullable|array',
            'variant_categories' => 'nullable|array',
            'variant_categories.*' => 'nullable|array',
            'variant_values' => 'nullable|array',
            'variant_values.*' => 'nullable|array',
            'variant_prices' => 'nullable|array',
            'variant_prices.*' => 'nullable|array',
            'variant_availability' => 'nullable|array',
            'variant_availability.*' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $label->update([
                'name' => $validated['name_label'],
                'size' => $validated['size'],
                'unit' => $request->input('unit'),
                'desc' => $validated['desc'],
                'is_live' => $request->boolean('is_live_label', true)
            ]);

            $existingProductIds = $label->products()->pluck('id')->toArray();
            $submittedProductIds = [];

            foreach ($validated['name'] as $i => $nm) {
                $productId = $request->product_id[$i] ?? null;
                $hasVariants = $request->boolean("has_variants.{$i}", false);
                
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
                    'slug' => Str::slug($nm),
                    'has_category' => $hasVariants ? 1 : 0,
                    'is_live' => $request->boolean("is_live_product.{$i}", true)
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

                if ($hasVariants) {
                    $this->updateProductVariants($product, $request, $i);
                } else {
                    $product->variants()->delete();
                }
            }
            
            $productsToDelete = array_diff($existingProductIds, $submittedProductIds);
            if (!empty($productsToDelete)) {
                $products = Product::whereIn('id', $productsToDelete)->with('images', 'variants')->get();
                foreach ($products as $product) {
                    foreach ($product->images as $image) {
                        Storage::disk('public')->delete($image->image_product);
                    }
                    $product->variants()->delete();
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

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Data berhasil di-update.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function adminDestroy(Label $label)
    {
        DB::beginTransaction();
        try {
            $products = Product::where('label_id', $label->id)->with('images', 'variants')->get();
            
            foreach($products as $product) {
                foreach($product->images as $image) {
                    Storage::disk('public')->delete($image->image_product);
                }
                $product->variants()->delete();
            }

            Product::where('label_id', $label->id)->delete();
            Finishing::where('label_id', $label->id)->delete();
            
            $label->delete();

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Data berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleLabelLive(Label $label)
    {
        $label->update([
            'is_live' => !$label->is_live
        ]);

        $status = $label->is_live ? 'ditampilkan' : 'disembunyikan';
        $message = "Kategori produk {$label->name} berhasil {$status} dari website.";
        
        if (!$label->is_live) {
            $message .= " Semua sub produk dalam kategori ini juga tidak akan tampil di website.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function toggleProductLive(Product $product)
    {
        $product->update([
            'is_live' => !$product->is_live
        ]);

        $status = $product->is_live ? 'ditampilkan' : 'disembunyikan';
        $message = "Sub produk {$product->name} berhasil {$status} dari website.";
        
        if ($product->is_live && !$product->label->is_live) {
            $message .= " Namun produk ini tetap tidak akan tampil karena kategori utama ({$product->label->name}) sedang disembunyikan.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function bulkToggleProducts(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'action' => 'required|in:show,hide'
        ]);

        $isLive = $request->action == 'show';
        
        Product::whereIn('id', $request->product_ids)
            ->update(['is_live' => $isLive]);

        $action = $isLive ? 'ditampilkan' : 'disembunyikan';
        $count = count($request->product_ids);
        
        return redirect()->back()->with('success', "{$count} produk berhasil {$action}.");
    }

    private function storeProductVariants(Product $product, Request $request, int $productIndex)
    {
        if (!$request->has("variant_categories.{$productIndex}")) {
            return;
        }

        $categories = $request->input("variant_categories.{$productIndex}", []);
        $values = $request->input("variant_values.{$productIndex}", []);
        $prices = $request->input("variant_prices.{$productIndex}", []);
        $availabilities = $request->input("variant_availability.{$productIndex}", []);

        foreach ($categories as $index => $category) {
            if (empty($category) || empty($values[$index])) {
                continue;
            }

            $isAvailable = isset($availabilities[$index]) && $availabilities[$index] == '1';

            ProductVariant::create([
                'product_id' => $product->id,
                'category' => $category,
                'value' => $values[$index],
                'price' => $prices[$index] ?? 0,
                'is_available' => $isAvailable
            ]);
        }
    }

    private function updateProductVariants(Product $product, Request $request, int $productIndex)
    {
        $variantIds = $request->input("variant_ids.{$productIndex}", []);
        $categories = $request->input("variant_categories.{$productIndex}", []);
        $values = $request->input("variant_values.{$productIndex}", []);
        $prices = $request->input("variant_prices.{$productIndex}", []);
        $availabilities = $request->input("variant_availability.{$productIndex}", []);

        $processedVariantIds = [];

        foreach ($categories as $index => $category) {
            if (empty($category) || empty($values[$index])) {
                continue;
            }

            $isAvailable = isset($availabilities[$index]) && $availabilities[$index] == '1';

            $variantData = [
                'category' => $category,
                'value' => $values[$index],
                'price' => $prices[$index] ?? 0,
                'is_available' => $isAvailable
            ];

            if (!empty($variantIds[$index])) {
                $variant = $product->variants()->find($variantIds[$index]);
                if ($variant) {
                    $variant->update($variantData);
                    $processedVariantIds[] = $variant->id;
                }
            } else {
                $variant = $product->variants()->create($variantData);
                $processedVariantIds[] = $variant->id;
            }
        }

        $product->variants()->whereNotIn('id', $processedVariantIds)->delete();
    }
    
}