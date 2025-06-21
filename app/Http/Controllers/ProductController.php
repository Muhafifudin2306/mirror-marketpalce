<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Order;
use App\Models\Product;
use App\Models\Finishing;
use App\Models\Pengarang;
use Spatie\PdfToImage\Pdf;
use App\Exports\BukuExport;
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
    public function home(Request $request)
    {
        $labels    = Label::with('products.images')->get();

        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product', null);
        $sort      = $request->query('sort', null);

        $query = Product::with('images', 'label');

        if ($productId) {
            $query->where('id', $productId);
            $pageTitle = Product::find($productId)->name ?? 'Produk';
        }
        elseif ($filter === 'promo') {
            $query->where(fn($q) =>
                $q->whereNotNull('discount_percent')
                ->orWhereNotNull('discount_fix')
            );
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $query->where('label_id', $filter);
            $pageTitle = Label::find($filter)->name ?? 'Produk';
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        $search    = $request->query('search', null);
        if ($search) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting
        if ($sort === 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'price-asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'best-selling') {
            // hitung total terjual via relation orderProducts
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate & keep query string
        $products = $query->paginate(20)->withQueryString();

        return view('landingpage.home', [
            'labels'    => $labels,
            'products'  => $products,
            'filter'    => $filter,
            'product'   => $productId,
            'search'    => $search,
            'sort'      => $sort,
            'pageTitle' => $pageTitle,
        ]);
    }

    public function filterProduk(Request $request)
    {
        $labels    = Label::with('products.images')->get();

        $filter    = $request->query('filter', 'all');
        $productId = $request->query('product', null);
        $sort      = $request->query('sort', null);

        $query = Product::with('images', 'label');

        if ($productId) {
            $query->where('id', $productId);
            $pageTitle = Product::find($productId)->name ?? 'Produk';
        }
        elseif ($filter === 'promo') {
            $query->where(fn($q) =>
                $q->whereNotNull('discount_percent')
                ->orWhereNotNull('discount_fix')
            );
            $pageTitle = 'Promo';
        }
        elseif (is_numeric($filter)) {
            $query->where('label_id', $filter);
            $pageTitle = Label::find($filter)->name ?? 'Produk';
        }
        else {
            $pageTitle = 'Semua Produk';
        }

        $search    = $request->query('search', null);
        if ($search) {
            SearchHistory::create(['term' => $search]);
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting
        if ($sort === 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'price-asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'best-selling') {
            // hitung total terjual via relation orderProducts
            $query->withCount('orderProducts')->orderBy('order_products_count', 'desc');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate & keep query string
        $products = $query->paginate(20)->withQueryString();

        // $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('landingpage.product_all', [
            'labels'    => $labels,
            'products'  => $products,
            'filter'    => $filter,
            'product'   => $productId,
            'search'    => $search,
            'sort'      => $sort,
            'pageTitle' => $pageTitle,
            // 'notifications' => $notifications,
        ]);
    }

    /**
     * Detail buku landingpage
     */
    public function detailProduk(Product $product, Request $request)
    {
        // Simpan pencarian jika ada
        $search = $request->query('search', null);
        if ($search) {
            SearchHistory::create(['term' => $search]);
        }

        $product->loadCount('orderProducts')
            ->load('label.finishings');

        $bestProducts = Product::with('images')
            ->withCount('orderProducts')
            ->orderByDesc('order_products_count')
            ->limit(4)
            ->get();
        // $rating = (float) $product->rating;

        return view('landingpage.product_detail', [
            'product' => $product,
            'search'  => $search,
            'bestProducts'  => $bestProducts,
            // 'rating'  => $rating,
        ]);
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
            $product = Product::with('label.finishings')->findOrFail($validated['product_id']);

            // Generate SPK
            $today        = now();
            $dailyCount   = Order::whereDate('created_at', $today->toDateString())->count() + 1;
            $monthlyCount = Order::whereMonth('created_at', $today->month)->count() + 1;
            $spkNumber    = sprintf(
                '%s%s%s%02d-%03d',
                $today->format('y'),
                $today->format('m'),
                $today->format('d'),
                $dailyCount,
                $monthlyCount
            );

            // Simpan file desain
            $designFileName  = null;
            if ($request->hasFile('order_design')) {
                $file = $request->file('order_design');
                $ext  = $file->getClientOriginalExtension();
                $designFileName = $spkNumber . '.' . $ext;
                $file->storeAs('landingpage/img/order_design', $designFileName, 'public');
            }

            $previewFileName = null;
            if ($request->hasFile('preview_design')) {
                $file = $request->file('preview_design');
                $base = $designFileName ?? ($user->id . '_' . time());
                $previewFileName = 'preview-' . pathinfo($base, PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('landingpage/img/order_design', $previewFileName, 'public');
            }

            // Hitung harga dasar
            $basePrice = $product->price;
            if ($product->discount_percent) {
                $basePrice -= $basePrice * $product->discount_percent / 100;
            }
            if ($product->discount_fix) {
                $basePrice -= $product->discount_fix;
            }

            // Harga finishing per item
            $finishingPrice = 0;
            $finishingName  = null;
            if (!empty($validated['finishing_id']) && $fin = $product->label->finishings->find($validated['finishing_id'])) {
                $finishingPrice = $fin->finishing_price;
                $finishingName  = $fin->finishing_name;
            }

            // Hitung area
            $area = 1;
            if (in_array($product->additional_unit, ['cm', 'm']) && $validated['length'] && $validated['width']) {
                $l = $validated['length'];
                $w = $validated['width'];
                $area = $product->additional_unit === 'cm'
                    ? ($l / 100) * ($w / 100)
                    : $l * $w;
            }

            // 1) Harga per luas × qty
            $subtotalHpl = $basePrice * $area * $validated['qty'];

            // 2) Finishing per item × qty
            $subtotalFinishing = $finishingPrice * $validated['qty'];

            // 3) Total sebelum express
            $subtotal = $subtotalHpl + $subtotalFinishing;

            // 4) Tambah 50% express
            if ($validated['express'] == 1) {
                $subtotal *= 1.5;
            }

            // Simpan ke DB
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
                'discount_percent'  => $product->discount_percent ?? null,
                'discount_fix'      => $product->discount_percent ? null : ($product->discount_fix ?? null),
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
        $labels = Label::with('products')->latest()->get();
        // dd($labels);
        $editingLabel = null;
        if ($request->has('edit')) {
            $editingLabel = Label::with('products')->find($request->edit);
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
                'slug' => Str::slug($productName),
                'production_time' => $request->production_time[$index] ?? null,
                'description' => $request->description[$index] ?? null,
                'spesification_desc' => $request->spesification_desc[$index] ?? null,
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

    public function adminUpdate(Request $request, Label $label)
    {
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
                'slug'            => Str::slug($nm),
                'production_time' => $request->production_time[$i] ?? null,
                'description'     => $request->description[$i] ?? null,
                'spesification_desc' => $request->spesification_desc[$i] ?? null,
            ]);
        }

        $label->finishings()->delete();

        foreach ($request->input('finishing_name') as $i => $nm) {
            $label->finishings()->create([
                'finishing_name'            => $nm,
                'finishing_price'           => $request->input('finishing_price')[$i] ?? null,
            ]);
        }

        return redirect()->route('adminProduct.index')->with('success', 'Data berhasil di-update.');
    }

    public function adminDestroy(Label $label)
    {
        $label->delete();
        Product::where('label_id', $label->id)->delete();
        Finishing::where('label_id', $label->id)->delete();

        return redirect()->route('adminProduct.index')->with('success', 'Data berhasil dihapus.');
    }

    public function bukuExcel()
    {
        return Excel::download(new BukuExport, 'data_buku_'.date('d-m-Y').'.xlsx');
    }
    
}
