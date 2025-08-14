<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunDosenController extends Controller
{
    public function index()
    {
        $dosens = User::when(request('search'), function($query) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.request('search').'%')
                  ->orWhere('nip', 'like', '%'.request('search').'%')
                  ->orWhere('nidn', 'like', '%'.request('search').'%');
            });
        })
        ->where('is_admin', false)
        ->orderBy('name')
        ->paginate(8);

        $menuDosen = 'active';

        return view('kinerja.admins.akun-dosen.index', compact('dosens', 'menuDosen'));
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
                'is_admin' => 0,
            ]);

            return redirect()->route('akun-dosen.index')->with('success', 'Akun dosen berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan akun dosen: '.$e->getMessage());
        }
    }

    public function update(Request $request, User $akun_dosen)
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
                    Rule::unique('users', 'email')->ignore($akun_dosen->id)
                ],
                'nip' => [
                    'required',
                    'string',
                    Rule::unique('users', 'nip')->ignore($akun_dosen->id)
                ],
                'nidn' => [
                    'nullable',
                    'string',
                    Rule::unique('users', 'nidn')->ignore($akun_dosen->id)
                ],
                'password' => 'nullable|string|min:8',
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'is_admin' => 0,
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $akun_dosen->update($data);

            return redirect()->route('akun-dosen.index')->with('success', 'Akun dosen berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun dosen: '.$e->getMessage());
        }
    }

    public function destroy(User $akun_dosen)
    {
        try {
            $name = $akun_dosen->name;
            $nip = $akun_dosen->nip;
            $akun_dosen->delete();
            return redirect()->route('akun-dosen.index')->with('success', "Akun dosen $name $nip berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus akun dosen: '.$e->getMessage());
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
