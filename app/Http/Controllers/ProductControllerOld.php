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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_buku = DB::table('buku')
                ->join('kategori', 'kategori.id', '=', 'buku.kategori_id')
                ->join('penerbit', 'penerbit.id', '=', 'buku.penerbit_id')
                ->select('buku.*', 'kategori.nama as kategori', 'penerbit.nama as penerbit')
                ->orderBy('buku.id', 'desc')
                ->get();
        return view('buku.index', compact('ar_buku'));
    }

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

    
    public function readBuku(Request $request)
    {
        $filename = $request->query('file');
        $path = public_path('landingpage/pdf/' . $filename);
    
        if (!file_exists($path)) {
            abort(404);
        }
    
        return response()->file($path);
    }
    

    public function bukuDiskon(Request $request)
    {
        $ar_buku = Buku::where('diskon', '>', 0)->get();

        $search = $request->search;
        $buku_terpilih = Buku::query();

        // Filter search
        if ($search) {
            $buku_terpilih->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%')
                      ->orWhere('pengarang', 'like', '%'.$search.'%')
                      ->orWhere('harga', 'like', '%'.$search.'%')
                      ->orWhere('isbn', 'like', '%'.$search.'%')
                      ->orWhere('sinopsis', 'like', '%'.$search.'%')
                      ->orWhere('jumlah_halaman', 'like', '%'.$search.'%');
            });
        }

        $buku_terpilih = $buku_terpilih->get();

        return view('landingpage.promo', compact('ar_buku', 'search'));
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ambil master untuk dilooping di select option
        $ar_kategori = Kategori::all();
        $ar_penerbit = Penerbit::all();
        //arahkan ke form input data
        return view('buku.form',compact('ar_kategori', 'ar_penerbit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:buku|max:5',
            'judul' => 'required|max:45',
            'kategori' => 'required|integer',
            'penerbit' => 'required|integer',
            'isbn' => 'required|integer',
            'pengarang' => 'required|max:45',
            'jumlah_halaman' => 'required|integer|max:10000',
            'sinopsis' => 'nullable|max:100',
            'rating' => 'required|numeric|max:5',
            'harga' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'diskon' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:500',
            'pdf_ebook' => 'required|file|mimes:pdf|max:10000', // max 10MB
        ],
        //custom pesan errornya
        [
            'kode.required'=>'Kode Wajib Diisi',
            'kode.unique'=>'Kode Sudah Ada (Terduplikasi)',
            'kode.max'=>'Kode Maksimal 5 karakter',
            'judul.required'=>'Judul Wajib Diisi',
            'judul.max'=>'Judul Maksimal 45 karakter',
            'kategori.required'=>'Kategori Wajib Diisi',
            'kategori.integer'=>'Kategori Harus Berupa Angka',
            'penerbit.required'=>'Penerbit Wajib Diisi',
            'isbn.required'=>'ISBN Wajib Diisi',
            'isbn.integer'=>'ISBN Wajib Diisi Dengan Angka',
            'pengarang.required'=>'Pengarang Wajib Diisi',
            'pengarang.max'=>'Pengarang Maksimal 45 karakter',
            'jumlah_halaman.required'=>'Jumlah Halaman Wajib Diisi',
            'jumlah_halaman.integer'=>'Jumlah Halaman Wajib Diisi Berupa Angka',
            'jumlah_halaman.max'=>'Jumlah Halaman Maksimal 10000',
            'sinopsis.max'=>'Sinopsis Maksimal 100 kata',
            'rating.required'=>'Rating Wajib Diisi',
            'rating.max'=>'Rating Maksimal 5 Bintang',
            'harga.required'=>'Harga Wajib Diisi',
            'harga.regex'=>'Harga Harus Berupa Angka',
            'diskon.regex'=>'Diskon Harus Berupa Angka',
            'foto.min'=>'Ukuran file kurang 2 KB',
            'foto.max'=>'Ukuran file melebihi 500 KB',
            'foto.image'=>'File foto bukan gambar',
            'foto.mimes'=>'Extension file selain jpg,jpeg,png,svg',
            'url_buku.required'=>'URL Buku Wajib Diisi',
        ]);
    
        if ($request->hasFile('pdf_ebook')) {
            // Simpan file PDF ke folder yang tepat
            $pdf = $request->file('pdf_ebook');
            $pdfName = 'ebook_' . $request->kode . '.' . $pdf->getClientOriginalExtension();
            $pdfPath = 'landingpage/pdf/' . $pdfName;
            $pdf->move(public_path('landingpage/pdf'), $pdfName);

            if(!empty($request->foto)){
                $fileName = 'buku_'.$request->kode.'.'.$request->foto->extension();
                $request->foto->move(public_path('landingpage/img'),$fileName);
            }
            else{
                $fileName = '';
            }

            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $counter = 1;

            while (Buku::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
    
            // Simpan path PDF dan JPG ke database
            $buku = new Buku;
            $buku->kode = $request->kode;
            $buku->judul = $request->judul;
            $buku->slug = $slug;
            $buku->kategori_id = $request->kategori;
            $buku->penerbit_id = $request->penerbit;
            $buku->isbn = $request->isbn;
            $buku->pengarang = $request->pengarang;
            $buku->jumlah_halaman = $request->jumlah_halaman;
            $buku->sinopsis = $request->sinopsis;
            $buku->rating = $request->rating;
            $buku->harga = $request->harga;
            $buku->diskon = $request->diskon;
            $buku->url_buku = $pdfPath;
            $buku->foto = $fileName;
    
            $buku->save();
    
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
        } else {
            return back()->withErrors(['msg' => 'File PDF harus diunggah.']);
        }
    }
    
    /**
     * Detail buku adminpage
     */
    public function show(string $id, Request $request)
    {
        $rs = Buku::find($id);

        $search = $request->search;
        $buku_terpilih = Buku::query();

        // Filter search
        if ($search) {
            $buku_terpilih->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%')
                      ->orWhere('pengarang', 'like', '%'.$search.'%')
                      ->orWhere('harga', 'like', '%'.$search.'%')
                      ->orWhere('isbn', 'like', '%'.$search.'%')
                      ->orWhere('sinopsis', 'like', '%'.$search.'%')
                      ->orWhere('jumlah_halaman', 'like', '%'.$search.'%');
            });
        }

        $buku_terpilih = $buku_terpilih->get();

        return view('buku.detail', compact('rs', 'search'));
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

        // Cek kelengkapan alamat
        if (!$user->province || !$user->city || !$user->address || !$user->postal_code) {
            return back()
                ->withErrors(['profile' => 'Harap lengkapi data alamat Anda (provinsi, kota, alamat, kode pos) sebelum melakukan pemesanan.'])
                ->withInput();
        }

        $rules = [
            'product_id'      => 'required|exists:products,id',
            'finishing_id'    => 'nullable|exists:finishings,id',
            'express'         => 'required|in:0,1',
            'deadline_time'   => 'nullable|required_if:express,1|date_format:H:i',
            'needs_proofing'  => 'required|in:0,1',
            'delivery_method' => 'required|in:0,1,2',
            'order_design'    => 'nullable|file|mimes:jpeg,jpg,png,pdf,zip,rar|max:20480',
            'preview_design'  => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'length'          => 'nullable|numeric|min:0',
            'width'           => 'nullable|numeric|min:0',
            'qty'             => 'required|integer|min:1',
            'notes'           => 'nullable|string|max:1000',
            'order_status'    => 'required|in:0'
        ];

        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

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

            $user           = auth()->user();
            $dateStamp      = $today->format('Ymd');
            $designFileName = null;

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

            // Hitung harga
            $basePrice = $product->price;
            if ($product->discount_percent) {
                $basePrice -= $basePrice * $product->discount_percent / 100;
            }
            if ($product->discount_fix) {
                $basePrice -= $product->discount_fix;
            }

            $finishingPrice = 0;
            $finishingName  = null;
            if (!empty($validated['finishing_id'])) {
                $fin = $product->label->finishings->find($validated['finishing_id']);
                if ($fin) {
                    $finishingPrice = $fin->finishing_price;
                    $finishingName  = $fin->finishing_name;
                }
            }

            $unitPrice = $basePrice + $finishingPrice;
            $area      = 1;
            if (in_array($product->additional_unit, ['cm', 'm']) && $validated['length'] && $validated['width']) {
                $l = $validated['length'];
                $w = $validated['width'];
                $area = $product->additional_unit === 'cm'
                    ? ($l / 100) * ($w / 100)
                    : $l * $w;
            }

            $subtotal = $unitPrice * $area * $validated['qty'];
            if ($validated['express'] == 1) {
                $subtotal *= 1.5;
            }

            $order = Order::create([
                'spk'              => $spkNumber,
                'user_id'          => $user->id,
                'order_design'     => $designFileName,
                'preview_design'   => $previewFileName,
                'transaction_type' => 0,
                'transaction_method'=> 0,
                'payment_status'   => 0,
                'order_status'     => 0,
                'subtotal'         => round($subtotal),
                'discount_percent' => $product->discount_percent ?? null,
                'discount_fix'     => $product->discount_percent ? null : ($product->discount_fix ?? null),
                'deadline_time'    => $validated['deadline_time'] ?? null,
                'express'          => $validated['express'],
                'delivery_method'  => $validated['delivery_method'],
                'needs_proofing'   => $validated['needs_proofing'],
                'pickup_status'    => 0,
                'notes'            => $validated['notes'] ?? null,
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

    public function detailPengarang(Pengarang $pengarang, Request $request)
    {
        // Ambil jumlah buku yang ditulis oleh pengarang
        $pengarang->loadCount('pengarang');  // Pastikan fungsi relasinya benar.

        // Ambil semua buku yang ditulis pengarang tersebut
        $buku_pengarang = Buku::where('pengarang_id', $pengarang->id)->paginate(12);  // Menggunakan pagination


        $search = $request->search;
        $buku_terpilih = Buku::query();

        // Filter search
        if ($search) {
            $buku_terpilih->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%')
                      ->orWhere('pengarang', 'like', '%'.$search.'%')
                      ->orWhere('harga', 'like', '%'.$search.'%')
                      ->orWhere('isbn', 'like', '%'.$search.'%')
                      ->orWhere('sinopsis', 'like', '%'.$search.'%')
                      ->orWhere('jumlah_halaman', 'like', '%'.$search.'%');
            });
        }

        $buku_terpilih = $buku_terpilih->get();
        
        return view('landingpage.pengarang_detail', compact('buku_pengarang', 'pengarang', 'search'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //ambil master untuk dilooping di select option
        $ar_kategori = Kategori::all();
        $ar_penerbit = Penerbit::all();
        //tampilkan data lama di form
        $row = Buku::find($id);
        return view('buku.form_edit',compact('row','ar_kategori', 'ar_penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //proses input produk dari form
        $request->validate([
            'kode' => 'required|max:5',
            'judul' => 'required|max:45',
            'kategori' => 'required|integer',
            'penerbit' => 'required|integer',
            'isbn' => 'required|integer',
            'pengarang' => 'required|max:45',
            'jumlah_halaman' => 'required|integer|max:10000',
            'sinopsis' => 'nullable|max:100',
            'rating' => 'required|numeric|max:5',
            'harga' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'diskon' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,svg|min:2|max:500', //kb
            'url_buku' => 'required|max:255',
        ],
        //custom pesan errornya
        [
            'kode.required'=>'Kode Wajib Diisi',
            'kode.unique'=>'Kode Sudah Ada (Terduplikasi)',
            'kode.max'=>'Kode Maksimal 5 karakter',
            'judul.required'=>'Judul Wajib Diisi',
            'judul.max'=>'Judul Maksimal 45 karakter',
            'kategori.required'=>'Kategori Wajib Diisi',
            'kategori.integer'=>'Kategori Harus Berupa Angka',
            'penerbit.required'=>'Penerbit Wajib Diisi',
            'isbn.required'=>'ISBN Wajib Diisi',
            'isbn.integer'=>'ISBN Wajib Diisi Dengan Angka',
            'pengarang.required'=>'Pengarang Wajib Diisi',
            'pengarang.max'=>'Pengarang Maksimal 45 karakter',
            'jumlah_halaman.required'=>'Jumlah Halaman Wajib Diisi',
            'jumlah_halaman.integer'=>'Jumlah Halaman Wajib Diisi Berupa Angka',
            'jumlah_halaman.max'=>'Jumlah Halaman Maksimal 10000',
            'sinopsis.max'=>'Sinopsis Maksimal 100 kata',
            'rating.required'=>'Rating Wajib Diisi',
            'rating.max'=>'Rating Maksimal 5 Bintang',
            'harga.required'=>'Harga Wajib Diisi',
            'harga.regex'=>'Harga Harus Berupa Angka',
            'diskon.regex'=>'Diskon Harus Berupa Angka',
            'foto.min'=>'Ukuran file kurang 2 KB',
            'foto.max'=>'Ukuran file melebihi 500 KB',
            'foto.image'=>'File foto bukan gambar',
            'foto.mimes'=>'Extension file selain jpg,jpeg,png,svg',
            'url_buku.required'=>'URL Buku Wajib Diisi',
        ]
        );

        //------------ambil foto lama apabila user ingin ganti foto-----------
        $foto = DB::table('buku')->select('foto')->where('id',$id)->get();
        foreach($foto as $f){
            $namaFileFotoLama = $f->foto;
        }

        //------------apakah user  ingin ubah upload foto baru--------- --
        if(!empty($request->foto)){
            //jika ada foto lama, hapus foto lamanya terlebih dahulu
            if(!empty($namaFileFotoLama)) unlink('landingpage/img/'.$namaFileFotoLama);

            //lalukan proses ubah foto lama menjadi foto baru
            $fileName = 'buku_'.$request->kode.'.'.$request->foto->extension();
            $request->foto->move(public_path('landingpage/img'),$fileName);
        }
        else{
            $fileName = $namaFileFotoLama;
        }

        //lakukan insert data dari request form
        DB::table('buku')->where('id',$id)->update(
            [
                'kode'=>$request->kode,
                'judul'=>$request->judul,
                'kategori_id'=>$request->kategori,
                'penerbit_id'=>$request->penerbit,
                'isbn'=>$request->isbn,
                'pengarang'=>$request->pengarang,
                'jumlah_halaman'=>$request->jumlah_halaman,
                'sinopsis'=>$request->sinopsis,
                'rating'=>$request->rating,
                'harga'=>$request->harga,
                'diskon'=>$request->diskon,
                'foto'=>$fileName,
                'url_buku'=>$request->url_buku,
            ]);
       
        return redirect('/buku'.'/'.$id)
            ->with('success','Data Buku Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        if (!empty($buku->foto)) {
            $fotoPath = public_path('landingpage/img/'.$buku->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $buku->delete();
        return redirect()->route('buku.index')
                        ->with('success', 'Data Buku Berhasil Dihapus');
    }
 /*
    public function delete($id)
    {
        $buku = Buku::find($id);
        if (!empty($buku->foto)) {
            $fotoPath = public_path('landingpage/img/'.$buku->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        //hapus data dari database
        Buku::where('id',$id)->delete();
        return redirect()->back();
    }   */ 

    public function bukuExcel()
    {
        return Excel::download(new BukuExport, 'data_buku_'.date('d-m-Y').'.xlsx');
    }
    
}
