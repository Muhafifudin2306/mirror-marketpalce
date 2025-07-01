<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
     * Show detail order
     */
    public function showOrder(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load([
            'orderProducts.product.images',
            'orderProducts.product.label.finishings',
            'user'
        ]);

        $orderProduct = $order->orderProducts->first();
        $product = $orderProduct->product ?? null;

        if (!$product) {
            abort(404, 'Product not found');
        }

        switch ($order->order_status) {
            case 0:
                $badge = '#ffd782';
                $foncol = '#444444';
                $firlabel = 'Menunggu';
                $seclabel = 'Pembayaran';
                break;
            case 1:
                $badge = '#5ee3e3';
                $foncol = '#444444';
                $firlabel = 'Dalam';
                $seclabel = 'Pengerjaan';
                break;
            case 2:
                $badge = '#abceff';
                $foncol = '#444444';
                $firlabel = 'Dalam';
                $seclabel = 'Pengiriman';
                break;
            case 3:
                $badge = '#0258d3';
                $foncol = '#fff';
                $firlabel = 'Pesanan';
                $seclabel = 'Selesai';
                break;
            case 9:
                $badge = '#f8d7da';
                $foncol = '#444444';
                $firlabel = 'Order';
                $seclabel = 'Dibatalkan';
                break;
            default:
                $badge = '#e9ecef';
                $foncol = '#444444';
                $firlabel = 'Status';
                $seclabel = 'Unknown';
                break;
        }

        $bestProducts = Product::with('images')
            ->withCount('orderProducts')
            ->orderByDesc('order_products_count')
            ->limit(4)
            ->get();

        $isEdit = false;

        return view('landingpage.order_detail', compact(
            'order',
            'orderProduct',
            'product',
            'bestProducts',
            'isEdit',
            'badge',
            'foncol',
            'firlabel',
            'seclabel'
        ));
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Order $order)
    {
        try {
            if ($order->user_id != auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($order->order_status != 0) {
                return response()->json(['error' => 'Order tidak dapat dibatalkan'], 400);
            }

            DB::beginTransaction();
            
            $order->update(['order_status' => 9]);
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Order berhasil dibatalkan'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error cancelling order: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal membatalkan order: ' . $e->getMessage()
            ], 500);
        }
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
