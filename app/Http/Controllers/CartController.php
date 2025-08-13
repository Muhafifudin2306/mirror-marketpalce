<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Finishing;
use App\Models\PromoCode;
use App\Models\Notification;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->middleware('auth');
        $this->midtransService = $midtransService;
    }

    private function calculateSubtotalWithExpress($orderProduct)
    {
        $baseSubtotal = $orderProduct->subtotal;
        $isExpress = $orderProduct->order->express == 1;
        
        return $isExpress ? $baseSubtotal * 1.5 : $baseSubtotal;
    }

    private function calculateCartTotal($orders)
    {
        $total = 0;
        foreach ($orders as $order) {
            foreach ($order->orderProducts as $orderProduct) {
                $total += $this->calculateSubtotalWithExpress($orderProduct);
            }
        }
        return $total;
    }

    public function index()
    {
        $orders = Order::with('orderProducts.product.images')
               ->where('user_id', Auth::id())
               ->where('order_status', 0)
               ->get();

        $items = $orders->pluck('orderProducts')->flatten();
        $subTotal = $this->calculateCartTotal($orders);

        return view('landingpage.keranjang', [
            'items'    => $items,
            'subTotal' => $subTotal,
        ]);
    }

    /**
     * Update quantity satu item di keranjang
     */
    public function update(Request $request, OrderProduct $item)
    {
        if ($item->order->user_id != Auth::id() || $item->order->order_status != 0) {
            abort(403);
        }

        $qty = max(1, (int)$request->input('qty', $item->qty));
        $item->update([
            'qty'      => $qty,
            'subtotal' => $qty * $item->product->price,
        ]);

        return back();
    }

    public function updateQty(Request $request, OrderProduct $orderProduct)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $oldQty = $orderProduct->qty;
        $newQty = $request->qty;
        
        $pricePerUnit = $oldQty > 0 ? ($orderProduct->subtotal / $oldQty) : 0;
        
        $orderProduct->qty = $newQty;
        $orderProduct->subtotal = $pricePerUnit * $newQty;
        $orderProduct->save();

        $order = $orderProduct->order;
        $order->subtotal = $order->orderProducts->sum('subtotal');
        $order->save();

        $orders = Order::with('orderProducts')
                     ->where('user_id', Auth::id())
                     ->where('order_status', 0)
                     ->get();
        
        $newCartSubtotal = $this->calculateCartTotal($orders);
        
        $itemSubtotalWithExpress = $this->calculateSubtotalWithExpress($orderProduct);

        return response()->json([
            'success' => true,
            'newCartSubtotal' => $newCartSubtotal,
            'itemSubtotal' => $itemSubtotalWithExpress
        ]);
    }

    public function remove($orderProductId)
    {
        $orderProduct = OrderProduct::with('order')
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('order_status', 0);
            })
            ->findOrFail($orderProductId);

        $order = $orderProduct->order;

        $orderProduct->delete();

        if ($order->orderProducts()->count() == 0) {
            $order->delete();
        } else {
            $order->update([
                'subtotal' => $order->orderProducts->sum('subtotal'),
            ]);
        }

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function editOrderProduct(OrderProduct $orderProduct)
    {
        $product = $orderProduct->product->load([
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

        $bestDiscount = $product->getBestDiscount();
        $finalBase = $product->getDiscountedPrice();

        $variantCategories = collect();
        if ($product->hasVariants()) {
            $selectedVariantIds = json_decode($orderProduct->selected_variants ?? '[]', true);
            
            $variantCategories = $product->variants->groupBy('category')->map(function($variants, $category) use ($selectedVariantIds) {
                return [
                    'category' => $category,
                    'display_name' => ucfirst($category),
                    'variants' => $variants->map(function($variant) use ($selectedVariantIds) {
                        $numericPrice = (float) str_replace(',', '', $variant->price);
                        return [
                            'id' => $variant->id,
                            'value' => $variant->value,
                            'price' => $numericPrice,
                            'formatted_price' => $numericPrice > 0 ? '+' . number_format($numericPrice, 0, ',', '.') : '',
                            'is_available' => $variant->is_available == 1,
                            'is_selected' => in_array($variant->id, $selectedVariantIds)
                        ];
                    })
                ];
            })->values();
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
            'bestDiscount',
            'variantCategories'
        ))->with('isEdit', true);
    }

    public function updateOrderProduct(Request $request, OrderProduct $orderProduct)
    {
        $validated = $request->validate([
            'selected_variants' => 'nullable|array',
            'selected_variants.*' => 'exists:product_variants,id',
            'finishing_id'   => 'nullable|exists:finishings,id',
            'express'        => 'required|in:0,1',
            'waktu_deadline'  => 'nullable|required_if:express,1|date_format:H:i',
            'kebutuhan_proofing' => 'required|in:0,1',
            'proof_qty'      => 'nullable|integer|min:1',
            'order_design'   => 'nullable|file|mimes:jpeg,jpg,png,pdf,zip,rar|max:20480',
            'preview_design' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'length'         => 'nullable|numeric|min:0',
            'width'          => 'nullable|numeric|min:0',
            'notes'          => 'nullable|string|max:1000',
            'qty'            => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = $orderProduct->order;
            $product = $orderProduct->product->load(['label.finishings', 'variants', 'discounts']);

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

            if ($request->hasFile('order_design')) {
                if ($order->order_design) {
                    Storage::disk('public')->delete('landingpage/img/order_design/'.$order->order_design);
                }
                $file = $request->file('order_design');
                $name = $order->spk . '.' . $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $name, 'public');
                $order->order_design = $name;
            }

            if ($request->hasFile('preview_design')) {
                if ($order->preview_design) {
                    Storage::disk('public')->delete('landingpage/img/order_design/'.$order->preview_design);
                }
                $file = $request->file('preview_design');
                $base = pathinfo($order->order_design ?? $order->spk, PATHINFO_FILENAME);
                $name = 'preview-' . $base . '.' . $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $name, 'public');
                $order->preview_design = $name;
            }

            $order->express        = $validated['express'];
            $order->waktu_deadline  = $validated['waktu_deadline'] ?? null;
            $order->kebutuhan_proofing = $validated['kebutuhan_proofing'];
            $order->proof_qty      = $validated['proof_qty'] ?? null;
            $order->notes          = $validated['notes'] ?? null;

            $basePrice = (float) $product->price;
            $discount  = $product->getBestDiscount();

            if ($discount) {
                if ($discount->discount_percent) {
                    $basePrice -= $basePrice * $discount->discount_percent / 100;
                } elseif ($discount->discount_fix) {
                    $basePrice -= $discount->discount_fix;
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

            $area = 1;
            if (in_array($product->additional_unit, ['cm', 'm'])
                && $validated['length'] && $validated['width']
            ) {
                $l = $validated['length'];
                $w = $validated['width'];
                $area = $product->additional_unit == 'cm'
                    ? ($l / 100) * ($w / 100)
                    : $l * $w;
            }

            $subtotalHpl = ($basePrice + $variantPrice) * $area * $validated['qty'];

            $finishing = null;
            $finPrice  = 0;
            if ($validated['finishing_id']) {
                $finishing = $product->label->finishings->find($validated['finishing_id']);
                $finPrice  = $finishing ? $finishing->finishing_price : 0;
            }
            $subtotalFin = $finPrice * $validated['qty'];

            $newSubtotalWithoutExpress = $subtotalHpl + $subtotalFin;

            $orderProduct->update([
                'finishing_type' => $finishing ? $finishing->finishing_name : null,
                'jenis_finishing' => $validated['finishing_id'] ?? null,
                'length'         => $validated['length'] ?? null,
                'width'          => $validated['width']  ?? null,
                'qty'            => $validated['qty'],
                'subtotal'       => round($newSubtotalWithoutExpress),
                'variant_details' => !empty($variantDetails) ? implode(', ', $variantDetails) : null,
                'selected_variants' => !empty($validated['selected_variants']) ? json_encode($validated['selected_variants']) : null,
            ]);

            $order->subtotal = $order->orderProducts->sum('subtotal');
            $order->save();

            DB::commit();
            return redirect()->route('cart.index')->with('success', 'Order berhasil diubah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function checkoutItem(OrderProduct $item)
    {
        $order = $item->order;
        
        if ($order->user_id != Auth::id() || $order->order_status != 0) {
            abort(403, 'Akses ditolak.');
        }

        if ($order->order_status != 0) {
            return redirect()->route('cart.index')
                            ->with('error', 'Order ini sudah diproses dan tidak bisa di-checkout lagi.');
        }

        $item->load('product.images', 'order');

        $user = auth()->user();
        $isset = $user->province && $user->city && $user->address && $user->postal_code;

        $provinceName = $user->province
            ? DB::table('d_provinsi')->where('id', $user->province)->value('nama')
            : null;
        
        $districtName = $user->province
            ? DB::table('d_kabkota')->where('id', $user->district)->value('nama')
            : null;

        $cityName = $user->city
            ? DB::table('d_kecamatan')->where('id', $user->city)->value('nama')
            : null;

        $expressFee = 0;
        if ($order->express == 1) {
            $expressFee = $item->subtotal * 0.5;
        }

        return view('landingpage.checkout', [
            'item'  => $item,
            'order' => $order,
            'isset' => $isset,
            'provinceName' => $provinceName,
            'cityName'     => $cityName,
            'districtName' => $districtName,
            'expressFee' => $expressFee
        ]);
    }

    public function checkoutOrder(Order $order)
    {
        if ($order->user_id != Auth::id() || $order->order_status != 0) {
            abort(403, 'Akses ditolak.');
        }

        $items    = $order->orderProducts()->with('product.images')->get();
        $subtotal = $items->sum('subtotal');
        $item     = $items->first();

        $expressFee = 0;
        if ($order->express == 1) {
            $expressFee = $subtotal * 0.5;
        }

        $user  = Auth::user();
        $isset = $user->province && $user->city && $user->address && $user->postal_code;

        $provinceName = $user->province
            ? DB::table('d_provinsi')->where('id', $user->province)->value('nama')
            : null;
        $cityName = $user->city
            ? DB::table('d_kabkota')->where('id', $user->city)->value('nama')
            : null;

        return view('landingpage.checkout', compact(
            'order','items','subtotal','isset','item','provinceName', 'cityName','expressFee'
        ));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id() || $order->order_status != 0) {
            abort(403);
        }

        $rules = [
            'kurir' => 'required|string',
            'ongkir' => 'required|numeric',
            'notes' => 'nullable|string',
            'promo_code' => 'nullable|string',
            'address_option' => 'required|in:profile,custom,pickup'
        ];

        if ($request->address_option === 'custom') {
            $rules = array_merge($rules, [
                'custom_province' => 'required|string',
                'custom_district' => 'required|string', 
                'custom_city' => 'required|string',
                'custom_postal_code' => 'required|string',
                'custom_address' => 'required|string'
            ]);
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $deliveryMethod = $validated['kurir'];
            $deliveryCost = $validated['ongkir'];
            $deliveryService = '';

            if ($deliveryMethod && $deliveryMethod != '0') {
                if ($deliveryMethod === 'pickup:ambil_sendiri') {
                    $deliveryCost = 0;
                    $deliveryService = 'Ambil Sendiri';
                } else {
                    list($courierCode, $serviceCode) = explode(':', $deliveryMethod);
                    $deliveryService = $courierCode . ' - ' . $serviceCode;
                }
            }

            $promoCode = $validated['promo_code'] ?? '';
            $promoDiscount = 0;

            if ($promoCode) {
                $subtotal = $order->orderProducts->sum('subtotal');
                $expressFee = $order->express == 1 ? $subtotal * 0.5 : 0;
                $baseForDiscount = $subtotal + $expressFee;
                $now = now();

                $promo = PromoCode::where('code', $promoCode)
                    ->where('start_at', '<=', $now)
                    ->where('end_at', '>=', $now)
                    ->first();

                if ($promo) {
                    if ($promo->discount_percent) {
                        $promoDiscount = $baseForDiscount * ($promo->discount_percent / 100);
                    } else {
                        $promoDiscount = $promo->discount_fix;
                    }

                    if ($promo->max_discount && $promoDiscount > $promo->max_discount) {
                        $promoDiscount = $promo->max_discount;
                    }
                }
            }

            $addressData = [];
            if ($validated['address_option'] === 'custom') {
                $addressData = [
                    'provinsi' => $validated['custom_province'],
                    'kota' => $validated['custom_district'],
                    'kecamatan' => $validated['custom_city'],
                    'kode_pos' => $validated['custom_postal_code'],
                    'alamat' => $validated['custom_address']
                ];
            } elseif ($validated['address_option'] === 'pickup') {
                $addressData = [
                    'provinsi' => 'Jawa Tengah',
                    'kota' => 'Semarang',
                    'kecamatan' => 'Ambil Sendiri di Toko',
                    'kode_pos' => '50000',
                    'alamat' => 'Ambil di toko'
                ];
            } else {
                $user = auth()->user();
                $addressData = [
                    'provinsi' => $user->province,
                    'kota' => $user->district,
                    'kecamatan' => $user->city,
                    'kode_pos' => $user->postal_code,
                    'alamat' => $user->address
                ];
            }

            $snapToken = $this->midtransService->createSnapToken(
                $order, 
                auth()->user(), 
                $deliveryService, 
                $deliveryCost,
                $promoCode,
                $promoDiscount
            );

            $order->update(array_merge([
                'snap_token' => $snapToken
            ], $addressData));

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'temp_data' => [
                    'notes' => $validated['notes'] ?? null,
                    'kurir' => $deliveryService,
                    'ongkir' => $deliveryCost,
                    'promo_code' => $promoCode,
                    'promo_discount' => $promoDiscount,
                    'address_option' => $validated['address_option'],
                    'custom_province' => $validated['custom_province'] ?? null,
                    'custom_district' => $validated['custom_district'] ?? null,
                    'custom_city' => $validated['custom_city'] ?? null,
                    'custom_postal_code' => $validated['custom_postal_code'] ?? null,
                    'custom_address' => $validated['custom_address'] ?? null,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    private function createPaymentNotification($order, $status, $invoiceNumber)
    {
        $notificationData = $this->getPaymentNotificationContent($status, $invoiceNumber);
        
        if ($notificationData) {
            $notification = new Notification();
            $notification->timestamps = false;
            $notification->forceFill([
                'user_id' => $order->user_id,
                'notification_type' => 'Pembelian',
                'notification_head' => $notificationData['head'],
                'notification_body' => $notificationData['body'],
                'notification_status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ])->save();
        }
    }

    private function getPaymentNotificationContent($status, $invoiceNumber)
    {
        $notifications = [
            1 => [
                'head' => 'PEMBAYARAN PESANANMU TELAH DIKONFIRMASI',
                'body' => "Pembayaran untuk pesananmu #{$invoiceNumber} telah dikonfirmasi. Pesananmu akan segera diproses. Jangan lupa cek notifikasi dan emailmu secara berkala ya."
            ]
        ];

        return $notifications[$status] ?? null;
    }

    public function paymentSuccess(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $currentSubTotal = $order->subtotal;
            $ongkir = $request->input('ongkir', 0);
            $newSubTotal = $currentSubTotal + $ongkir;

            $kurir = $request->input('kurir');
            if ($kurir === 'pickup:ambil_sendiri') {
                $kurir = 'Ambil Sendiri';
            }

            $updateData = [
                'order_status'       => 1,
                'payment_status'     => 1,
                'paid_at'            => now(),
                'status_pengerjaan'  => 'verif_pesanan',
                'status_pembayaran'  => 2,
                'transaction_id'     => $request->input('transaction_id'),
                'transaction_method' => 1, //paid
                'metode_transaksi'   => 3,
                'metode_transaksi_paid'   => 3,
                'notes'              => $request->input('notes'),
                'kurir'              => $kurir,
                'ongkir'             => $ongkir,
                'promocode_deduct'   => $request->input('promo_discount', 0),
                'payment_at'         => Carbon::now(),
                'paid_at'            => Carbon::now(),
                'subtotal'           => $newSubTotal,
            ];

            $addressOption = $request->input('address_option');
            if ($addressOption === 'custom') {
                $updateData = array_merge($updateData, [
                    'provinsi' => $request->input('custom_province'),
                    'kota' => $request->input('custom_district'),
                    'kecamatan' => $request->input('custom_city'),
                    'kode_pos' => $request->input('custom_postal_code'),
                    'alamat' => $request->input('custom_address')
                ]);
            } elseif ($addressOption === 'pickup') {
                $updateData = array_merge($updateData, [
                    'provinsi' => 'Jawa Tengah',
                    'kota' => 'Semarang',
                    'kecamatan' => 'Ambil Sendiri di Toko',
                    'kode_pos' => '50000',
                    'alamat' => 'Ambil di toko',
                    'pickup_status' => 0,
                    'tipe_pengambilan' => 2 
                ]);
            }

            $order->update($updateData);

            $invoiceNumber = $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            $this->createPaymentNotification($order, 1, $invoiceNumber);

            $this->sendInvoiceViaFonnte($order, $invoiceNumber);

            DB::commit();

            return redirect('/keranjang')
                ->with('success','Pembayaran berhasil! Terima kasih.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/keranjang')
                ->with('error','Gagal memproses konfirmasi pembayaran.');
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            $notif = $request->all();
            
            if (!isset($notif['order_id']) || !isset($notif['status_code']) || 
                !isset($notif['gross_amount']) || !isset($notif['signature_key'])) {
                return response()->json(['message' => 'Missing required fields'], 400);
            }

            $serverKey = config('midtrans.server_key');
            $hashed = hash('sha512', $notif['order_id'] . $notif['status_code'] . $notif['gross_amount'] . $serverKey);
            
            if ($hashed != $notif['signature_key']) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $orderId = explode('-', $notif['order_id'])[0];
            $order = Order::find($orderId);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($order->transaction_id == $notif['transaction_id'] && 
                $order->payment_status == 1) {
                return response()->json(['message' => 'Already processed']);
            }

            DB::beginTransaction();
            try {
                switch ($notif['transaction_status']) {
                    case 'settlement':
                    case 'capture':
                        $updateData = [
                            'order_status' => 1,
                            'payment_status' => 1,
                            'paid_at' => now(),
                            'transaction_id' => $notif['transaction_id'],
                            'transaction_method' => 1,
                        ];

                        if (!$order->kurir) {
                            $updateData['kurir'] = 'Midtrans Payment';
                        }

                        $order->update($updateData);

                        $invoiceNumber = $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
                        $this->createPaymentNotification($order, 1, $invoiceNumber);

                        $this->sendInvoiceViaFonnte($order, $invoiceNumber);
                        
                        break;
                        
                    case 'pending':
                        $order->update([
                            'payment_status' => 0,
                            'transaction_id' => $notif['transaction_id']
                        ]);
                        
                        break;
                        
                    case 'cancel':
                    case 'expire':
                    case 'failure':
                    case 'deny':
                        $order->update([
                            'payment_status' => 2,
                            'transaction_id' => $notif['transaction_id']
                        ]);
                        
                        break;

                    default:
                        break;
                }

                DB::commit();
                return response()->json(['message' => 'OK']);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => 'Error processing callback'], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }

    public function paymentFinish(Request $request)
    {
        $orderId           = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');

        if ($orderId) {
            $realOrderId = explode('-', $orderId)[0];
            $order       = Order::find($realOrderId);

            if ($order && $order->user_id == Auth::id()) {
                switch ($transactionStatus) {
                    case 'settlement':
                    case 'capture':
                        return redirect('/keranjang')->with('success', 'Pembayaran berhasil!');
                    case 'pending':
                        return redirect('/keranjang')->with('info', 'Pembayaran sedang diproses...');
                    default:
                        return redirect('/keranjang')->with('error', 'Status pembayaran: '.$transactionStatus);
                }
            }
        }

        return redirect('/keranjang');
    }

    public function check(Request $request)
    {
        $code     = $request->query('code');
        $subtotal = floatval($request->query('subtotal', 0));
        $now      = now();

        $promo = PromoCode::where('code', $code)
            ->where('start_at','<=',$now)
            ->where('end_at','>=',$now)
            ->first();

        if (! $promo) {
            return response()->json(['valid'=>false,'message'=>'Kode promo tidak valid atau kadaluarsa.']);
        }

        if ($promo->discount_percent) {
            $expressAmount = floatval($request->query('express_fee', 0));
            $baseForDiscount = $subtotal + $expressAmount;
            $diskon = $baseForDiscount * ($promo->discount_percent/100);
        } else {
            $diskon = $promo->discount_fix;
        }

        if ($promo->max_discount && $diskon > $promo->max_discount) {
            $diskon = $promo->max_discount;
        }

        return response()->json([
            'valid'   => true,
            'diskon'  => round($diskon),
            'message' => 'Promo valid: potongan Rp '.number_format($diskon,0,',','.')
        ]);
    }

    private function sendInvoiceViaFonnte($order, $invoiceNumber)
    {
        try {
            $invoiceUrl = route('invoice', ['id' => $order->id, 'invoice' => $order->spk]);
            
            $phoneNumber = $order->user->phone ?? null;
            
            if (!$phoneNumber) {
                Log::warning("No phone number found for order {$order->id}");
                return false;
            }
            
            $rawNumber = $phoneNumber;
            if (preg_match('/^0/', $rawNumber)) {
                $customerNumber = preg_replace('/^0/', '62', $rawNumber);
            } else {
                $customerNumber = $rawNumber;
            }
            
            $namaPelanggan = $order->user->name ?? 'Customer';
            
            $items = $order->orderProducts()->with('product')->get();
            $detailPesanan = [];
            $subtotalBarang = 0;
            
            foreach ($items as $item) {
                $product = $item->product;
                $qty = $item->qty;
                
                $productName = $product->name;
                if ($item->variant_details) {
                    $productName .= ' (' . $item->variant_details . ')';
                }
                
                $sizeText = '';
                if ($item->length && $item->width) {
                    $sizeText = " - {$item->length} x {$item->width} cm";
                }
                
                $itemTotal = $item->subtotal;
                $subtotalBarang += $itemTotal;

                $detailPesanan[] = "• {$productName}{$sizeText} × {$qty} = *Rp " . number_format($itemTotal, 0, ',', '.') . "*";

                if ($item->finishing_type && $item->jenis_finishing) {
                    $finishingRecord = Finishing::find($item->jenis_finishing);
                    if ($finishingRecord) {
                        $finishingPrice = $finishingRecord->finishing_price * $qty;
                        $subtotalBarang += $finishingPrice;
                        $detailPesanan[] = "• {$item->finishing_type} × {$qty} = *Rp " . number_format($finishingPrice, 0, ',', '.') . "*";
                    }
                }
            }
            
            $expressFee = 0;
            if ($order->express == 1) {
                $expressFee = $subtotalBarang * 0.5;
                $detailPesanan[] = "• Kebutuhan Express (+50%) = *Rp " . number_format($expressFee, 0, ',', '.') . "*";
            }
            
            $ongkir = $order->ongkir ?? 0;
            if ($ongkir > 0) {
                $kurirName = $order->kurir ?? 'Kurir';
                $detailPesanan[] = "• Pengiriman {$kurirName} = *Rp " . number_format($ongkir, 0, ',', '.') . "*";
            }
            
            $totalSebelumDiskon = $subtotalBarang + $expressFee + $ongkir;

            if ($order->promocode_deduct > 0) {
                $detailPesanan[] = "• Diskon Promo = *- Rp " . number_format($order->promocode_deduct, 0, ',', '.') . "*";
                $totalSebelumDiskon -= $order->promocode_deduct;
            }
            
            $detailPesananText = implode("\n", $detailPesanan);
            $grandTotal = max(0, $totalSebelumDiskon);
            
            $infoTambahan = '';
            if ($order->express == 1 && $order->waktu_deadline) {
                $infoTambahan .= "\n⚡ *Express Order* - Deadline: {$order->waktu_deadline}";
            }
            
            if ($order->notes) {
                $infoTambahan .= "\n📝 *Catatan:* {$order->notes}";
            }
            
            $alamatPengiriman = '';
            if ($order->alamat) {
                $alamatPengiriman = "\n🏠 *Alamat Pengiriman:*\n{$order->alamat}";
                if ($order->kecamatan || $order->kota || $order->provinsi) {
                    $alamatPengiriman .= "\n{$order->kecamatan}, {$order->kota}, {$order->provinsi}";
                }
                if ($order->kode_pos) {
                    $alamatPengiriman .= " {$order->kode_pos}";
                }
            }
            
            $messageText = "🎉 *Pembayaran Berhasil!*\n\n";
            $messageText .= "Halo *{$namaPelanggan}*,\n\n";
            $messageText .= "Terima kasih! Pembayaran untuk Invoice *{$invoiceNumber}* telah berhasil dikonfirmasi melalui Midtrans.\n\n";
            $messageText .= "📋 *DETAIL PESANAN:*\n";
            $messageText .= "{$detailPesananText}\n\n";
            $messageText .= "💰 *TOTAL DIBAYAR: Rp " . number_format($grandTotal, 0, ',', '.') . "*\n";
            $messageText .= $infoTambahan;
            $messageText .= $alamatPengiriman;
            $messageText .= "\n\n📄 *Download Invoice:*\n{$invoiceUrl}\n\n";
            $messageText .= "✅ *Status:* Pembayaran Berhasil - Pesanan akan segera diproses\n\n";
            $messageText .= "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n";
            $messageText .= "Salam hangat,\n";
            $messageText .= "*Sinau Print*";
            
            $response = Http::withHeaders([
                'Authorization' => config('whatsapp.fonnte_token'),
                'Accept'        => 'application/json',
            ])->asForm()->post(config('whatsapp.fonnte_url'), [
                'target'  => $customerNumber,
                'message' => $messageText,
            ]);
            
            if ($response->successful()) {
                Log::info("✅ SUCCESS: Invoice sent via Fonnte", [
                    'order_id' => $order->id,
                    'phone' => $customerNumber,
                    'invoice_url' => $invoiceUrl,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error("❌ FAILED: Invoice sending via Fonnte", [
                    'order_id' => $order->id,
                    'phone' => $customerNumber,
                    'response_status' => $response->status(),
                    'response_body' => $response->body()
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error("Error sending invoice via Fonnte: " . $e->getMessage());
            return false;
        }
    }
}