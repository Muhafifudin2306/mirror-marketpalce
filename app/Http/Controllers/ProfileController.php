<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * SPA page
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $orders = Order::with('orderProducts')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landingpage.profile', compact('user', 'orders'));
    }

    /**
     * Update informasi profil.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'email'             => ['required','email', Rule::unique('users', 'email')->ignore($user->id),],
            'phone'             => ['required','regex:/^08[0-9]{8,11}$/'],
            'province'          => 'nullable|string|max:100',
            'city'              => 'nullable|string|max:100',
            'address'           => 'nullable|string|max:255',
            'postal_code'       => ['nullable','regex:/^[0-9]{5}$/'],
            // 'current_password'  => ['nullable', 'string', 'required_with:new_password'],
            // 'new_password'      => 'nullable|string|min:8|confirmed',
        ], [
            // first_name
            'first_name.required'   => 'Nama depan wajib diisi.',
            'first_name.string'     => 'Nama depan harus berupa teks.',
            'first_name.max'        => 'Nama depan maksimal 100 karakter.',

            // last_name
            'last_name.required'    => 'Nama belakang wajib diisi.',
            'last_name.string'      => 'Nama belakang harus berupa teks.',
            'last_name.max'         => 'Nama belakang maksimal 100 karakter.',

            // email
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',

            // phone
            'phone.required'        => 'No. telepon wajib diisi.',
            'phone.regex'           => 'No. telepon harus mulai dengan 08 dan terdiri dari 10–13 digit.',

            // province
            'province.string'       => 'Provinsi harus berupa teks.',
            'province.max'          => 'Provinsi maksimal 100 karakter.',

            // city
            'city.string'           => 'Kota/kabupaten harus berupa teks.',
            'city.max'              => 'Kota/kabupaten maksimal 100 karakter.',

            // address
            'address.string'        => 'Detail alamat harus berupa teks.',
            'address.max'           => 'Detail alamat maksimal 255 karakter.',

            // postal_code
            'postal_code.regex'     => 'Kode pos harus berupa 5 digit angka.',

            // current_password
            // 'current_password.required_with' => 'Sandi saat ini wajib diisi jika ingin mengganti sandi.',
            // 'current_password.string'        => 'Sandi saat ini harus berupa teks.',

            // new_password
            // 'new_password.min'      => 'Sandi baru minimal 8 karakter.',
            // 'new_password.confirmed'=> 'Konfirmasi sandi baru tidak sesuai.',
        ]);

        $user->first_name   = $data['first_name'];
        $user->last_name    = $data['last_name'];
        $user->email        = $data['email'];
        $user->phone        = $data['phone'] ?? null;
        $user->province     = $data['province'] ?? null;
        $user->city         = $data['city'] ?? null;
        $user->address      = $data['address'] ?? null;
        $user->postal_code  = $data['postal_code'] ?? null;

        // Validasi password manual setelahnya
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Sandi saat ini wajib diisi.'])->withInput();
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Sandi saat ini tidak cocok.'])->withInput();
            }

            if (strlen($request->new_password) < 8) {
                return back()->withErrors(['new_password' => 'Sandi baru minimal 8 karakter.'])->withInput();
            }

            if ($request->new_password != $request->new_password_confirmation) {
                return back()->withErrors(['new_password_confirmation' => 'Konfirmasi sandi baru tidak sesuai.'])->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function markNotificationAsRead($id)
    {
        $notif = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notif->notification_status = 1;
        $notif->save();
        return response()->noContent();
    }
}
