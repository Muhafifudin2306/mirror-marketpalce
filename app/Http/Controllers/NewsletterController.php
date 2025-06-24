<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_newsletter = DB::table('newsletters')
                        ->select('newsletters.*')
                        ->orderBy('newsletters.created_at', 'desc')
                        ->get();
        return view('adminpage.newsletter.index', compact('ar_newsletter'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminpage.newsletter.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'email'        => 'required|email|unique:newsletters,email',
        ]);

        Newsletter::create($validatedData);

        return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $rs = Newsletter::find($id);
    //     return view('customer.detail', compact('rs'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = Newsletter::findOrFail($id);
        return view('adminpage.newsletter.form_edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email'       => [
                'required',
                'email',
                Rule::unique('newsletters', 'email')->ignore($id),
            ],
        ]);

        $newsletter = Newsletter::findOrFail($id);

        $newsletter->email = $request->email;

        $newsletter->save();

        return redirect()->route('admin.newsletter.index')->with('success', 'Data newsletter berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsletter = Newsletter::find($id);

        $newsletter->delete();
        return redirect()->route('admin.newsletter.index')
                        ->with('success', 'Data Newsletter Berhasil Dihapus');
    }
}