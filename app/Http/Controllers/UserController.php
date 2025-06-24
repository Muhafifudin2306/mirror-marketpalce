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
                ->where('users.role', '!=', 'Customer')
                ->select('users.*')
                ->orderBy('users.role', 'desc')
                ->get();
        return view('adminpage.user.index', compact('ar_user'));
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
                    // 'last_name' => 'hanips',
                    'email' => $emailUser,
                    'phone' => $phoneUser,
                ),
            );
        }

        $snapToken = Snap::getSnapToken($params);
        // dd($snapToken);
        return view('landingpage.pay', compact('pesan', 'snapToken', 'grossAmounts', 'namaUser'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enumOptions = ['Admin', 'Staff', 'Customer'];

        return view('adminpage.user.form', compact('enumOptions'));
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
        return view('adminpage.user.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = User::findOrFail($id);
        $enumOptions = ['Admin', 'Staff', 'Customer'];
        return view('adminpage.user.form_edit', compact('row', 'enumOptions'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();
        return redirect()->route('user.index')
                        ->with('success', 'Data User Berhasil Dihapus');
    }

    public function pay()
    {
        return view('landingpage.pay');
    }
}