<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Buku;
use App\Models\User;
use Midtrans\Config;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\PelangganExport;
use Midtrans\Error\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pelanggan; //panggil model
use Illuminate\Support\Facades\DB; //query builder

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_user = DB::table('users')
                ->select('users.*')
                ->orderBy('users.role', 'desc')
                ->get();
        return view('user.index', compact('ar_user'));
    }

    public function dataUser(Request $request)
    {
        $user = auth()->user();

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

        return view('landingpage.profile', compact('user', 'search'));
    }

    public function keranjang(Request $request)
    {
        $user = Auth::user();
    
        $keranjang = DB::table('pesanan')
                    ->join('buku', 'buku.id', '=', 'pesanan.buku_id')
                    ->select('pesanan.*', 'buku.judul as buku_judul', 'buku.harga as buku_harga', 'buku.foto as buku_foto', 'buku.diskon as buku_diskon')
                    ->where('pesanan.user_id', $user->id)
                    ->where('pesanan.ket', 'Pending')
                    ->get();
                    
                    $selectedItems = [];
    
        foreach ($keranjang as $detail) {
            $subtotal = $detail->buku_harga - ($detail->buku_harga * $detail->buku_diskon / 100);
            $formattedHarga = number_format($detail->buku_harga, 0, ',', '.');
            $formattedSubtotal = number_format($subtotal, 0, ',', '.');
    
            if ($detail->buku_diskon > 0) {
                $selectedItems[] = [
                    'pesanan_id' => $detail->id,
                    'harga' => $subtotal
                ];
            }
            
            $detail->buku_harga_formatted = $formattedHarga;
            $detail->subtotal_formatted = $formattedSubtotal;
        }

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
        
        return view('landingpage.keranjang', compact('keranjang', 'selectedItems', 'search'));
    }
    

    public function checkout(Request $request)
    {
        // dd($request->all());
        $selectedData = $request->pesanan;
        $pesan = Pesanan::findOrFail($selectedData);
        // dd($pesan);
        $harga = $pesan->buku->harga;
        $diskon = $pesan->buku->diskon;
        if($diskon == null || $diskon == 0){
            $after_diskon = $harga;
        }
        else{
            $after_diskon = $harga - (($diskon/100) * $harga);
        }

        $pesananIds = $pesan;
        $grossAmounts = $after_diskon;
        // dd($grossAmounts);

         // Server Key
        Config::$serverKey = config('midtrans.server_key');
        // dd(config('midtrans.server_key'));
        // $server = \Midtrans\Config::$serverKey;
        Config::$isProduction = config('midtrans.is_production');
        // Set sanitization
        Config::$isSanitized = true;
        // Set 3DS transaction untuk credit card
        Config::$is3ds = true;

        
        if (Auth::check()) {
            $user = Auth::user();
            $namaUser = $user->name;
            $emailUser = $user->email;
            $phoneUser = $user->hp;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $pesan->id,
                    'gross_amount' => $grossAmounts,
                ),
                'customer_details' => array(
                    'first_name' => $namaUser,
                    // 'last_name' => 'pratama',
                    'email' => $emailUser,
                    'phone' => $phoneUser,
                ),
            );
        }

        $snapToken = Snap::getSnapToken($params);
        // dd($snapToken);
        return view('landingpage.pay', compact('pesan', 'snapToken', 'grossAmounts', 'namaUser'));
    }

    public function pustaka(Request $request)
    {
        $user = Auth::user();
        $buku_terpilih = Buku::query();

        $urutan = $request->urutan;
        $search = $request->search;
    
        $buku_terpilih = DB::table('pesanan')
                    ->join('buku', 'buku.id', '=', 'pesanan.buku_id')
                    ->select('pesanan.*', 'buku.judul as buku_judul', 'buku.foto as buku_foto')
                    ->where('pesanan.user_id', $user->id)
                    ->where('pesanan.ket', 'Done');
    
        // Filter search
        if ($search) {
            $buku_terpilih->where(function ($query) use ($search) {
                $query->where('buku.judul', 'like', '%'.$search.'%')
                    ->orWhere('buku.pengarang', 'like', '%'.$search.'%')
                    ->orWhere('buku.harga', 'like', '%'.$search.'%')
                    ->orWhere('buku.isbn', 'like', '%'.$search.'%')
                    ->orWhere('buku.sinopsis', 'like', '%'.$search.'%')
                    ->orWhere('buku.jumlah_halaman', 'like', '%'.$search.'%');
            });
        }
    
        // Urut berdasarkan
        if ($urutan == 'terbaru') {
            $buku_terpilih->orderBy('pesanan.id', 'desc');
        } elseif ($urutan == 'terlama') {
            $buku_terpilih->orderBy('pesanan.id', 'asc');
        }
    
        $buku_terpilih = $buku_terpilih->get();
        
        return view('landingpage.pustaka', compact('buku_terpilih', 'urutan', 'search'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enumOptions = ['Admin', 'Staff', 'Customer'];

        return view('user.form', compact('enumOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:Admin,Staff,Customer',
            'phone'        => 'required|string|max:20',
            'province'     => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'address'      => 'nullable|string|max:255',
            'postal_code'  => 'nullable|numeric|digits_between:4,6',
        ]);

        // Enkripsi password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Buat user baru
        User::create($validatedData);

        // Redirect dengan notifikasi
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = User::find($id);
        return view('user.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = User::findOrFail($id);
        $enumOptions = ['Admin', 'Staff', 'Customer'];
        return view('user.form_edit', compact('row', 'enumOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'role'        => 'required|in:Admin,Staff,Customer',
            'phone'       => 'required|string|max:20',
            'province'    => 'nullable|string|max:100',
            'city'        => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'postal_code' => 'nullable|numeric|digits_between:4,6',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->postal_code = $request->postal_code;

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }


    public function ubahProfil(string $id, Request $request)
    {
        $row = User::find($id);

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

        return view('landingpage.profile_edit', compact('row', 'search'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!empty($user->foto)) {
            $fotoPath = public_path('landingpage/img/'.$user->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $user->delete();
        return redirect()->route('user.index')
                        ->with('success', 'Data User Berhasil Dihapus');
    }

    public function pay()
    {
        return view('landingpage.pay');
    }
}