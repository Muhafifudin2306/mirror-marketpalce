<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
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

        $items = $orders->pluck('orderProducts')->flatten(); // Gabungkan semua orderProducts
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
        // Pastikan item milik user dan masih draft
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

        // Update subtotal di order
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

        if ($order->orderProducts()->count() === 0) {
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
        $product = $orderProduct->product->load('label.finishings', 'images');

        // Casting nilai yg dibutuhkan
        $editData = [
            'orderProduct'   => $orderProduct,
            'product'        => $product,
            'finalBasePrice' => $product->price
                - ($product->discount_percent ? ($product->price * $product->discount_percent / 100) : 0)
                - ($product->discount_fix ?? 0),
        ];

        return view('landingpage.product_detail', $editData + [
            'bestProducts' => Product::with('images')
                ->withCount('orderProducts')
                ->orderByDesc('order_products_count')
                ->limit(4)
                ->get(),
        ]);
    }

    // 2. Proses update OrderProduct
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
            $product = $orderProduct->product->load('label.finishings');

            // 1) Handle upload file desain utama ke tabel orders
            if ($request->hasFile('order_design')) {
                // hapus file lama jika ada
                if ($order->order_design) {
                    Storage::disk('public')->delete('landingpage/img/order_design/'.$order->order_design);
                }
                $file   = $request->file('order_design');
                $name   = $order->spk .'.'. $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $name, 'public');
                $order->order_design = $name;
            }

            // 2) Handle upload preview desain
            if ($request->hasFile('preview_design')) {
                if ($order->preview_design) {
                    Storage::disk('public')->delete('landingpage/img/order_design/'.$order->preview_design);
                }
                $file   = $request->file('preview_design');
                $base   = pathinfo($order->order_design ?? $order->spk, PATHINFO_FILENAME);
                $name   = 'preview-'. $base .'.'. $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $name, 'public');
                $order->preview_design = $name;
            }

            // 3) Update kolom pada Order
            $order->express        = $validated['express'];
            $order->deadline_time  = $validated['deadline_time'] ?? null;
            $order->needs_proofing = $validated['needs_proofing'];
            $order->proof_qty      = $validated['proof_qty'] ?? null;
            $order->notes          = $validated['notes'] ?? null;

            // 4) Hitung ulang subtotal di OrderProduct
            // a) Base price diskon
            $basePrice = $product->price
                - ($product->discount_percent ? ($product->price * $product->discount_percent / 100) : 0)
                - ($product->discount_fix ?? 0);

            // b) Luas (jika unit cm atau m)
            $area = 1;
            if (in_array($product->additional_unit, ['cm','m'])
                && $validated['length'] && $validated['width']
            ) {
                $l = $validated['length'];
                $w = $validated['width'];
                $area = $product->additional_unit === 'cm'
                    ? ($l / 100) * ($w / 100)
                    : $l * $w;
            }

            // c) Harga HPL × qty
            $subtotalHpl = $basePrice * $area * $validated['qty'];

            // d) Finishing
            $finishing = null;
            $finPrice  = 0;
            if ($validated['finishing_id']) {
                $finishing = $product->label->finishings
                                ->find($validated['finishing_id']);
                $finPrice  = $finishing->finishing_price;
            }
            $subtotalFin = $finPrice * $validated['qty'];

            // e) Total sebelum express
            $newSubtotal = $subtotalHpl + $subtotalFin;

            // f) Express +50%
            if ($validated['express'] == 1) {
                $newSubtotal *= 1.5;
            }

            // 5) Simpan OrderProduct
            $orderProduct->update([
                'finishing_type' => $finishing->finishing_name ?? null,
                'length'         => $validated['length'] ?? null,
                'width'          => $validated['width']  ?? null,
                'qty'            => $validated['qty'],
                'subtotal'       => round($newSubtotal),
            ]);

            // 6) Simpan subtotal ke Order
            $order->subtotal = $order->orderProducts->sum('subtotal');
            $order->save();

            DB::commit();
            return redirect()->route('cart.index')
                            ->with('success', 'Order berhasil diubah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])
                        ->withInput();
        }
    }

    public function checkoutItem(OrderProduct $item)
    {
        $order = $item->order;
        
        // Validasi: milik user & status masih 0 (keranjang)
        if ($order->user_id !== Auth::id() || $order->order_status !== 0) {
            abort(403, 'Akses ditolak.');
        }

        // Eager load relasi yang dibutuhkan
        $item->load('product.images', 'order');

        // Cek kelengkapan alamat user
        $user = auth()->user();
        $isset = $user->province && $user->city && $user->address && $user->postal_code;

        // Kirim ke view checkout
        return view('landingpage.checkout', [
            'item'  => $item,
            'order' => $order,
            'isset' => $isset,
        ]);
    }

    // public function processPayment(Request $request, Order $order)
    // {
    //     if ($order->user_id !== Auth::id() || $order->order_status !== 0) {
    //         abort(403);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $deliveryMethod = $request->input('delivery_method');
    //         $deliveryCost = 0;
    //         $deliveryService = '';

    //         if ($deliveryMethod && $deliveryMethod !== '0') {
    //             list($courierCode, $serviceCode) = explode(':', $deliveryMethod);
                
    //             $deliveryCost = $request->input('delivery_cost', 0);
    //             $deliveryService = $courierCode . ' - ' . $serviceCode;
    //         }

    //         $order->update([
    //             'notes' => $request->input('notes'),
    //             'delivery_method' => $deliveryService,
    //             'delivery_cost' => $deliveryCost,
    //         ]);

    //         // Buat Snap Token
    //         $snapToken = $this->midtransService->createSnapToken(
    //             $order, 
    //             auth()->user(), 
    //             $deliveryService, 
    //             $deliveryCost
    //         );

    //         $order->update([
    //             'snap_token' => $snapToken
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'snap_token' => $snapToken,
    //             'order_id' => $order->id
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollback();
            
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function paymentSuccess(Request $request, Order $order)
    // {
    //     try {
    //         // Validasi signature dari Midtrans (opsional tapi direkomendasikan)
            
    //         // Update status order
    //         $order->update([
    //             'order_status' => 1,
    //             'payment_status' => 1,
    //             'paid_at' => now(),
    //             'transaction_id' => $request->input('transaction_id')
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Pembayaran berhasil'
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal memproses konfirmasi pembayaran'
    //         ], 500);
    //     }
    // }

    // public function paymentCallback(Request $request)
    // {
    //     try {
    //         // Handle callback dari Midtrans
    //         $notif = $request->all();
            
    //         // Validasi signature
    //         $serverKey = config('midtrans.server_key');
    //         $hashed = hash('sha512', $notif['order_id'] . $notif['status_code'] . $notif['gross_amount'] . $serverKey);
            
    //         if ($hashed !== $notif['signature_key']) {
    //             return response()->json(['message' => 'Invalid signature'], 403);
    //         }

    //         // Ambil order_id asli (hapus timestamp)
    //         $orderId = explode('-', $notif['order_id'])[0];
    //         $order = Order::find($orderId);

    //         if (!$order) {
    //             return response()->json(['message' => 'Order not found'], 404);
    //         }

    //         // Update status berdasarkan status dari Midtrans
    //         switch ($notif['transaction_status']) {
    //             case 'settlement':
    //             case 'capture':
    //                 $order->update([
    //                     'order_status' => 1,
    //                     'payment_status' => 1,
    //                     'paid_at' => now(),
    //                     'transaction_id' => $notif['transaction_id']
    //                 ]);
    //                 break;
                    
    //             case 'pending':
    //                 $order->update([
    //                     'payment_status' => 0,
    //                     'transaction_id' => $notif['transaction_id']
    //                 ]);
    //                 break;
                    
    //             case 'cancel':
    //             case 'expire':
    //             case 'failure':
    //                 $order->update([
    //                     'payment_status' => 2, // Failed
    //                     'transaction_id' => $notif['transaction_id']
    //                 ]);
    //                 break;
    //         }

    //         return response()->json(['message' => 'OK']);

    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error processing callback'], 500);
    //     }
    // }
    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id() || $order->order_status !== 0) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $deliveryMethod = $request->input('delivery_method');
            $deliveryCost = 0;
            $deliveryService = '';

            if ($deliveryMethod && $deliveryMethod !== '0') {
                list($courierCode, $serviceCode) = explode(':', $deliveryMethod);
                
                $deliveryCost = $request->input('delivery_cost', 0);
                $deliveryService = $courierCode . ' - ' . $serviceCode;
            }

            // HAPUS UPDATE INI - jangan update order sebelum pembayaran berhasil
            // $order->update([
            //     'notes' => $request->input('notes'),
            //     'delivery_method' => $deliveryService,
            //     'delivery_cost' => $deliveryCost,
            // ]);

            // Buat Snap Token
            $snapToken = $this->midtransService->createSnapToken(
                $order, 
                auth()->user(), 
                $deliveryService, 
                $deliveryCost
            );

            // Hanya update snap_token
            $order->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                // Kirim data untuk disimpan sementara di frontend
                'temp_data' => [
                    'notes' => $request->input('notes'),
                    'delivery_method' => $deliveryService,
                    'delivery_cost' => $deliveryCost,
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
            // Update semua data sekaligus saat pembayaran berhasil
            $order->update([
                'order_status' => 1,
                'payment_status' => 1,
                'paid_at' => now(),
                'transaction_id' => $request->input('transaction_id'),
                'transaction_method' => 1, // Midtrans
                'notes' => $request->input('notes'),
                'delivery_method' => $request->input('delivery_method'),
                'delivery_cost' => $request->input('delivery_cost', 0),
            ]);
            dd($order);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses konfirmasi pembayaran'
            ], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            // Log incoming notification untuk debugging
            \Log::info('Midtrans Notification:', $request->all());

            $notif = $request->all();
            
            // Validasi field wajib
            if (!isset($notif['order_id']) || !isset($notif['status_code']) || 
                !isset($notif['gross_amount']) || !isset($notif['signature_key'])) {
                \Log::error('Missing required fields in Midtrans notification');
                return response()->json(['message' => 'Missing required fields'], 400);
            }

            // Validasi signature
            $serverKey = config('midtrans.server_key');
            $hashed = hash('sha512', $notif['order_id'] . $notif['status_code'] . $notif['gross_amount'] . $serverKey);
            
            if ($hashed !== $notif['signature_key']) {
                \Log::error('Invalid signature from Midtrans', [
                    'expected' => $hashed,
                    'received' => $notif['signature_key']
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Ambil order_id asli (hapus timestamp)
            $orderId = explode('-', $notif['order_id'])[0];
            $order = Order::find($orderId);

            if (!$order) {
                \Log::error('Order not found: ' . $orderId);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Cek apakah notifikasi untuk transaksi yang sama sudah diproses
            if ($order->transaction_id === $notif['transaction_id'] && 
                $order->payment_status == 1) {
                \Log::info('Duplicate notification for order: ' . $orderId);
                return response()->json(['message' => 'Already processed']);
            }

            // Update status berdasarkan status dari Midtrans
            switch ($notif['transaction_status']) {
                case 'settlement':
                case 'capture':
                    // Pembayaran berhasil - update lengkap
                    $updateData = [
                        'order_status' => 1,
                        'payment_status' => 1,
                        'paid_at' => now(),
                        'transaction_id' => $notif['transaction_id'],
                        'transaction_method' => 1, // Midtrans
                    ];

                    // Jika delivery_method, notes, delivery_cost belum ada, 
                    // bisa diambil dari data sementara atau set default
                    if (!$order->delivery_method) {
                        $updateData['delivery_method'] = 'Midtrans Payment';
                    }

                    $order->update($updateData);
                    
                    \Log::info('Payment success for order: ' . $orderId);
                    break;
                    
                case 'pending':
                    $order->update([
                        'payment_status' => 0, // Pending
                        'transaction_id' => $notif['transaction_id']
                    ]);
                    
                    \Log::info('Payment pending for order: ' . $orderId);
                    break;
                    
                case 'cancel':
                case 'expire':
                case 'failure':
                case 'deny':
                    // Pembayaran gagal - hanya update status, data lain tetap untuk retry
                    $order->update([
                        'payment_status' => 2, // Failed
                        'transaction_id' => $notif['transaction_id']
                    ]);
                    
                    \Log::info('Payment failed for order: ' . $orderId . ' Status: ' . $notif['transaction_status']);
                    break;

                default:
                    \Log::warning('Unknown transaction status: ' . $notif['transaction_status']);
                    break;
            }

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            \Log::error('Error processing Midtrans callback: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }

    // Tambahan di CartController
    public function paymentFinish(Request $request)
    {
        // Handle redirect dari Midtrans setelah pembayaran
        $orderId = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');
        
        if ($orderId) {
            // Parse order_id asli
            $realOrderId = explode('-', $orderId)[0];
            $order = Order::find($realOrderId);
            
            if ($order && $order->user_id === Auth::id()) {
                switch ($transactionStatus) {
                    case 'settlement':
                    case 'capture':
                        return redirect('/keranjang')->with('success', 'Pembayaran berhasil!');
                        
                    case 'pending':
                        return redirect('/keranjang')->with('info', 'Pembayaran sedang diproses...');
                        
                    case 'cancel':
                    case 'expire':
                    case 'failure':
                        return redirect('/keranjang')->with('error', 'Pembayaran gagal atau dibatalkan.');
                        
                    default:
                        return redirect('/keranjang')->with('info', 'Status pembayaran: ' . $transactionStatus);
                }
            }
        }
        
        return redirect('/keranjang');
    }

}
