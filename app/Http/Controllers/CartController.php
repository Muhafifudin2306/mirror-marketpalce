<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->middleware('auth');
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $orders = Order::with('orderProducts.product.images')
               ->where('user_id', Auth::id())
               ->where('order_status', 0)
               ->get();

        $items = $orders->pluck('orderProducts')->flatten();
        $subtotal = $items->sum('subtotal');

        return view('landingpage.keranjang', [
            'items'    => $items,
            'subtotal' => $subtotal,
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

        $orderProduct->qty = $request->qty;
        $orderProduct->subtotal = $orderProduct->qty * ($orderProduct->product->price ?? 0);
        $orderProduct->save();

        $order = $orderProduct->order;
        $order->subtotal = $order->orderProducts->sum('subtotal');
        $order->save();

        return response()->json(['success' => true]);
    }

    /**
     * Hapus satu item dari keranjang
     */
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
        $product = $orderProduct->product->load('label.finishings', 'images', 'discounts');

        // Ambil diskon aktif pertama (jika ada)
        $discount = $product->discounts->first();
        $basePrice = $product->price;

        // Hitung diskon (fix atau persen)
        $finalBase = $basePrice;
        if ($discount) {
            if ($discount->discount_percent) {
                $finalBase -= $basePrice * $discount->discount_percent / 100;
            } elseif ($discount->discount_fix) {
                $finalBase -= $discount->discount_fix;
            }
        }

        return view('landingpage.product_detail', [
            'product'        => $product,
            'orderProduct'   => $orderProduct,
            'finalBase'      => $finalBase,
            'isEdit'         => true,
            'bestProducts'   => Product::with('images')
                                    ->withCount('orderProducts')
                                    ->orderByDesc('order_products_count')
                                    ->limit(4)
                                    ->get(),
        ]);
    }

    public function updateOrderProduct(Request $request, OrderProduct $orderProduct)
    {
        $validated = $request->validate([
            'finishing_id'   => 'nullable|exists:finishings,id',
            'express'        => 'required|in:0,1',
            'deadline_time'  => 'nullable|required_if:express,1|date_format:H:i',
            'needs_proofing' => 'required|in:0,1',
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
            $product = $orderProduct->product->load('label.finishings', 'discounts');

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
            $order->deadline_time  = $validated['deadline_time'] ?? null;
            $order->needs_proofing = $validated['needs_proofing'];
            $order->proof_qty      = $validated['proof_qty'] ?? null;
            $order->notes          = $validated['notes'] ?? null;

            // Hitung ulang subtotal
            $basePrice = $product->price;
            $discount  = $product->discounts->first();

            if ($discount) {
                if ($discount->discount_percent) {
                    $basePrice -= $basePrice * $discount->discount_percent / 100;
                } elseif ($discount->discount_fix) {
                    $basePrice -= $discount->discount_fix;
                }
            }

            // Hitung luas
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

            $subtotalHpl = $basePrice * $area * $validated['qty'];

            // Finishing
            $finishing = null;
            $finPrice  = 0;
            if ($validated['finishing_id']) {
                $finishing = $product->label->finishings->find($validated['finishing_id']);
                $finPrice  = $finishing->finishing_price;
            }
            $subtotalFin = $finPrice * $validated['qty'];

            // Total + express jika ada
            $newSubtotal = $subtotalHpl + $subtotalFin;
            if ($validated['express'] == 1) {
                $newSubtotal *= 1.5;
            }

            $orderProduct->update([
                'finishing_type' => $finishing->finishing_name ?? null,
                'length'         => $validated['length'] ?? null,
                'width'          => $validated['width']  ?? null,
                'qty'            => $validated['qty'],
                'subtotal'       => round($newSubtotal),
            ]);

            // Update subtotal total
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

        $item->load('product.images', 'order');

        $user = auth()->user();
        $isset = $user->province && $user->city && $user->address && $user->postal_code;

        return view('landingpage.checkout', [
            'item'  => $item,
            'order' => $order,
            'isset' => $isset,
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

        $user  = Auth::user();
        $isset = $user->province && $user->city && $user->address && $user->postal_code;

        return view('landingpage.checkout', compact(
            'order','items','subtotal','isset','item'
        ));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id() || $order->order_status != 0) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $deliveryMethod = $request->input('delivery_method');
            $deliveryCost = 0;
            $deliveryService = '';

            if ($deliveryMethod && $deliveryMethod != '0') {
                list($courierCode, $serviceCode) = explode(':', $deliveryMethod);
                
                $deliveryCost = $request->input('delivery_cost', 0);
                $deliveryService = $courierCode . ' - ' . $serviceCode;
            }

            $promoCode = $request->input('promo_code', '');
            $promoDiscount = 0;

            if ($promoCode) {
                $subtotal = $order->orderProducts->sum('subtotal');
                $now = now();

                $promo = PromoCode::where('code', $promoCode)
                    ->where('start_at', '<=', $now)
                    ->where('end_at', '>=', $now)
                    ->first();

                if ($promo) {
                    $promoDiscount = $promo->discount_percent
                        ? $subtotal * ($promo->discount_percent / 100)
                        : $promo->discount_fix;

                    if ($promo->max_discount && $promoDiscount > $promo->max_discount) {
                        $promoDiscount = $promo->max_discount;
                    }
                }
            }

            $snapToken = $this->midtransService->createSnapToken(
                $order, 
                auth()->user(), 
                $deliveryService, 
                $deliveryCost,
                $promoCode,
                $promoDiscount
            );

            $order->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'temp_data' => [
                    'notes' => $request->input('notes'),
                    'delivery_method' => $deliveryService,
                    'delivery_cost' => $deliveryCost,
                    'promo_code' => $promoCode,
                    'promo_discount' => $promoDiscount,
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

    public function paymentSuccess(Request $request, Order $order)
    {
        try {
            $order->update([
                'order_status'       => 1,
                'payment_status'     => 1,
                'paid_at'            => now(),
                'transaction_id'     => $request->input('transaction_id'),
                'transaction_method' => 1, //paid
                'notes'              => $request->input('notes'),
                'delivery_method'    => $request->input('delivery_method'),
                'delivery_cost'      => $request->input('delivery_cost', 0),
                'promocode_deduct'   => $request->input('promo_discount', 0),
            ]);

            //dd($order);

            return redirect('/keranjang')
                ->with('success','Pembayaran berhasil! Terima kasih.');
        } catch (\Exception $e) {
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

            switch ($notif['transaction_status']) {
                case 'settlement':
                case 'capture':
                    $updateData = [
                        'order_status' => 1,
                        'payment_status' => 1,
                        'paid_at' => now(),
                        'transaction_id' => $notif['transaction_id'],
                        'transaction_method' => 1, // Midtrans
                    ];

                    if (!$order->delivery_method) {
                        $updateData['delivery_method'] = 'Midtrans Payment';
                    }

                    $order->update($updateData);
                    
                    break;
                    
                case 'pending':
                    $order->update([
                        'payment_status' => 0, // Pending
                        'transaction_id' => $notif['transaction_id']
                    ]);
                    
                    break;
                    
                case 'cancel':
                case 'expire':
                case 'failure':
                case 'deny':
                    $order->update([
                        'payment_status' => 2, // Failed
                        'transaction_id' => $notif['transaction_id']
                    ]);
                    
                    break;

                default:
                    break;
            }

            return response()->json(['message' => 'OK']);

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

        $diskon = $promo->discount_percent
            ? $subtotal * ($promo->discount_percent/100)
            : $promo->discount_fix;

        if ($promo->max_discount && $diskon > $promo->max_discount) {
            $diskon = $promo->max_discount;
        }

        return response()->json([
            'valid'   => true,
            'diskon'  => round($diskon),
            'message' => 'Promo valid: potongan Rp '.number_format($diskon,0,',','.')
        ]);
    }
}
