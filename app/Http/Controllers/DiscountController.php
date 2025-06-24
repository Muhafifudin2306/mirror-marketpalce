<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('products')
                      ->orderBy('start_discount','desc')
                      ->get();
        return view('adminpage.discount.index', compact('discounts'));
    }

    public function create()
    {
        $labels = Label::orderBy('name')->get();
        return view('adminpage.discount.form', compact('labels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'discount_fix'     => 'nullable|numeric|min:0',
            'start_discount'   => 'required|date',
            'end_discount'     => 'required|date|after_or_equal:start_discount',
            'label_id'         => 'required|exists:labels,id',
            'product_id'       => 'required|exists:products,id',
        ]);

        DB::table('discount_product')
            ->where('product_id', $data['product_id'])
            ->delete();

        $disc = Discount::create([
            'name'             => $data['name'],
            'discount_percent' => $data['discount_percent'],
            'discount_fix'     => $data['discount_fix'],
            'start_discount'   => $data['start_discount'],
            'end_discount'     => $data['end_discount'],
        ]);

        $disc->products()->attach($data['product_id']);

        return redirect()->route('admin.discount.index')
                         ->with('success','Diskon berhasil dibuat, diskon lama dihapus.');
    }

    public function edit(Discount $discount)
    {
        $labels = Label::orderBy('name')->get();

        // Produk yang sudah dipilih (pivot)
        $firstProduct = $discount->products->first();
        $selectedProductId = $firstProduct->id ?? null;
        $selectedLabelId   = $firstProduct->label_id ?? null;

        // Dropdown product berdasarkan label
        $products = $selectedLabelId
            ? Product::where('label_id', $selectedLabelId)->orderBy('name')->get()
            : collect();

        return view('adminpage.discount.form_edit', compact(
        'discount','labels','products',
        'selectedProductId','selectedLabelId'
        ));
    }


    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'name'             => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'discount_fix'     => 'nullable|numeric|min:0',
            'start_discount'   => 'required|date',
            'end_discount'     => 'required|date|after_or_equal:start_discount',
            'label_id'         => 'required|exists:labels,id',
            'product_id'       => 'required|exists:products,id',
        ]);

        DB::table('discount_product')
            ->where('product_id', $data['product_id'])
            ->delete();

        $discount->update([
            'name'             => $data['name'],
            'discount_percent' => $data['discount_percent'],
            'discount_fix'     => $data['discount_fix'],
            'start_discount'   => $data['start_discount'],
            'end_discount'     => $data['end_discount'],
        ]);

        $discount->products()->sync($data['product_id']);

        return redirect()->route('admin.discount.index')
                         ->with('success','Diskon berhasil diperbarui, diskon lama dihapus.');
    }

    public function destroy(Discount $discount)
    {
        $discount->products()->detach();
        $discount->delete();
        return back()->with('success','Diskon berhasil dihapus.');
    }

    public function productsByLabel($labelId)
    {
        $products = Product::where('label_id',$labelId)
                           ->orderBy('name')
                           ->get(['id','name']);
        return response()->json($products);
    }
}
