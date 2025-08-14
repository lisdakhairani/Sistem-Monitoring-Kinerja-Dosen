<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunAdminController extends Controller
{
    public function index()
    {
        $admins = User::when(request('search'), function($query) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.request('search').'%')
                  ->orWhere('nip', 'like', '%'.request('search').'%')
                  ->orWhere('nidn', 'like', '%'.request('search').'%');
            });
        })
        ->where('is_admin', true)
        ->orderBy('name')
        ->paginate(8);

        $menuAdmin = 'active';

        return view('kinerja.admins.akun-admin.index', compact('admins', 'menuAdmin'));
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'email' => $this->normalizeEmail($request->email)
            ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'ends_with:@unimal.ac.id',
                    'unique:users,email'
                ],
                'nip' => 'required|string|unique:users,nip',
                'nidn' => 'nullable|string|unique:users,nidn',
                'password' => 'required|string|min:8',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'password' => Hash::make($request->password),
                'is_admin' => 1,
            ]);

            return redirect()->route('akun-admin.index')->with('success', 'Akun admin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan akun admin: '.$e->getMessage());
        }
    }

    public function update(Request $request, User $akun_admin)
    {
        try {
            $request->merge([
                'email' => $this->normalizeEmail($request->email)
            ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'ends_with:@unimal.ac.id',
                    Rule::unique('users', 'email')->ignore($akun_admin->id)
                ],
                'nip' => [
                    'required',
                    'string',
                    Rule::unique('users', 'nip')->ignore($akun_admin->id)
                ],
                'nidn' => [
                    'nullable',
                    'string',
                    Rule::unique('users', 'nidn')->ignore($akun_admin->id)
                ],
                'password' => 'nullable|string|min:8',
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'is_admin' => 1,
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $akun_admin->update($data);

            return redirect()->route('akun-admin.index')->with('success', 'Akun admin berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun admin: '.$e->getMessage());
        }
    }

    public function destroy(User $akun_admin)
    {
        try {
            $name = $akun_admin->name;
            $nip = $akun_admin->nip;
            $akun_admin->delete();
            return redirect()->route('akun-admin.index')->with('success', "Akun admin $name $nip berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus akun admin: '.$e->getMessage());
        }
    }

    /**
     * Normalize email by ensuring it ends with @unimal.ac.id
     * Removes any existing @unimal.ac.id and appends a fresh one
     */
    private function normalizeEmail($email)
    {
        $email = strtolower(trim($email));
        // Remove any existing @unimal.ac.id
        $email = preg_replace('/@unimal\.ac\.id$/', '', $email);
        // Append @unimal.ac.id
        return $email . '@unimal.ac.id';
    }
}
