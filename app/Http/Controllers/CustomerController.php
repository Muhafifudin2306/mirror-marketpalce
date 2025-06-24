<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_user = DB::table('users')
                ->where('users.role', '=', 'Customer')
                ->select('users.*')
                ->orderBy('users.role', 'desc')
                ->get();
        return view('adminpage.customer.index', compact('ar_user'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enumOptions = ['Admin', 'Staff', 'Customer'];

        return view('adminpage.customer.form', compact('enumOptions'));
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
        return redirect()->route('admin.customer.index')->with('success', 'User berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = User::find($id);
        return view('adminpage.customer.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = User::findOrFail($id);
        $enumOptions = ['Admin', 'Staff', 'Customer'];
        return view('adminpage.customer.form_edit', compact('row', 'enumOptions'));
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

        return redirect()->route('admin.customer.index')->with('success', 'Data user berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();
        return redirect()->route('admin.customer.index')
                        ->with('success', 'Data User Berhasil Dihapus');
    }
}