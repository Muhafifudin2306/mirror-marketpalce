<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Label;
use App\Models\Order;
use App\Models\Finishing;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public $paginate = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pesananIndex(Request $request)
    {
        $this->authorize('order-management'); 
        $ar_order = Order::where('status_pengerjaan', 'pending')
                 ->orderBy('express', 'desc')
                 ->orderBy('deadline', 'desc');

        $query = $this->generalFilter($ar_order, $request);

        $ar_order = $query->get();

        return view('order.index', compact('ar_order'));
    }

    public function generalFilter($query, $request) 
    {
        if ($request->start_date) {
            $query->where('tanggal', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        if (!empty($request->spk)) {
            $query->where('spk', 'like', '%' . $request->spk . '%');
        }

        if (!empty($request->status_pembayaran)) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        if (!empty($request->invoice)) {
            $resultConvertInvToSPK = $this->convertInvoiceToSPK($request->invoice);
            $query->where('spk', 'like', '%' . $resultConvertInvToSPK . '%');
        }

        return $query;
    }

    public function create()
    {
        $products = Product::has('label')->get();
        $labels = Label::all();
        $finishings = Finishing::has('label')->get();
        return view('order.create', compact('products', 'labels', 'finishings'));
    }


    public function store(Request $request)
    {
        $this->authorize('order-manipulation'); 
        $validated = $request->validate([
            'tanggal'             => 'required|date',
            'waktu'               => 'required',
            'nama_pelanggan'      => 'required|string|max:255',
            'kontak_pelanggan'    => 'required|string|max:50',
            'email_pelanggan'     => 'nullable|email|max:255',
            'jenis_transaksi'     => 'required|in:0,1,2',
            'tipe_pengambilan'    => 'required|in:0,1',
            'metode_pengiriman'   => 'required|in:0,1',
            // 'alamat'              => 'required_if:metode_pengiriman,1|string|max:500', // Dikirim
            // 'kode_pos'            => 'required_if:metode_pengiriman,1|integer|max:11',
            // 'berat'               => 'required_if:metode_pengiriman,1|integer|max:11',
            'kebutuhan_proofing'  => 'required|in:0,1',
            'express'             => 'nullable|in:0,1',
            'deadline'            => 'required|date|after_or_equal:tanggal',
            'waktu_deadline'      => 'required',
            'desain.*'              => [
                'nullable',
                'file',
                'mimes:jpeg,jpg,png,pdf,svg,cdr,psd,ai,tif,tiff',
                'max:102400', // max 100 MB
            ],
            'preview.*'              => [
                'nullable',
                'file',
                'mimes:jpeg,jpg,png,pdf,svg,cdr,psd,ai,tif,tiff',
                'max:102400', // max 100 MB
            ],
            'jenis_cetakan.*'     => 'required|exists:labels,id',
            'jenis_bahan.*'       => 'nullable|string|max:255',
            'jenis_finishing.*'   => 'nullable|string',
            'panjang.*'           => 'nullable|numeric|min:0',
            'lebar.*'             => 'nullable|numeric|min:0',
            'jumlah_pesanan.*'    => 'required|integer|min:1',
        ], [
            'desain.*.mimes' => 'File desain harus berupa jpeg, jpg, png, pdf, svg, cdr, psd, ai, atau tiff.',
            'desain.*.max'   => 'Ukuran file desain maksimal 10MB.',
            'preview.*.mimes' => 'File preview harus berupa jpeg, jpg, png, pdf, svg, cdr, psd, ai, atau tiff.',
            'preview.*.max'   => 'Ukuran file preview maksimal 10MB.',
        ]);

        // tanggal & prefix SPK
        $date   = $validated['tanggal']
                    ? Carbon::parse($validated['tanggal'])
                    : Carbon::now();
        $prefix = $date->format('ymd');

        // Hitung nomor harian dan bulanan
        $dailyCount = Order::whereDate('tanggal', $date->toDateString())->count() + 1;
        $dailySuffix = str_pad($dailyCount, 2, '0', STR_PAD_LEFT);

        $monthlyCount = Order::whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->count() + 1;
        $monthlySuffix = str_pad($monthlyCount, 3, '0', STR_PAD_LEFT);

        // Buat SPK
        $spk = 'SPK' . $prefix . $dailySuffix . '-' . $monthlySuffix;

        $ongkir = 0;
        $kurir = null;
        if($request->dikirim){
            $ongkirDanKurir = explode('|', $request->dikirim);
            $ongkir = $ongkirDanKurir[0] ;
            $kurir = $ongkirDanKurir[1] ;
        }

        $provinsi = null;
        if($request->provinsi){
            $provinsi_table = DB::table('d_provinsi')
                        ->find($request->provinsi);
            $provinsi = $provinsi_table->id;
        }

        $kabkot = null;
        if($request->kota){
            $kabkot_table = DB::table('d_kabkota')
                        ->find($request->kota);
            $kabkot = $kabkot_table->id;
        }
        

        $kecamatan = null;
        if($request->kecamatan){
            $kecamatan_table = DB::table('d_kecamatan')
                        ->find($request->kecamatan);
            $kecamatan = $kecamatan_table->id;
        }
        
        $order = Order::create([
            'tanggal'           => $date->toDateString(),
            'waktu'             => $validated['waktu'],
            'nama_pelanggan'    => $validated['nama_pelanggan'],
            'kontak_pelanggan'  => $validated['kontak_pelanggan'],
            'email_pelanggan'   => $validated['email_pelanggan'] ?? null,
            'jenis_transaksi'   => $validated['jenis_transaksi'],
            'tipe_pengambilan'  => $validated['tipe_pengambilan'],
            'metode_pengiriman' => $validated['metode_pengiriman'],
            'kebutuhan_proofing'=> $validated['kebutuhan_proofing'],
            'express'           => $validated['express'] ?? 0,
            'deadline'          => $validated['deadline'] ?? null,
            'waktu_deadline'    => $validated['waktu_deadline'] ?? null,
            'alamat'            => $request->alamat ?? null,
            'kode_pos'          => $request->kode_pos ?? null,
            'provinsi'          => $provinsi,
            'kota'              => $kabkot,
            'kecamatan'         => $kecamatan,
            'berat'             => $request->berat ?? null,
            'ongkir' => $ongkir,
            'kurir' => $kurir,
            'spk' => $spk,
            'proses_proofing' => 0,
            'proses_produksi' => 0,
            'proses_finishing' => 0,
            'quality_control' => 0,
            'status_pengerjaan' => 'pending',
            'status_pembayaran' => 0,
            'subtotal'          => 0,
            // 'id_validator'      => Auth::id(),
        ], [
            'desain.*.mimes' => 'File desain harus berupa jpeg, jpg, png, pdf, svg, cdr, psd, ai, atau tiff.',
            'desain.*.max'   => 'Ukuran file desain maksimal 10MB.',
            'preview.*.mimes' => 'File preview harus berupa jpeg, jpg, png, pdf, svg, cdr, psd, ai, atau tiff.',
            'preview.*.max'   => 'Ukuran file preview maksimal 10MB.',
        ]);

        $totalSubtotal = 0;

        // $dummyFinishing = [
        //     0 => 500,   // LPMA
        //     1 => 1000,  // PGMA
        //     2 => 1500,  // LOS
        //     3 => 2000,  // LA
        //     4 => 2500,  // KOLAB
        //     5 => 3000,  // KOLKAKI
        //     6 => 3500,  // KOLAB MA
        //     7 => 4000,  // KOLKAKI MA
        // ];

        if (is_array($validated['jenis_bahan'])) {
    foreach ($validated['jenis_bahan'] as $i => $productId) {
        // dd($request->hasFile('desain') && isset($validated['desain'][$i]));
        $product = Product::find($productId);
        if (!$product) continue;

        $hargaMaster = $product->price;
        $panjangMaster = (float) ($product->long_product ?? 0);
        $lebarMaster   = (float) ($product->width_product ?? 0);

        // Input user
        $panjangInput = (float) ($request->panjang[$i] ?? 0);
        $lebarInput   = (float) ($request->lebar[$i] ?? 0);
        $jumlah       = (int) ($request->jumlah_pesanan[$i] ?? 0);

        $panjangFinal = $panjangInput;
        $lebarFinal   = $lebarInput;
        $harga        = $hargaMaster;

        // Jika input panjang/lebar < master, gunakan ukuran dan harga dari master produk
        if (
            ($panjangInput > 0 && $panjangInput < $panjangMaster)
        ) {
            $panjangFinal = $panjangMaster;
        }

        if (
            ($lebarInput > 0 && $lebarInput < $lebarMaster)
        ) {
            $lebarFinal = $lebarMaster;
        }

        $finishing = 0;
        $hargaFinishing = 0;

        if(isset($validated['jenis_finishing'][$i]) != null){

            $finishing = Finishing::find($validated['jenis_finishing'][$i]);
            $hargaFinishing = $finishing->finishing_price;
        }

        // dd($hargaFinishing);

        // Hitung subtotal
        $itemSubtotal = 0;
        if ($panjangFinal > 0 && $lebarFinal > 0) {
            $luas = ($panjangFinal / 100) * ($lebarFinal / 100);
            $itemSubtotal = (($luas * $harga) * $jumlah)+$hargaFinishing;
        } else {
            $itemSubtotal = ($harga * $jumlah)+$hargaFinishing;
        }

        $path_design = null;
        $path_preview = null;

        if ($request->hasFile('desain') && isset($validated['desain'][$i])) {
            $file = $validated['desain'][$i];
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path_design = $file->storeAs('desain', $filename, 'public'); 
        }

        if ($request->hasFile('preview') && isset($validated['preview'][$i])) {
            $file = $validated['preview'][$i];
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path_preview = $file->storeAs('preview', $filename, 'public'); 
        }

        // dd($path_design);

        OrderProduct::create([
            'order_id'          => $spk,
            'product_id'        => $productId,
            'jenis_bahan'       => $validated['jenis_bahan'][$i] ?? null,
            'jenis_finishing'   => $validated['jenis_finishing'][$i] ?? null,
            'jenis_cetakan'     => $validated['jenis_cetakan'][$i] ?? null,
            'panjang'           => $panjangInput > 0 ? $panjangInput : null,
            'lebar'             => $lebarInput > 0 ? $lebarInput : null,
            'desain'            => $path_design ?? null,
            'preview'           => $path_preview ?? null,
            'jumlah_pesanan'    => $jumlah,
            'harga'             => $harga,
            'subtotal'          => $itemSubtotal,
        ]);

        $totalSubtotal += $itemSubtotal;
    }
}


        if (($request->express ?? 0) == 1) {
            $totalSubtotal *= 1.50;
        }

        if ($request->metode_pengiriman == 1) {
            $totalSubtotal = $totalSubtotal + $ongkir;
        }

        $order->update(['subtotal' => $totalSubtotal]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil disimpan! SPK: ' . $spk);
    }

    public function show($id)
    {
        $this->authorize('order-management'); 
        $order = Order::findOrFail($id);
        // dd($order->deadline);
        $items = OrderProduct::where('order_id', $order->spk)
                            ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                            ->join('labels', 'products.label_id', '=', 'labels.id')
                            ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                            ->select([
                                'order_products.*',
                                'finishings.*',
                                'products.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name'
                            ])
                            ->get();

        $provinsiId = DB::table('d_provinsi')
                     ->where('id', $order->provinsi)
                     ->pluck('id')
                     ->first();

        $provinsi = DB::table('d_provinsi')
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kota = DB::table('d_kabkota')
                    ->where('d_provinsi_id', $provinsiId)
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kotaId = DB::table('d_kabkota')
                     ->where('id', $order->kota)
                     ->pluck('id')
                     ->first();

        $kecamatan = DB::table('d_kecamatan')
                    ->orderBy('nama')
                    ->where('d_kabkota_id', $kotaId)
                    ->get(['id', 'nama']);

        $kecamatanId = DB::table('d_kecamatan')
                     ->where('id', $order->kecamatan)
                     ->pluck('id')
                     ->first();
        
        $kodepos = DB::table('d_kodepos')
                    ->where('d_kabkota_id', $kotaId)
                    ->where('d_kecamatan_id', $kecamatanId)
                    ->orderBy('kodepos')
                    ->get(['id', 'kodepos as nama']);

        return view('order.detail', compact('order', 'items','provinsi','kota', 'kecamatan','kodepos'));
    }


    public function edit(string $id)
    {
        $this->authorize('order-manipulation'); 
        $order = Order::findOrFail($id);
        $items = OrderProduct::where('order_id', $order->spk)->get();
        $products = Product::all();
        $labels = Label::all();
        
        $finishings = Finishing::has('label')->get();

        $provinsiId = DB::table('d_provinsi')
                     ->where('id', $order->provinsi)
                     ->pluck('id')
                     ->first();

        $provinsi = DB::table('d_provinsi')
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kota = DB::table('d_kabkota')
                    ->where('d_provinsi_id', $provinsiId)
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kotaId = DB::table('d_kabkota')
                     ->where('id', $order->kota)
                     ->pluck('id')
                     ->first();

        $kecamatan = DB::table('d_kecamatan')
                    ->orderBy('nama')
                    ->where('d_kabkota_id', $kotaId)
                    ->get(['id', 'nama']);

        $kecamatanId = DB::table('d_kecamatan')
                     ->where('id', $order->kecamatan)
                     ->pluck('id')
                     ->first();
        
        $kodepos = DB::table('d_kodepos')
                    ->where('d_kabkota_id', $kotaId)
                    ->where('d_kecamatan_id', $kecamatanId)
                    ->orderBy('kodepos')
                    ->get(['id', 'kodepos as nama']);
        // dd($kodepos);

        return view('order.edit', compact('order','finishings', 'items', 'products', 'labels','provinsi','kota', 'kecamatan','kodepos'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('order-manipulation'); 
        $order = Order::findOrFail($id);
        // dd($request->all());

        $validated = $request->validate([
            'tanggal'             => 'required|date',
            'waktu'               => 'required',
            'nama_pelanggan'      => 'required|string|max:255',
            'kontak_pelanggan'    => 'required|string|max:50',
            'email_pelanggan'     => 'nullable|email|max:255',
            'jenis_transaksi'     => 'required|in:0,1,2',
            'tipe_pengambilan'    => 'required|in:0,1',
            'metode_pengiriman'   => 'required|in:0,1',
            'kebutuhan_proofing'  => 'required|in:0,1',
            'express'             => 'required|in:0,1',
            'deadline'            => 'required|date|after_or_equal:tanggal',
            'waktu_deadline'      => 'required',
            'desain.*'              => 'nullable|file|mimes:jpeg,jpg,png,pdf,svg,cdr,psd,ai,tiff|max:102400',
            'preview.*'              => 'nullable|file|mimes:jpeg,jpg,png,pdf,svg,cdr,psd,ai,tiff|max:102400',
            'desain_old.*'              => 'nullable',
            'preview_old.*'              => 'nullable',
            'jenis_cetakan.*'     => 'required|exists:labels,id',
            'jenis_bahan.*'       => 'required|exists:products,id',
            'jenis_finishing.*'   => 'nullable|string',
            'panjang.*'           => 'nullable|numeric|min:0',
            'lebar.*'             => 'nullable|numeric|min:0',
            'jumlah_pesanan.*'    => 'required|integer|min:1',
            // 'berat'               => 'required_if:metode_pengiriman,1|numeric|min:0',
            // 'kode_pos'            => 'required_if:metode_pengiriman,1|numeric',
            // 'alamat'              => 'required_if:metode_pengiriman,1|string',
            // 'dikirim'             => 'required_if:metode_pengiriman,1|string',
        ]);

        $date = Carbon::parse($validated['tanggal']);
        $spk = $order->spk;

        // if ($request->hasFile('desain')) {
        //     if ($order->desain) Storage::disk('public')->delete($order->desain);
        //     $file = $request->file('desain');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $path = $file->storeAs('desains', $filename, 'public');
        //     $order->desain = $path;
        // }

        // if ($request->hasFile('preview')) {
        //     if ($order->desain) Storage::disk('public')->delete($order->preview);
        //     $file = $request->file('preview');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $path = $file->storeAs('previews', $filename, 'public');
        //     $order->preview = $path;
        // }

        $provinsi = null;
        if($request->provinsi){
            $provinsi_table = DB::table('d_provinsi')
                        ->find($request->provinsi);
            $provinsi = $provinsi_table->id;
        }

        $kabkot = null;
        if($request->kota){
            $kabkot_table = DB::table('d_kabkota')
                        ->find($request->kota);
            $kabkot = $kabkot_table->id;
        }
        

        $kecamatan = null;
        if($request->kecamatan){
            $kecamatan_table = DB::table('d_kecamatan')
                        ->find($request->kecamatan);
            $kecamatan = $kecamatan_table->id;
        }
        

        $order->update([
            'tanggal'             => $date->toDateString(),
            'waktu'               => $validated['waktu'],
            'nama_pelanggan'      => $validated['nama_pelanggan'],
            'kontak_pelanggan'    => $validated['kontak_pelanggan'],
            'email_pelanggan'     => $validated['email_pelanggan'] ?? null,
            'jenis_transaksi'     => $validated['jenis_transaksi'],
            'tipe_pengambilan'    => $validated['tipe_pengambilan'],
            'metode_pengiriman'   => $validated['metode_pengiriman'],
            'kebutuhan_proofing'  => $validated['kebutuhan_proofing'],
            'express'             => $validated['express'],
            'deadline'            => $validated['deadline'],
            'waktu_deadline'               => $validated['waktu_deadline'],
            'provinsi'            => $provinsi,
            'kota'                => $kabkot,
            'kecamatan'           => $kecamatan,
            'alamat'              => $request->metode_pengiriman == 1 ? $request->alamat : null,
            'kode_pos'            => $request->metode_pengiriman == 1 ? $request->kode_pos : null,
            'berat'               => $request->metode_pengiriman == 1 ? $request->berat : null,
            'ongkir'              => $request->metode_pengiriman == 1 && $request->dikirim ? explode('|', $request->dikirim)[0] : 0,
            'kurir'               => $request->metode_pengiriman == 1 && $request->dikirim ? explode('|', $request->dikirim)[1] : null,
        ]);

        OrderProduct::where('order_id', $spk)->delete();

        $totalSubtotal = 0;

if (is_array($validated['jenis_bahan'])) {
    foreach ($validated['jenis_bahan'] as $i => $productId) {
        // dd($request->hasFile('desain') && isset($validated['desain'][$i]));
        $product = Product::find($productId);
        if (!$product) continue;

        // Master data
        $hargaMaster   = $product->price;
        $panjangMaster = (float) ($product->long_product ?? 0);
        $lebarMaster   = (float) ($product->width_product ?? 0);

        // Input user
        $panjangInput = (float) ($request->panjang[$i] ?? 0);
        $lebarInput   = (float) ($request->lebar[$i] ?? 0);
        $jumlah       = (int) ($request->jumlah_pesanan[$i] ?? 0);

        // Default gunakan input
        $panjangFinal = $panjangInput;
        $lebarFinal   = $lebarInput;
        $harga        = $hargaMaster;

        // Cek apakah input < master
        if (
            ($panjangInput > 0 && $panjangInput < $panjangMaster)
        ) {
            $panjangFinal = $panjangMaster;
        }

        if (
            ($lebarInput > 0 && $lebarInput < $lebarMaster)
        ) {
            $lebarFinal = $lebarMaster;
        }

        // Hitung subtotal
         $finishing = Finishing::find($validated['jenis_finishing'][$i]);

        //  dd($validated['jenis_finishing'][$i]);
        if(isset($validated['jenis_finishing'][$i]) != null){

            $finishing = Finishing::find($validated['jenis_finishing'][$i]);
            $hargaFinishing = $finishing->finishing_price;
        }

        // Hitung subtotal
        $itemSubtotal = 0;
        if ($panjangFinal > 0 && $lebarFinal > 0) {
            $luas = ($panjangFinal / 100) * ($lebarFinal / 100);
            $itemSubtotal = (($luas * $harga) * $jumlah)+$hargaFinishing;
        } else {
            $itemSubtotal = ($harga * $jumlah)+$hargaFinishing;
        }

        $path_design = null;
        $path_preview = null;

        if ($request->hasFile('desain') && isset($validated['desain'][$i])) {
            $file = $validated['desain'][$i];
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path_design = $file->storeAs('desain', $filename, 'public'); 
        } else {
            $path_design = $validated['desain_old'][$i];
        }

        if ($request->hasFile('preview') && isset($validated['preview'][$i])) {
            $file = $validated['preview'][$i];
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path_preview = $file->storeAs('preview', $filename, 'public'); 
        } else {
            $path_preview = $validated['preview_old'][$i];
        }

        OrderProduct::create([
            'order_id'        => $spk,
            'product_id'      => $productId,
            'jenis_bahan'     => $validated['jenis_bahan'][$i],
            'jenis_finishing' => $validated['jenis_finishing'][$i] ?? null,
            'jenis_cetakan'   => $validated['jenis_cetakan'][$i],
            'panjang'         => $panjangInput > 0 ? $panjangInput : null,
            'lebar'           => $lebarInput > 0 ? $lebarInput : null,
            'desain'          => $path_design ?? null,
            'preview'         => $path_preview ?? null,
            'jumlah_pesanan'  => $jumlah,
            'harga'           => $harga,
            'subtotal'        => $itemSubtotal,
        ]);

        $totalSubtotal += $itemSubtotal;
    }
}


        if ($validated['express'] == 1) {
            $totalSubtotal *= 1.50;
        }

        if ($validated['metode_pengiriman'] == 1 && $request->dikirim) {
            $ongkir = (int) explode('|', $request->dikirim)[0];
            $totalSubtotal += $ongkir;
        }

        $order->update(['subtotal' => $totalSubtotal]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order SPK ' . $spk . ' berhasil diubah!');
    }


    public function destroy($id)
    {
        $this->authorize('order-manipulation'); 
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data berhasil dihapus!');
    }

    

    public function verify($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pengerjaan' => 'verif_pembayaran']);

        return redirect()
            ->back()
            ->with('success', "Order SPK {$order->spk} siap untuk pembayaran.");
    }

    public function production($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pengerjaan' => 'produksi']);

        return redirect()
            ->back()
            ->with('success', "Order SPK {$order->spk} siap untuk diproduksi.");
    }

    public function paymentIndex(Request $request)
    {
        $ar_order = Order::where(function ($subQuery) use ($request) {
            $subQuery->where('status_pengerjaan', 'verif_pembayaran')
                    ->orWhere('status_pengerjaan', 'verif_pesanan');
            });
                 
        $query = $this->generalFilter($ar_order, $request);
        $query->orderBy('express', 'desc')
                ->orderBy('deadline', 'desc');

        $ar_order = $query->get();

        return view('order.payment_index', compact('ar_order'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pengerjaan' => 'pending']);

        return redirect()
            ->back()
            ->with('success', "Verifikasi order SPK {$order->spk} dibatalkan.");
    }

    public function paymentShow($id)
    {
        $order = Order::findOrFail($id);

        $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

                

        $validatorName = null;
        if ($order->id_validator) {
            $validator = User::find($order->id_validator);
            $validatorName = $validator ? $validator->name : null;
        }

        // dd($order->express);
        return view('order.payment_detail', compact('order', 'items', 'validatorName'));
    }

    public function confirmPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->diskon_persen    = null;
        $order->potongan_rp      = null;
        $order->metode_transaksi = $request->input('metode_transaksi');
        $diskonPersen = 0;
        if ($request->has('diskon_persen')) {
            $diskonPersen        = (float) $request->input('diskon_persen');
            $order->diskon_persen = $diskonPersen;
        }
        $potonganRp = 0;
        if ($request->has('potongan_rp')) {
            $potonganRp        = (float) $request->input('potongan_rp');
            $order->potongan_rp = $potonganRp;
        }

        $jumlahBayar = (float) $request->input('jumlah_bayar', 0);
        // dd(number_format($jumlahBayar, 0, ',', '.'));

        $previousTermin = $order->termin;

        $newTermin      = (float) $request->input('termin', 0);
        $order->termin  = $newTermin;

        if ($order->status_pembayaran == 0) {
            $order->id_validator = Auth::id();
        }


        $order->status_pengerjaan = 'verif_pesanan';
        $order->status_pembayaran = ($order->termin > 0) ? 1 : 2;

        if($newTermin == 0){
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path_bukti_bayar = $file->storeAs('bukti_bayar', $filename, 'public'); 
                $order->bukti_bayar = $path_bukti_bayar;
                $order->bukti_lunas = $path_bukti_bayar;
                $order->metode_transaksi = $request->input('metode_transaksi');
                $order->metode_transaksi_paid = $request->input('metode_transaksi');
            }

            $order->dp = $jumlahBayar;
            $order->full_payment = $jumlahBayar;

            $order->payment_at = Carbon::now();
            $order->paid_at = Carbon::now();
            
        } else{
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path_bukti_bayar = $file->storeAs('bukti_bayar', $filename, 'public'); 
                $order->bukti_bayar = $path_bukti_bayar;
                $order->metode_transaksi = $request->input('metode_transaksi');
            }
            $order->dp = $jumlahBayar;
            $order->payment_at = Carbon::now();
        }

        $order->save();

        $rawSpk    = explode('-', $order->spk)[0];
        $invoiceNo = 'INV' . substr($rawSpk, 3);

        $items = OrderProduct::where('order_id', $order->spk)
            ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
            ->join('labels',   'products.label_id',    '=', 'labels.id')
            ->select([
                'order_products.panjang',
                'order_products.lebar',
                'order_products.jumlah_pesanan',
                'products.name as product_name',
                'products.price as product_price',
                'products.additional_size',
                'products.additional_unit',
                'labels.name as label_name',
                'order_products.jenis_finishing',
                'order_products.subtotal'
            ])
            ->get();

        $totalBarang = $items->sum('subtotal');

        $biayaExpress = 0;
        if ($order->express) {
            $biayaExpress = $totalBarang * 0.5;
        }

        $biayaOngkir = $order->metode_pengiriman ? $order->ongkir : 0;

        $potonganDiskonAmt = 0;
        if ($diskonPersen > 0) {
            $dasarDiskon = $totalBarang + $biayaExpress; //FIXINGGG!!
            $potonganDiskonAmt = $dasarDiskon * ($diskonPersen / 100);
        }

        $totalPayable = $totalBarang
                      + $biayaExpress
                      + $biayaOngkir
                      - $potonganDiskonAmt
                      - $potonganRp;

        $terminSisa   = max(0, $totalPayable - $jumlahBayar);

        $lines = [];
        foreach ($items as $item) {
            $jenisCetak  = $item->label_name;
            $jenisBahan  = $item->product_name;
            if (!empty($item->panjang) && !empty($item->lebar)) {
                $sizeText = "{$item->panjang}×{$item->lebar} cm";
            } elseif (!empty($item->additional_size) && !empty($item->additional_unit)) {
                $sizeText = "{$item->additional_size} {$item->additional_unit}";
            } else {
                $sizeText = "-";
            }
            $qty          = $item->jumlah_pesanan;
            $sub          = $item->subtotal;
            $subFormatted = 'Rp ' . number_format($sub, 0, ',', '.');

            $lines[] = "• {$jenisCetak} – {$jenisBahan} ({$sizeText}) × {$qty} = *{$subFormatted}*";
        }

        if ($order->express && $biayaExpress > 0) {
            $biayaExFmt = 'Rp ' . number_format($biayaExpress, 0, ',', '.');
            $lines[]    = "• Kebutuhan Express (50%) = *{$biayaExFmt}*";
        }

        if ($order->metode_pengiriman && $biayaOngkir > 0) {
            $ongkirFmt = 'Rp ' . number_format($biayaOngkir, 0, ',', '.');
            $kurir     = $order->kurir ?? '–';
            $lines[]   = "• Pengiriman {$kurir} = *{$ongkirFmt}*";
        }

        if ($diskonPersen > 0 && $potonganDiskonAmt > 0) {
            $diskonFmt = 'Rp ' . number_format($potonganDiskonAmt, 0, ',', '.');
            $lines[]   = "• Diskon {$diskonPersen}% = *- {$diskonFmt}*";
        }

        if ($potonganRp > 0) {
            $potRpFmt  = 'Rp ' . number_format($potonganRp, 0, ',', '.');
            $lines[]   = "• Potongan Harga = *- {$potRpFmt}*";
        }

        $detailPesananText = implode("\n", $lines);

        $jumlahBayarFmt    = 'Rp ' . number_format($jumlahBayar, 0, ',', '.');
        $terminSisaFmt     = 'Rp ' . number_format($terminSisa, 0, ',', '.');
        $invoiceUrl        = route('invoice', ['id' => $order->id]);
        $namaPelanggan     = $order->nama_pelanggan;
        $previousTerminFmt = 'Rp ' . number_format($previousTermin, 0, ',', '.');

        // dd($request->input('metode_transaksi'));
        // if($request->input('metode_transaksi')){
        $metodeTxt = match($request->input('metode_transaksi')) {
                    '0' => 'Cash',
                    '1' => 'Transfer',
                    '2' => 'QRIS',
                    default => '–',
                };
           
        // } 

        $totalPayable = ceil($totalPayable);

        if ($previousTermin > 0 && $jumlahBayar == 0) {
            $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                          . "Terima kasih, kami telah menerima *pelunasan sisa termin sebesar {$previousTerminFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                          . "Metode Pembayaran: {$metodeTxt}\n\n"
                          . "==========================\n"
                          . "Berikut detail lengkap pesanan Anda:\n"
                          . "{$detailPesananText}\n"
                          . "*Total = Rp {$totalPayable}*\n\n"
                          . "==========================\n"
                          . "Anda dapat mengunduh invoice di:\n"
                          . "{$invoiceUrl}\n\n"
                          . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                          . "Salam hangat,\n"
                          . "Sinau Print";
        }
        else {
            $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                          . "Terima kasih, kami telah menerima pembayaran sebesar *{$jumlahBayarFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                          . "*Termin Sisa:* {$terminSisaFmt}\n\n"
                          . "Metode Pembayaran: {$metodeTxt}\n\n"
                          . "==========================\n"
                          . "Berikut detail lengkap pesanan Anda:\n"
                          . "{$detailPesananText}\n"
                          . "*Total = Rp {$totalPayable}*\n\n"
                          . "==========================\n"
                          . "Anda dapat mengunduh invoice di:\n"
                          . "{$invoiceUrl}\n\n"
                          . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                          . "Salam hangat,\n"
                          . "Sinau Print";
        }

        $rawNumber = $order->kontak_pelanggan;
        if (preg_match('/^0/', $rawNumber)) {
            $customerNumber = preg_replace('/^0/', '62', $rawNumber);
        } else {
            $customerNumber = $rawNumber;
        }

        $response = Http::withHeaders([
            'Authorization' => config('whatsapp.fonnte_token'),
            'Accept'        => 'application/json',
        ])->asForm()->post(config('whatsapp.fonnte_url'), [
            'target'  => $customerNumber,
            'message' => $messageText,
        ]);

        // dd($response->failed());

        if ($response->failed()) {
            \Log::error("Gagal kirim WhatsApp invoice untuk order ID {$order->id}", [
                'number'   => $customerNumber,
                'response' => $response->body(),
            ]);
        }

        return redirect()
            ->route('orders.payment')
            ->with('success', "Pembayaran Invoice {$invoiceNo} berhasil diverifikasi dan WA invoice terkirim.");
    }

    public function orderVerifIndex(Request $request)
    {
        $ar_order = Order::where(function($query) {
                    $query->where('status_pengerjaan', 'verif_pesanan')
                          ->orWhere('status_pengerjaan', 'produksi');
                });

        $query = $this->generalFilter($ar_order, $request);
        $query->orderBy('express', 'desc')
            ->orderBy('deadline', 'desc');

        $ar_order = $query->get();

        return view('order.orderverif_index', compact('ar_order'));
    }

    public function orderVerifShow($id)
    {
        $order = Order::findOrFail($id);

        $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

        return view('order.orderverif_detail', compact('order','items'));
    }

    public function confirmOrderVerif(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pengerjaan' => 'produksi']);

        return redirect()
            ->route('orders.orderVerif')
            ->with('success', "Order telah masuk tahap produksi dengan SPK: {$order->spk}.");
    }

    public function productionIndex(Request $request)
    {
        // Ambil semua order produksi
        $ar_order = Order::where('status_pengerjaan', 'produksi');
        $query = $this->generalFilter($ar_order, $request);
        $query->orderBy('express', 'desc')
                ->orderBy('deadline', 'desc');
        $ar_order = $query->get();

        // Kumpulkan SPK untuk query massal
        $spks = $ar_order->pluck('spk')->toArray();

        // Hitung total qty per SPK
        $totals = OrderProduct::whereIn('order_id', $spks)
            ->groupBy('order_id')
            ->selectRaw('order_id, SUM(jumlah_pesanan) as total_qty')
            ->pluck('total_qty', 'order_id'); 
            // ->pluck(value, key) jadi array [ spk => total_qty, ... ]

        return view('order.production_index', compact('ar_order', 'totals'));
    }

    public function productionShow($id)
    {
        $order = Order::findOrFail($id);

        $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

        // dd($items);
        return view('order.production_detail', compact('order','items'));
    }

    public function confirmProduction(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status_pengerjaan' => 'pengambilan',
            'quality_control' => 1,
            'proses_produksi' => 1,
            'proses_finishing'=> 1
        ]);

        return redirect()
            ->route('orders.production')
            ->with('success', "Order telah masuk tahap produksi dengan SPK: {$order->spk}.");
    }

    public function shippingIndex(Request $request)
    {
        $ar_order = Order::where('status_pengerjaan', 'pengambilan')
                 ->orderBy('express', 'desc')
                 ->orderBy('deadline', 'desc');
        $query = $this->generalFilter($ar_order, $request);
        $ar_order = $query->get();

      return view('order.shipping_index', compact('ar_order'));
    }
 
    public function shippingShow($id)
    {
        $order = Order::findOrFail($id);

        $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

        $validatorName = null;
        if ($order->id_validator) {
            $validator = User::find($order->id_validator);
            $validatorName = $validator ? $validator->name : null;
        }

        $provinsiId = DB::table('d_provinsi')
                     ->where('id', $order->provinsi)
                     ->pluck('id')
                     ->first();

        $provinsi = DB::table('d_provinsi')
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kota = DB::table('d_kabkota')
                    ->where('d_provinsi_id', $provinsiId)
                    ->orderBy('nama')
                    ->get(['id', 'nama']);

        $kotaId = DB::table('d_kabkota')
                     ->where('id', $order->kota)
                     ->pluck('id')
                     ->first();

        $kecamatan = DB::table('d_kecamatan')
                    ->orderBy('nama')
                    ->where('d_kabkota_id', $kotaId)
                    ->get(['id', 'nama']);

        $kecamatanId = DB::table('d_kecamatan')
                     ->where('id', $order->kecamatan)
                     ->pluck('id')
                     ->first();
        
        $kodepos = DB::table('d_kodepos')
                    ->where('d_kabkota_id', $kotaId)
                    ->where('d_kecamatan_id', $kecamatanId)
                    ->orderBy('kodepos')
                    ->get(['id', 'kodepos as nama']);

        return view('order.shipping_detail', compact('order', 'items', 'validatorName','provinsi','kota', 'kecamatan','kodepos'));
    }

    public function finishPelunasanPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $previousTermin = $order->termin;

        $order->termin            = 0;
        $order->status_pembayaran = 2;
         if ($request->hasFile('bukti_lunas')) {
            $file = $request->file('bukti_lunas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path_bukti_lunas = $file->storeAs('bukti_lunas', $filename, 'public'); 
            $order->bukti_lunas = $path_bukti_lunas;
            $order->metode_transaksi_paid = $request->input('metode_transaksi_paid');
        }
        $order->payment_at = Carbon::now();
        $order->paid_at = Carbon::now();
        // $order->save();

        $rawSpk    = explode('-', $order->spk)[0];
        $invoiceNo = 'INV' . substr($rawSpk, 3);

        $items = OrderProduct::where('order_id', $order->spk)
            ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
            ->join('labels',   'products.label_id',    '=', 'labels.id')
            ->select([
                'order_products.panjang',
                'order_products.lebar',
                'order_products.jumlah_pesanan',
                'products.name as product_name',
                'products.price as product_price',
                'products.additional_size',
                'products.additional_unit',
                'labels.name as label_name',
                'order_products.jenis_finishing',
                'order_products.subtotal'
            ])
            ->get();

        $totalBarang = $items->sum('subtotal');

        $biayaExpress = 0;
        if ($order->express) {
            $biayaExpress = $totalBarang * 0.5;
        }

        $biayaOngkir = $order->metode_pengiriman ? $order->ongkir : 0;

        $diskonPersen = (float) ($order->diskon_persen ?? 0);
        $potonganDiskonAmt = 0;
        if ($diskonPersen > 0) {
            $dasarDiskon = $totalBarang + $biayaExpress;
            $potonganDiskonAmt = $dasarDiskon * ($diskonPersen / 100);
        }

        $potonganRp = (float) ($order->potongan_rp ?? 0);

        $lines = [];
        foreach ($items as $item) {
            $jenisCetak  = $item->label_name;
            $jenisBahan  = $item->product_name;
            if (!empty($item->panjang) && !empty($item->lebar)) {
                $sizeText = "{$item->panjang}×{$item->lebar} cm";
            } elseif (!empty($item->additional_size) && !empty($item->additional_unit)) {
                $sizeText = "{$item->additional_size} {$item->additional_unit}";
            } else {
                $sizeText = "-";
            }
            $qty          = $item->jumlah_pesanan;
            $sub          = $item->subtotal;
            $subFormatted = 'Rp ' . number_format($sub, 0, ',', '.');

            $lines[] = "• {$jenisCetak} – {$jenisBahan} ({$sizeText}) × {$qty} = *{$subFormatted}*";
        }

        if ($order->express && $biayaExpress > 0) {
            $biayaExFmt = 'Rp ' . number_format($biayaExpress, 0, ',', '.');
            $lines[]    = "• Kebutuhan Express (50%) = *{$biayaExFmt}*";
        }

        if ($order->metode_pengiriman && $biayaOngkir > 0) {
            $ongkirFmt = 'Rp ' . number_format($biayaOngkir, 0, ',', '.');
            $kurir     = $order->kurir ?? '–';
            $lines[]   = "• Pengiriman {$kurir} = *{$ongkirFmt}*";
        }

        if ($order->diskon_persen) {
            $diskonFmt = 'Rp ' . number_format($potonganDiskonAmt, 0, ',', '.');
            $lines[]   = "• Diskon {$diskonPersen}% = *- {$diskonFmt}*";
            $totalPayable = number_format($order->subtotal - $potonganDiskonAmt, 0, ',', '.');
        } else if ($order->potongan_rp) {
            $potRpFmt  = 'Rp ' . number_format($order->potongan_rp, 0, ',', '.');
            $lines[]   = "• Potongan Harga = *- {$potRpFmt}*";
            $totalPayable = number_format($order->subtotal - $order->potongan_rp, 0, ',', '.');
        } else {
            $totalPayable = number_format($order->subtotal, 0, ',', '.');
        }

        $order->full_payment = $previousTermin;
        $order->save();

        $detailPesananText = implode("\n", $lines);

        $previousTerminFmt = 'Rp ' . number_format($previousTermin, 0, ',', '.');
        $invoiceUrl        = route('invoice', ['id' => $order->id]);
        $namaPelanggan     = $order->nama_pelanggan;

        $metodeTxt = match ((string) $request->input('metode_transaksi_paid')) {
            '0' => 'Cash',
            '1' => 'Transfer',
            '2' => 'QRIS',
            default => '–',
        };

        // $totalPayable = ceil($totalPayable);
        $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                    . "Terima kasih, kami telah menerima *pelunasan sisa termin sebesar {$previousTerminFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                    . "Metode Pembayaran: {$metodeTxt}\n\n"
                    . "==========================\n"
                    . "Berikut detail lengkap pesanan Anda:\n"
                    . "{$detailPesananText}\n"
                    . "*Total = Rp {$totalPayable}*\n\n"
                    . "==========================\n"
                    . "Anda dapat mengunduh invoice di:\n"
                    . "{$invoiceUrl}\n\n"
                    . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                    . "Salam hangat,\n"
                    . "Sinau Print";

        $rawNumber = $order->kontak_pelanggan;
        if (preg_match('/^0/', $rawNumber)) {
            $customerNumber = preg_replace('/^0/', '62', $rawNumber);
        } else {
            $customerNumber = $rawNumber;
        }

        $response = Http::withHeaders([
            'Authorization' => config('whatsapp.fonnte_token'),
            'Accept'        => 'application/json',
        ])->asForm()->post(config('whatsapp.fonnte_url'), [
            'target'  => $customerNumber,
            'message' => $messageText,
        ]);

        if ($response->failed()) {
            \Log::error("Gagal kirim WA pelunasan untuk order ID {$order->id}", [
                'number'   => $customerNumber,
                'response' => $response->body(),
            ]);
        }

        return redirect()
            ->route('orders.payment')
            ->with('success', "Pembayaran Invoice {$invoiceNo} berhasil dilunasi dan WA invoice terkirim.");
    }

    public function finishPelunasanShipping(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $previousTermin = $order->termin;

        // dd($request->hasFile('bukti_lunas'));

        $order->termin            = 0;
        $order->status_pembayaran = 2;
        
         if ($request->hasFile('bukti_lunas')) {
            $file = $request->file('bukti_lunas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path_bukti_lunas = $file->storeAs('bukti_lunas', $filename, 'public'); 
            $order->bukti_lunas = $path_bukti_lunas;
            $order->metode_transaksi_paid = $request->input('metode_transaksi_paid');
        }
        $order->payment_at = Carbon::now();
        $order->paid_at = Carbon::now();

        $rawSpk    = explode('-', $order->spk)[0];
        $invoiceNo = 'INV' . substr($rawSpk, 3);

        $items = OrderProduct::where('order_id', $order->spk)
            ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
            ->join('labels',   'products.label_id',    '=', 'labels.id')
            ->select([
                'order_products.panjang',
                'order_products.lebar',
                'order_products.jumlah_pesanan',
                'products.name as product_name',
                'products.price as product_price',
                'products.additional_size',
                'products.additional_unit',
                'labels.name as label_name',
                'order_products.jenis_finishing',
                'order_products.subtotal'
            ])
            ->get();

        $totalBarang = $items->sum('subtotal');

        $biayaExpress = 0;
        if ($order->express) {
            $biayaExpress = $totalBarang * 0.5;
        }

        $biayaOngkir = $order->metode_pengiriman ? $order->ongkir : 0;

        $diskonPersen = (float) ($order->diskon_persen ?? 0);
        $potonganDiskonAmt = 0;
        if ($diskonPersen > 0) {
            $dasarDiskon = $totalBarang + $biayaExpress;
            $potonganDiskonAmt = $dasarDiskon * ($diskonPersen / 100);
        }

        $potonganRp = (float) ($order->potongan_rp ?? 0);

        $lines = [];
        foreach ($items as $item) {
            $jenisCetak  = $item->label_name;
            $jenisBahan  = $item->product_name;
            if (!empty($item->panjang) && !empty($item->lebar)) {
                $sizeText = "{$item->panjang}×{$item->lebar} cm";
            } elseif (!empty($item->additional_size) && !empty($item->additional_unit)) {
                $sizeText = "{$item->additional_size} {$item->additional_unit}";
            } else {
                $sizeText = "-";
            }
            $qty          = $item->jumlah_pesanan;
            $sub          = $item->subtotal;
            $subFormatted = 'Rp ' . number_format($sub, 0, ',', '.');

            $lines[] = "• {$jenisCetak} – {$jenisBahan} ({$sizeText}) × {$qty} = *{$subFormatted}*";
        }

        if ($order->express && $biayaExpress > 0) {
            $biayaExFmt = 'Rp ' . number_format($biayaExpress, 0, ',', '.');
            $lines[]    = "• Kebutuhan Express (50%) = *{$biayaExFmt}*";
        }

        if ($order->metode_pengiriman && $biayaOngkir > 0) {
            $ongkirFmt = 'Rp ' . number_format($biayaOngkir, 0, ',', '.');
            $kurir     = $order->kurir ?? '–';
            $lines[]   = "• Pengiriman {$kurir} = *{$ongkirFmt}*";
        }

        if ($order->diskon_persen) {
            $diskonFmt = 'Rp ' . number_format($potonganDiskonAmt, 0, ',', '.');
            $lines[]   = "• Diskon {$diskonPersen}% = *- {$diskonFmt}*";
            $totalPayable = number_format($order->subtotal - $potonganDiskonAmt, 0, ',', '.');
        } else if ($order->potongan_rp) {
            $potRpFmt  = 'Rp ' . number_format($order->potongan_rp, 0, ',', '.');
            $lines[]   = "• Potongan Harga = *- {$potRpFmt}*";
            $totalPayable = number_format($order->subtotal - $order->potongan_rp, 0, ',', '.');
        } else {
            $totalPayable = number_format($order->subtotal, 0, ',', '.');
        }

        // dd($totalPayable);
        $order->full_payment = $previousTermin;
        $order->save();

        $detailPesananText = implode("\n", $lines);

        $previousTerminFmt = 'Rp ' . number_format($previousTermin, 0, ',', '.');
        $invoiceUrl        = route('invoice', ['id' => $order->id]);
        $namaPelanggan     = $order->nama_pelanggan;

        $metodeTxt = match ((string) $request->input('metode_transaksi_paid')) {
            '0' => 'Cash',
            '1' => 'Transfer',
            '2' => 'QRIS',
            default => '–',
        };

        // $totalPayable = ceil($totalPayable);
        $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                    . "Terima kasih, kami telah menerima *pelunasan sisa termin sebesar {$previousTerminFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                    . "Metode Pembayaran: {$metodeTxt}\n\n"
                    . "==========================\n"
                    . "Berikut detail lengkap pesanan Anda:\n"
                    . "{$detailPesananText}\n"
                    . "*Total = Rp {$totalPayable}*\n\n"
                    . "==========================\n"
                    . "Anda dapat mengunduh invoice di:\n"
                    . "{$invoiceUrl}\n\n"
                    . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                    . "Salam hangat,\n"
                    . "Sinau Print";

        $rawNumber = $order->kontak_pelanggan;
        if (preg_match('/^0/', $rawNumber)) {
            $customerNumber = preg_replace('/^0/', '62', $rawNumber);
        } else {
            $customerNumber = $rawNumber;
        }

        $response = Http::withHeaders([
            'Authorization' => config('whatsapp.fonnte_token'),
            'Accept'        => 'application/json',
        ])->asForm()->post(config('whatsapp.fonnte_url'), [
            'target'  => $customerNumber,
            'message' => $messageText,
        ]);

        if ($response->failed()) {
            \Log::error("Gagal kirim WA pelunasan untuk order ID {$order->id}", [
                'number'   => $customerNumber,
                'response' => $response->body(),
            ]);
        }

        return redirect()
            ->route('orders.shippingShow', $order->id)
            ->with('success', "Pembayaran Invoice {$invoiceNo} berhasil dilunasi dan WA invoice terkirim.");
    }

    public function confirmPaymentShipping(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->diskon_persen    = null;
        $order->potongan_rp      = null;
        $order->metode_transaksi = $request->input('metode_transaksi');
        $diskonPersen = 0;
        if ($request->has('diskon_persen')) {
            $diskonPersen        = (float) $request->input('diskon_persen');
            $order->diskon_persen = $diskonPersen;
        }
        $potonganRp = 0;
        if ($request->has('potongan_rp')) {
            $potonganRp        = (float) $request->input('potongan_rp');
            $order->potongan_rp = $potonganRp;
        }

        $jumlahBayar = (float) $request->input('jumlah_bayar', 0);
        // dd(number_format($jumlahBayar, 0, ',', '.'));

        
        $previousTermin = $order->termin;
        
        $newTermin      = (float) $request->input('termin', 0);
        $order->termin  = $newTermin;
        // dd($newTermin);

        if ($order->status_pembayaran == 0) {
            $order->id_validator = Auth::id();
        }


        // $order->status_pengerjaan = 'pengambilan';
        $order->status_pembayaran = ($order->termin > 0) ? 1 : 2;

        if($newTermin == 0){
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path_bukti_bayar = $file->storeAs('bukti_bayar', $filename, 'public'); 
                $order->bukti_bayar = $path_bukti_bayar;
                $order->bukti_lunas = $path_bukti_bayar;
                $order->metode_transaksi = $request->input('metode_transaksi');
                $order->metode_transaksi_paid = $request->input('metode_transaksi');
            }

            $order->dp = $jumlahBayar;
            $order->full_payment = $jumlahBayar;

            $order->payment_at = Carbon::now();
            $order->paid_at = Carbon::now();
            
        } else{
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path_bukti_bayar = $file->storeAs('bukti_bayar', $filename, 'public'); 
                $order->bukti_bayar = $path_bukti_bayar;
                $order->metode_transaksi = $request->input('metode_transaksi');
            }
            $order->dp = $jumlahBayar;
            $order->payment_at = Carbon::now();
        }

        $order->save();

        $rawSpk    = explode('-', $order->spk)[0];
        $invoiceNo = 'INV' . substr($rawSpk, 3);

        $items = OrderProduct::where('order_id', $order->spk)
            ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
            ->join('labels',   'products.label_id',    '=', 'labels.id')
            ->select([
                'order_products.panjang',
                'order_products.lebar',
                'order_products.jumlah_pesanan',
                'products.name as product_name',
                'products.price as product_price',
                'products.additional_size',
                'products.additional_unit',
                'labels.name as label_name',
                'order_products.jenis_finishing',
                'order_products.subtotal'
            ])
            ->get();

        $totalBarang = $items->sum('subtotal');

        $biayaExpress = 0;
        if ($order->express) {
            $biayaExpress = $totalBarang * 0.5;
        }

        $biayaOngkir = $order->metode_pengiriman ? $order->ongkir : 0;

        $potonganDiskonAmt = 0;
        if ($diskonPersen > 0) {
            $dasarDiskon = $totalBarang + $biayaExpress; //FIXINGGG!!
            $potonganDiskonAmt = $dasarDiskon * ($diskonPersen / 100);
        }

        $totalPayable = $totalBarang
                      + $biayaExpress
                      + $biayaOngkir
                      - $potonganDiskonAmt
                      - $potonganRp;

        $terminSisa   = max(0, $totalPayable - $jumlahBayar);

        $lines = [];
        foreach ($items as $item) {
            $jenisCetak  = $item->label_name;
            $jenisBahan  = $item->product_name;
            if (!empty($item->panjang) && !empty($item->lebar)) {
                $sizeText = "{$item->panjang}×{$item->lebar} cm";
            } elseif (!empty($item->additional_size) && !empty($item->additional_unit)) {
                $sizeText = "{$item->additional_size} {$item->additional_unit}";
            } else {
                $sizeText = "-";
            }
            $qty          = $item->jumlah_pesanan;
            $sub          = $item->subtotal;
            $subFormatted = 'Rp ' . number_format($sub, 0, ',', '.');

            $lines[] = "• {$jenisCetak} – {$jenisBahan} ({$sizeText}) × {$qty} = *{$subFormatted}*";
        }

        if ($order->express && $biayaExpress > 0) {
            $biayaExFmt = 'Rp ' . number_format($biayaExpress, 0, ',', '.');
            $lines[]    = "• Kebutuhan Express (50%) = *{$biayaExFmt}*";
        }

        if ($order->metode_pengiriman && $biayaOngkir > 0) {
            $ongkirFmt = 'Rp ' . number_format($biayaOngkir, 0, ',', '.');
            $kurir     = $order->kurir ?? '–';
            $lines[]   = "• Pengiriman {$kurir} = *{$ongkirFmt}*";
        }

        if ($diskonPersen > 0 && $potonganDiskonAmt > 0) {
            $diskonFmt = 'Rp ' . number_format($potonganDiskonAmt, 0, ',', '.');
            $lines[]   = "• Diskon {$diskonPersen}% = *- {$diskonFmt}*";
        }

        if ($potonganRp > 0) {
            $potRpFmt  = 'Rp ' . number_format($potonganRp, 0, ',', '.');
            $lines[]   = "• Potongan Harga = *- {$potRpFmt}*";
        }

        $detailPesananText = implode("\n", $lines);

        $jumlahBayarFmt    = 'Rp ' . number_format($jumlahBayar, 0, ',', '.');
        $terminSisaFmt     = 'Rp ' . number_format($terminSisa, 0, ',', '.');
        $invoiceUrl        = route('invoice', ['id' => $order->id]);
        $namaPelanggan     = $order->nama_pelanggan;
        $previousTerminFmt = 'Rp ' . number_format($previousTermin, 0, ',', '.');

        // dd($request->input('metode_transaksi'));
        // if($request->input('metode_transaksi')){
        $metodeTxt = match($request->input('metode_transaksi')) {
                    '0' => 'Cash',
                    '1' => 'Transfer',
                    '2' => 'QRIS',
                    default => '–',
                };
           
        // } 

        $totalPayable = ceil($totalPayable);

        if ($previousTermin > 0 && $jumlahBayar == 0) {
            $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                          . "Terima kasih, kami telah menerima *pelunasan sisa termin sebesar {$previousTerminFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                          . "Metode Pembayaran: {$metodeTxt}\n\n"
                          . "==========================\n"
                          . "Berikut detail lengkap pesanan Anda:\n"
                          . "{$detailPesananText}\n"
                          . "*Total = Rp {$totalPayable}*\n\n"
                          . "==========================\n"
                          . "Anda dapat mengunduh invoice di:\n"
                          . "{$invoiceUrl}\n\n"
                          . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                          . "Salam hangat,\n"
                          . "Sinau Print";
        }
        else {
            $messageText  = "Halo *{$namaPelanggan}*,\n\n"
                          . "Terima kasih, kami telah menerima pembayaran sebesar *{$jumlahBayarFmt}* untuk Invoice *{$invoiceNo}*.\n\n"
                          . "*Termin Sisa:* {$terminSisaFmt}\n\n"
                          . "Metode Pembayaran: {$metodeTxt}\n\n"
                          . "==========================\n"
                          . "Berikut detail lengkap pesanan Anda:\n"
                          . "{$detailPesananText}\n"
                          . "*Total = Rp {$totalPayable}*\n\n"
                          . "==========================\n"
                          . "Anda dapat mengunduh invoice di:\n"
                          . "{$invoiceUrl}\n\n"
                          . "Jika ada pertanyaan atau kendala, silakan balas pesan ini.\n\n"
                          . "Salam hangat,\n"
                          . "Sinau Print";
        }

        $rawNumber = $order->kontak_pelanggan;
        if (preg_match('/^0/', $rawNumber)) {
            $customerNumber = preg_replace('/^0/', '62', $rawNumber);
        } else {
            $customerNumber = $rawNumber;
        }

        $response = Http::withHeaders([
            'Authorization' => config('whatsapp.fonnte_token'),
            'Accept'        => 'application/json',
        ])->asForm()->post(config('whatsapp.fonnte_url'), [
            'target'  => $customerNumber,
            'message' => $messageText,
        ]);

        // dd($response->failed());

        if ($response->failed()) {
            \Log::error("Gagal kirim WhatsApp invoice untuk order ID {$order->id}", [
                'number'   => $customerNumber,
                'response' => $response->body(),
            ]);
        }

        return redirect()
            ->route('orders.shippingShow', $order->id)
            ->with('success', "Pembayaran Invoice {$invoiceNo} berhasil diverifikasi dan WA invoice terkirim.");
    }

    public function confirmShipping(Request $request, $id)
    {
        // dd($request);
        $order = Order::findOrFail($id);
        $order->update(['status_pengambilan' => 1, 'pickup' => Carbon::now()]);

        return redirect()
                ->route('orders.shipping')
                ->with('success', "Order telah diambil/dikirim. SPK: {$order->spk}.");
    }

    public function completeShipping(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pengerjaan' => 'selesai']);

        return redirect()
                ->route('orders.shipping')
                ->with('success', "Order telah masuk tahap selesai. SPK: {$order->spk}.");
    }

    public function completedIndex(Request $request)
    {
         $ar_order = Order::where('status_pengerjaan', 'selesai')
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu', 'desc');
        $query = $this->generalFilter($ar_order, $request);
        $ar_order = $query->get();

        return view('order.completed_index', compact('ar_order'));
    }

    public function completedShow($id)
    {
        $order = Order::findOrFail($id);
        $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

        return view('order.completed_detail', compact('order', 'items'));
    }

    public function confirmCanceled(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldData = $order->status_pengerjaan == 'verif_pembayaran' ? 'Invoce Anda diubah menjadi SPK dengan no ' . $order->spk . ' berhasil dicancel': null;
        $successStatus = $oldData ? $oldData : "Order dengan nomor SPK: {$order->spk}. berhasil di cancel";
        
        $order->update([
            'status_pengerjaan' => 'cancel',
            'cancel_reason' => $request->cancel_reason
        ]);
        return redirect()
            ->route('orders.canceled')
            ->with('success', $successStatus);
    }

    public function canceledIndex(Request $request)
    {
         $ar_order = Order::where('status_pengerjaan', 'cancel')
                 ->orderBy('express', 'desc')
                 ->orderBy('deadline', 'desc');
        $query = $this->generalFilter($ar_order, $request);
        $ar_order = $query->get();

        return view('order.canceled_index', compact('ar_order'));
    }

    public function canceledShow($id)
    {
        $order = Order::findOrFail($id);
        // dd($order->preview);
       $items = OrderProduct::where('order_id', $order->spk)
                ->join('products', 'order_products.jenis_bahan', '=', 'products.id')
                ->join('labels', 'products.label_id', '=', 'labels.id')
                ->leftjoin('finishings', 'order_products.jenis_finishing', '=', 'finishings.id')
                ->select([
                                'order_products.*',
                                'products.*',
                                'finishings.*',
                                'labels.unit as unit_name',
                                'labels.name as label_name',
                            ])
                ->get();

        return view('order.canceled_detail', compact('order', 'items'));
    }

    public function convertInvoiceToSpk($invoiceCode)
    {
        $code = str_replace('INV', '', $invoiceCode);
        $finalSPK =  'SPK' . $code;

        return $finalSPK;
    }

    public function convertSpkToInvoice($spkCode)
    {
        $withoutPrefix = str_replace('SPK', '', $spkCode);
        $mainCode = explode('-', $withoutPrefix)[0];
        $finalInvoice = 'INV' . $mainCode;

        return $finalInvoice;
    }
}

