<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Label;
use App\Models\Product;
use App\Models\Finishing;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('product-management'); 
        $labels = Label::with('products')->latest()->get();
        // dd($labels);
        $editingLabel = null;
        if ($request->has('edit')) {
            $editingLabel = Label::with('products')->find($request->edit);
        }
        return view('product.index', compact('labels', 'editingLabel'));
    }

    public function store(Request $request)
    {
        $this->authorize('product-manipulation'); 
        $request->validate([
            'name_label' => 'required|string',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'name.*' => 'required|string',
            'price.*' => 'nullable|string',
        ]);

        $label = Label::create([
            'name' => $request->name_label,
            'size' => $request->size,
            'unit' => $request->unit,
            'desc' => $request->desc,
            'type' => 'standart'
        ]);

        foreach ($request->name as $index => $productName) {
            Product::create([
                'label_id' => $label->id,
                'name' => $productName,
                'long_product' => $request->long_product[$index] ?? null,
                'width_product' => $request->width_product[$index] ?? null,
                'additional_size' => $request->additional_size[$index] ?? null,
                'additional_unit' => $request->additional_unit[$index] ?? null,
                'price' => $request->price[$index] ?? null,
                'min_qty' => $request->min_qty[$index] ?? null,
                'max_qty' => $request->max_qty[$index] ?? null,
            ]);
        }

        foreach ($request->finishing_name as $index => $finishingName) {
            Finishing::create([
                'label_id' => $label->id,
                'finishing_name' => $finishingName,
                'finishing_price' => $request->finishing_price[$index] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Data Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Label $label)
    {
        $this->authorize('product-manipulation'); 
        $validated = $request->validate([
            'name_label'        => 'required|string',
            'size'              => 'nullable|string',
            'unit'              => 'nullable|string',
            'desc'              => 'nullable|string',
            'name'              => 'required|array|min:1',
            'name.*'            => 'required|string',
            'additional_size.*' => 'nullable|string',
            'additional_unit.*' => 'nullable|string',
            'price.*'           => 'nullable|numeric',
        ], [
            'name.required' => 'Minimal 1 produk/jenis bahan diisikan.',
        ]);

        // Update label
        $label->update([
            'name' => $validated['name_label'],
            'size' => $validated['size'],
            'unit' => $request->input('unit'),
            'desc' => $validated['desc'],
            'desc' => $validated['desc'],
        ]);

        // Hapus produk lama, lalu recreate
        $label->products()->delete();
        foreach ($validated['name'] as $i => $nm) {
            $label->products()->create([
                'name'            => $nm,
                'additional_size' => $validated['additional_size'][$i] ?? null,
                'additional_unit' => $validated['additional_unit'][$i] ?? null,
                'long_product'    => $request->input('long_product')[$i] ?? null,
                'width_product'   => $request->input('width_product')[$i] ?? null,
                'price'           => $validated['price'][$i] ?? null,
                'min_qty'         => $request->input('min_qty')[$i] ?? null,
                'max_qty'         => $request->input('max_qty')[$i] ?? null,
            ]);
        }

        $label->finishings()->delete();

        foreach ($request->input('finishing_name') as $i => $nm) {
            $label->finishings()->create([
                'finishing_name'            => $nm,
                'finishing_price'           => $request->input('finishing_price')[$i] ?? null,
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Data berhasil di-update.');
    }

    public function destroy(Label $label)
    {
        $this->authorize('product-manipulation');
        $label->delete();
        Product::where('label_id', $label->id)->delete();
        Finishing::where('label_id', $label->id)->delete();

        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus.');
    }
}
