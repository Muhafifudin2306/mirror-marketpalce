<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Label;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Notification;
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
        // Custom validation rules based on apply_to_all checkbox
        $rules = [
            'name'             => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'discount_fix'     => 'nullable|numeric|min:0',
            'start_discount'   => 'required|date',
            'end_discount'     => 'required|date|after_or_equal:start_discount',
            'apply_to_all'     => 'nullable|boolean',
        ];

        // If apply_to_all is not checked, make label_id and product_id required
        if (!$request->has('apply_to_all') || !$request->apply_to_all) {
            $rules['label_id'] = 'required|exists:labels,id';
            $rules['product_id'] = 'required|exists:products,id';
        }

        $data = $request->validate($rules);

        // Check if trying to create "all products" discount
        if ($request->has('apply_to_all') && $request->apply_to_all) {
            // Check if there's already an active "all products" discount in the same period
            $totalProducts = Product::count();
            
            // Get all discounts with product count
            $discountsWithCount = Discount::select('discounts.*')
                ->selectRaw('(SELECT COUNT(DISTINCT dp.product_id) FROM discount_product dp WHERE dp.discount_id = discounts.id) as product_count')
                ->having('product_count', '=', $totalProducts)
                ->where(function($query) use ($data) {
                    $query->whereBetween('start_discount', [$data['start_discount'], $data['end_discount']])
                          ->orWhereBetween('end_discount', [$data['start_discount'], $data['end_discount']])
                          ->orWhere(function($q) use ($data) {
                              $q->where('start_discount', '<=', $data['start_discount'])
                                ->where('end_discount', '>=', $data['end_discount']);
                          });
                })
                ->first();

            if ($discountsWithCount) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Sudah ada diskon yang diterapkan ke semua produk dalam periode tersebut. Hanya boleh ada satu diskon "Semua Produk" yang aktif.');
            }
        }

        DB::beginTransaction();
        try {
            // Create the discount
            $discount = Discount::create([
                'name'             => $data['name'],
                'discount_percent' => $data['discount_percent'],
                'discount_fix'     => $data['discount_fix'],
                'start_discount'   => $data['start_discount'],
                'end_discount'     => $data['end_discount'],
            ]);

            if ($request->has('apply_to_all') && $request->apply_to_all) {
                // Apply discount to all products
                $allProductIds = Product::pluck('id')->toArray();
                
                // Attach discount to all products WITHOUT removing from other discounts
                $discount->products()->attach($allProductIds);
                
                $message = 'Diskon berhasil dibuat dan diterapkan ke semua produk.';
                $productNamePart = 'SEMUA ITEM';
            } else {
                // Apply discount to specific product WITHOUT removing from other discounts
                $discount->products()->attach($data['product_id']);
                
                $message = 'Diskon berhasil dibuat.';
                $single = Product::find($data['product_id']);
                $productNamePart = $single ? $single->name : '';
            }

            // Format bagian diskon (percent / fix)
            if ($discount->discount_percent !== null) {
                $discountPart = $discount->discount_percent . '% OFF';
            } else {
                $discountPart = 'Rp' . number_format($discount->discount_fix, 0, ',', '.') . ' OFF';
            }

            // Format tanggal dalam bahasa Indonesia
            $startDate = Carbon::parse($discount->start_discount)
                            ->locale('id')->isoFormat('D MMM YYYY');
            $endDate   = Carbon::parse($discount->end_discount)
                            ->locale('id')->isoFormat('D MMM YYYY');

            // Siapkan head & body, lalu uppercase head
            $head = "🎉🎉 JANGAN LUPA CHECKOUT {$discount->name}, {$discountPart} PADA ITEM {$productNamePart}";
            $head = mb_strtoupper($head, 'UTF-8');

            $body = "Promo {$discount->name} dari tanggal {$startDate} - {$endDate}. Checkout Sekarang!";

            // Buat notifikasi dengan timestamp diskon
            $notif = new Notification();
            $notif->timestamps = false; // matikan auto‐timestamps
            $notif->forceFill([
                'user_id'           => null,
                'notification_type' => 'Promo',
                'notification_head' => $head,
                'notification_body' => $body,
                'created_at'        => $discount->created_at,
                'updated_at'        => $discount->created_at,
            ])->save();

            DB::commit();
            
            return redirect()->route('admin.discount.index')
                           ->with('success', $message);
                           
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan diskon: ' . $e->getMessage());
        }
    }

    public function edit(Discount $discount)
    {
        $labels = Label::orderBy('name')->get();

        // Check if discount is applied to all products
        $totalProducts = Product::count();
        $discountProductsCount = $discount->products()->count();
        $isAppliedToAll = ($discountProductsCount == $totalProducts && $totalProducts > 0);

        // Get first product for single product discount
        $firstProduct = $discount->products->first();
        $selectedProductId = $firstProduct->id ?? null;
        $selectedLabelId   = $firstProduct->label_id ?? null;

        // Dropdown product based on label (only if not applied to all)
        $products = (!$isAppliedToAll && $selectedLabelId)
            ? Product::where('label_id', $selectedLabelId)->orderBy('name')->get()
            : collect();

        return view('adminpage.discount.form_edit', compact(
            'discount', 'labels', 'products',
            'selectedProductId', 'selectedLabelId', 'isAppliedToAll'
        ));
    }

    public function update(Request $request, Discount $discount)
    {
        // Custom validation rules based on apply_to_all checkbox
        $rules = [
            'name'             => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'discount_fix'     => 'nullable|numeric|min:0',
            'start_discount'   => 'required|date',
            'end_discount'     => 'required|date|after_or_equal:start_discount',
            'apply_to_all'     => 'nullable|boolean',
        ];

        // If apply_to_all is not checked, make label_id and product_id required
        if (!$request->has('apply_to_all') || !$request->apply_to_all) {
            $rules['label_id'] = 'required|exists:labels,id';
            $rules['product_id'] = 'required|exists:products,id';
        }

        $data = $request->validate($rules);

        // Check if trying to update to "all products" discount
        if ($request->has('apply_to_all') && $request->apply_to_all) {
            $totalProducts = Product::count();
            
            // Cek apakah discount yang sedang diedit saat ini sudah "all products"
            $currentDiscountProductsCount = $discount->products()->count();
            $isCurrentlyAllProducts = ($currentDiscountProductsCount == $totalProducts && $totalProducts > 0);
            
            // Jika discount saat ini BUKAN "all products", maka perlu cek conflict
            if (!$isCurrentlyAllProducts) {
                // Cek apakah ada discount lain yang "all products" dalam periode yang sama
                $conflictingDiscount = Discount::select('discounts.*')
                    ->selectRaw('(SELECT COUNT(DISTINCT dp.product_id) FROM discount_product dp WHERE dp.discount_id = discounts.id) as product_count')
                    ->where('id', '!=', $discount->id) // Exclude current discount
                    ->having('product_count', '=', $totalProducts)
                    ->where(function($query) use ($data) {
                        $query->whereBetween('start_discount', [$data['start_discount'], $data['end_discount']])
                            ->orWhereBetween('end_discount', [$data['start_discount'], $data['end_discount']])
                            ->orWhere(function($q) use ($data) {
                                $q->where('start_discount', '<=', $data['start_discount'])
                                    ->where('end_discount', '>=', $data['end_discount']);
                            });
                    })
                    ->first();

                if ($conflictingDiscount) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Sudah ada diskon lain yang diterapkan ke semua produk dalam periode tersebut. Hanya boleh ada satu diskon "Semua Produk" yang aktif.');
                }
            }
            // Jika discount saat ini sudah "all products", maka tetap boleh update (karena tidak menambah conflict baru)
        }

        DB::beginTransaction();
        try {
            // Update the discount
            $discount->update([
                'name'             => $data['name'],
                'discount_percent' => $data['discount_percent'],
                'discount_fix'     => $data['discount_fix'],
                'start_discount'   => $data['start_discount'],
                'end_discount'     => $data['end_discount'],
            ]);

            // First, detach all products from THIS discount only
            $discount->products()->detach();

            if ($request->has('apply_to_all') && $request->apply_to_all) {
                // Apply discount to all products
                $allProductIds = Product::pluck('id')->toArray();
                
                // Attach this discount to all products WITHOUT removing from other discounts
                $discount->products()->attach($allProductIds);
                
                $message = 'Diskon berhasil diperbarui dan diterapkan ke semua produk.';
            } else {
                // Apply discount to specific product WITHOUT removing from other discounts
                $discount->products()->attach($data['product_id']);
                
                $message = 'Diskon berhasil diperbarui.';
            }

            DB::commit();
            
            return redirect()->route('admin.discount.index')
                        ->with('success', $message);
                        
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan saat memperbarui diskon: ' . $e->getMessage());
        }
    }

    public function destroy(Discount $discount)
    {
        DB::beginTransaction();
        try {
            // Only detach products from THIS discount
            $discount->products()->detach();
            $discount->delete();
            
            DB::commit();
            return back()->with('success', 'Diskon berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menghapus diskon: ' . $e->getMessage());
        }
    }

    public function productsByLabel($labelId)
    {
        $products = Product::where('label_id', $labelId)
                           ->orderBy('name')
                           ->get(['id', 'name']);
        return response()->json($products);
    }
}