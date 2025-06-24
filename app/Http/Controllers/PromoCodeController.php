<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_promocode = DB::table('promo_codes')
                ->select('promo_codes.*')
                ->orderBy('promo_codes.start_at', 'desc')
                ->get();
        return view('adminpage.promocode.index', compact('ar_promocode'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminpage.promocode.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'code'              => 'required|string|unique:promo_codes,code',
            'discount_percent'  => 'nullable|integer|between:0,100',
            'discount_fix'      => 'nullable|integer',
            'max_discount'      => 'nullable|integer',
            'start_at'          => 'required|date',
            'end_at'            => 'required|date|after_or_equal:start_at',
            'usage_limit'       => 'nullable|integer',
        ]);

        PromoCode::create($validatedData);

        // Redirect dengan notifikasi
        return redirect()->route('admin.promocode.index')->with('success', 'Kode promo berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = PromoCode::findOrFail($id);
        return view('adminpage.promocode.form_edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code'              => ['required', 'string', Rule::unique('promo_codes', 'code')->ignore($id),],
            'discount_percent'  => 'nullable|integer|between:0,100',
            'discount_fix'      => 'nullable|integer',
            'max_discount'      => 'nullable|integer',
            'start_at'          => 'required|date',
            'end_at'            => 'required|date|after_or_equal:start_at',
            'usage_limit'       => 'nullable|integer',
        ]);

        $promocode = PromoCode::findOrFail($id);

        $promocode->code = $request->code;
        $promocode->discount_percent = $request->discount_percent;
        $promocode->discount_fix = $request->discount_fix;
        $promocode->max_discount = $request->max_discount;
        $promocode->start_at = $request->start_at;
        $promocode->end_at = $request->end_at;
        $promocode->usage_limit = $request->usage_limit;

        $promocode->save();

        return redirect()->route('admin.promocode.index')->with('success', 'Data promo berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promo = PromoCode::find($id);

        $promo->delete();
        return redirect()->route('admin.promocode.index')
                        ->with('success', 'Data Promo Berhasil Dihapus');
    }
}