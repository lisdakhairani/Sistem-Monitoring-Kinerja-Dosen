<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi manual untuk password lama
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        try {
            $validated = $request->validateWithBag('updatePassword', [
                'password' => [
                    'required',
                    Password::defaults(),
                    'confirmed',
                    'different:current_password'
                ],
                'password_confirmation' => ['required', 'same:password'],
            ], [
                'password.required' => 'Password baru harus diisi.',
                'password.confirmed' => 'Password baru dan konfirmasi password tidak sesuai.',
                'password.different' => 'Password baru harus berbeda dengan password lama.',
                'password_confirmation.required' => 'Konfirmasi password harus diisi.',
                'password_confirmation.same' => 'Konfirmasi password tidak sesuai dengan password baru.',
            ]);

            // Update password
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            // Logout & hapus session untuk keamanan
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::route('login')->with('status', 'Password berhasil diperbarui. Silakan login kembali.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator, 'updatePassword');
        }
    }
}
