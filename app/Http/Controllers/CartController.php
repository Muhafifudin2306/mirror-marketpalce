<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
     * Tambah produk ke keranjang (order draft)
     */
    public function add(Request $request, Product $product)
    {
        $order = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'order_status' => 0],
            ['subtotal' => 0, 'deadline_date' => Carbon::now()->addDay()->toDateString()]
        );

        $qty = max(1, (int)$request->input('qty', 1));

        // Jika sudah ada, tambahkan qty
        $item = $order->orderProducts()
                      ->where('product_id', $product->id)
                      ->first();

        if ($item) {
            $item->qty      += $qty;
            $item->subtotal  = $item->qty * $product->price;
            $item->save();
        } else {
            $order->orderProducts()->create([
                'product_id' => $product->id,
                'qty'        => $qty,
                'subtotal'   => $qty * $product->price,
            ]);
        }

        return redirect()->route('cart.index');
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

    /**
     * Kosongkan seluruh keranjang (hapus semua order_products)
     */
    // public function clear()
    // {
    //     $order = Order::where([
    //         ['user_id', Auth::id()],
    //         ['order_status', 0],
    //     ])->first();

    //     if ($order) {
    //         $order->orderProducts()->delete();
    //     }

    //     return back();
    // }
}
