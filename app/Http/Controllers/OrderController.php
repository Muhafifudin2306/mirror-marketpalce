<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('adminpage.order.index', compact('orders'));
    }

    public function create()
    {
        $users = DB::table('users')->pluck('name', 'id');
        return view('adminpage.order.form', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'spk'               => 'nullable|string|max:100',
            'user_id'           => 'required|exists:users,id',
            'transaction_type'  => 'nullable|integer',
            'transaction_method'=> 'nullable|integer',
            'order_design'      => 'nullable|string',
            'preview_design'    => 'nullable|string',
            'paid_at'           => 'nullable|date',
            'payment_status'    => 'required|integer',
            'order_status'      => 'required|integer',
            'subtotal'          => 'required|integer',
            'discount_percent'  => 'nullable|numeric',
            'discount_fix'      => 'nullable|numeric',
            'deadline_date'     => 'nullable|date',
            'deadline_time'     => 'nullable',
            'express'           => 'nullable|integer',
            'delivery_method'   => 'nullable|string',
            'delivery_cost'     => 'nullable|integer',
            'needs_proofing'    => 'nullable|integer',
            'proof_qty'         => 'nullable|integer',
            'pickup_status'     => 'nullable|integer',
            'notes'             => 'nullable|string',
        ]);

        DB::table('orders')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.order.index')
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $order = DB::table('orders')
            ->where('orders.id', $id)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->first();

        $products = DB::table('order_products')
            ->where('order_id', $id)
            ->get();

        return view('adminpage.order.detail', compact('order', 'products'));
    }

    public function edit($id)
    {
        $order = DB::table('orders')->find($id);
        $users = DB::table('users')->pluck('name', 'id');
        return view('adminpage.order.form_edit', compact('order', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'spk'               => 'nullable|string|max:100',
            'user_id'           => 'required|exists:users,id',
            'transaction_type'  => 'nullable|integer',
            'transaction_method'=> 'nullable|integer',
            'order_design'      => 'nullable|string',
            'preview_design'    => 'nullable|string',
            'paid_at'           => 'nullable|date',
            'payment_status'    => 'required|integer',
            'order_status'      => 'required|integer',
            'subtotal'          => 'required|integer',
            'discount_percent'  => 'nullable|numeric',
            'discount_fix'      => 'nullable|numeric',
            'deadline_date'     => 'nullable|date',
            'deadline_time'     => 'nullable',
            'express'           => 'nullable|integer',
            'delivery_method'   => 'nullable|string',
            'delivery_cost'     => 'nullable|integer',
            'needs_proofing'    => 'nullable|integer',
            'proof_qty'         => 'nullable|integer',
            'pickup_status'     => 'nullable|integer',
            'notes'             => 'nullable|string',
        ]);

        DB::table('orders')->where('id', $id)
            ->update(array_merge($validated, ['updated_at' => now()]));

        return redirect()->route('admin.order.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('orders')->where('id', $id)->delete();

        return redirect()->route('admin.order.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}