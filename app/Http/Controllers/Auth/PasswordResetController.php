<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = strtolower(trim($request->email));
        
        $user = \App\Models\User::whereRaw('LOWER(email) = ?', [$email])->first();
        
        if (!$user) {
            
            $errorMessage = 'Email tidak ditemukan dalam sistem kami.';
            
            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'message' => $errorMessage,
                    'status' => 'error'
                ], 422);
            }

            return back()->withErrors(['email' => $errorMessage]);
        }

        $actualEmail = $user->email;
        
        $status = Password::sendResetLink(['email' => $actualEmail]);


        if ($status === Password::RESET_LINK_SENT) {
            
            $successMessage = 'Link reset password telah dikirim ke email Anda. Silakan periksa kotak masuk atau folder spam.';
            
            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'message' => $successMessage,
                    'status' => 'success'
                ], 200);
            }

            return back()->with('status', $successMessage);
        }

        $errorMessage = match($status) {
            Password::INVALID_USER => 'Email tidak ditemukan dalam sistem kami.',
            Password::INVALID_TOKEN => 'Token reset password tidak valid.',
            Password::RESET_THROTTLED => 'Terlalu banyak percobaan reset password. Silakan coba lagi dalam 1 menit.',
            default => 'Terjadi kesalahan saat mengirim email reset password. Silakan coba lagi.'
        };

        if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'message' => $errorMessage,
                'status' => 'error'
            ], 422);
        }

        return back()->withErrors(['email' => $errorMessage]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    public function showSuccessPage()
    {
        return view('auth.reset-success');
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('password.success');
        }

        return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
    }
}