<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_faqs = DB::table('faqs')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('adminpage.faq.index', compact('ar_faqs'));
    }

    public function create()
    {
        return view('adminpage.faq.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'type'      => 'required|in:Pembelian,Akun,Desain,Keamanan,Kontak',
            'is_active' => 'required|boolean',
        ]);

        DB::table('faqs')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function show($id)
    {
        $row = DB::table('faqs')->find($id);
        return view('adminpage.faq.detail', compact('row'));
    }

    public function edit($id)
    {
        $row = DB::table('faqs')->find($id);
        return view('adminpage.faq.form_edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'type'      => 'required|in:Pembelian,Akun,Desain,Keamanan,Kontak',
            'is_active' => 'required|boolean',
        ]);

        DB::table('faqs')->where('id', $id)->update(array_merge($validated, [
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('faqs')->where('id', $id)->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}