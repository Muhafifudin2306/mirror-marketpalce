<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::orderBy('created_at', 'desc')->get();
        return view('adminpage.banner.index', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminpage.banner.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading'   => 'required|string|max:255',
            'content'   => 'nullable|string|max:255',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('banner', 'public');
            $validated['photo'] = $path;
        }

        Banner::create($validated);

        return redirect()->route('admin.banner.index')
                         ->with('success', 'Banner added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('adminpage.banner.form_edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($banner->photo) {
                Storage::disk('public')->delete($banner->photo);
            }
            $validated['photo'] = $request->file('photo')->store('banner','public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banner.index')
                         ->with('success','Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->photo) {
            Storage::disk('public')->delete($banner->photo);
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')
                         ->with('success', 'Banner deleted successfully.');
    }
}