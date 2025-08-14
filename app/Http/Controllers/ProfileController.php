<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\JabatanAkademik;
use App\Models\Pangkat;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $jabatans = JabatanAkademik::all();
        $pangkats = Pangkat::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'jabatans' => $jabatans,
            'pangkats' => $pangkats,
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $user = $request->user();

            // Update regular data
            $user->fill($request->except('photos'));

            // Handle email verification if email changed
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Handle photo upload
            if ($request->hasFile('photos')) {
                try {
                    $user->updateProfilePhoto($request->file('photos'));
                } catch (\Exception $e) {
                    throw new \Exception('Gagal mengunggah gambar: ' . $e->getMessage());
                }
            }

            $user->save();

            DB::commit();

            return Redirect::route('profile.edit')
                ->with('success', 'Profil berhasil diperbarui.')
                ->with('status', 'profile-updated');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: Periksa kembali data yang Anda masukkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
