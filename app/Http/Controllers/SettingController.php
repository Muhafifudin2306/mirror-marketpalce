<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::latest()->get();
        return view('adminpage.setting.index', compact('settings'));
    }

    public function create()
    {
        return view('adminpage.setting.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'     => 'nullable|string',
            'content'   => 'nullable|string',
        ]);

        $bannerPath = $request->file('banner')?->store('banners', 'public');

        Setting::create([
            'type'     => $request->type,
            'content'   => $request->content
        ]);

        return redirect()->route('admin.setting.index')
                        ->with('success', 'Setting created');
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('adminpage.setting.form_edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type'     => 'nullable|string',
            'content'   => 'nullable|string'
        ]);

        $setting = Setting::findOrFail($id);

        $setting->update([
            'type'     => $request->type,
            'content'   => $request->content
        ]);

        return redirect()->route('admin.setting.index')
                        ->with('success', 'Setting updated');
    }

    public function destroy($id)
    {
        // Storage::disk('public')->delete($setting->banner);
        $setting = Setting::findOrFail($id);
        // dd($setting);
        $setting->delete();
        return redirect()->route('admin.setting.index')->with('success', 'Setting deleted');
    }

    public function kebijakanIndex(){
        $settings = Setting::where('type','kebijakan-privasi')->first();
        $setting = $settings->content;
        return view('landingpage.kebijakan_privasi', compact('setting'));
    }

    public function penggunaanIndex(){
        $settings = Setting::where('type','syarat-ketentuan')->first();
        $setting = $settings->content;
        return view('landingpage.syarat_penggunaan', compact('setting'));
    }
}