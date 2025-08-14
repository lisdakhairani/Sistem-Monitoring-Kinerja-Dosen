<?php

namespace App\Http\Controllers;

use App\Models\JabatanAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class JabatanAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $search = request('search');
            $jabatanAkademiks = JabatanAkademik::when($search, function($query) use ($search) {
                $query->where('nama_jabatan', 'like', '%'.$search.'%');
            })->paginate(8);

            $menuJabatanAkademik = "active";

            return view('kinerja.admins.jabatan-akademik.index',
                compact('jabatanAkademiks', 'menuJabatanAkademik', 'search'));

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memuat data jabatan akademik: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama_jabatan' => 'required|string|max:50|unique:jabatan_akademik,nama_jabatan',
            ], [
                'nama_jabatan.required' => 'Nama jabatan wajib diisi',
                'nama_jabatan.max' => 'Nama jabatan maksimal 50 karakter',
                'nama_jabatan.unique' => 'Jabatan akademik ini sudah ada'
            ]);

            JabatanAkademik::create($validated);

            DB::commit();

            return redirect()->route('jabatan-akademik.index')
                ->with('success', 'Jabatan akademik berhasil ditambahkan.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', $e->errors()['nama_jabatan'] ?? []));

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan jabatan akademik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama_jabatan' => 'required|string|max:50|unique:jabatan_akademik,nama_jabatan,'.$id,
            ], [
                'nama_jabatan.required' => 'Nama jabatan wajib diisi',
                'nama_jabatan.max' => 'Nama jabatan maksimal 50 karakter',
                'nama_jabatan.unique' => 'Jabatan akademik ini sudah ada'
            ]);

            $jabatanAkademik = JabatanAkademik::findOrFail($id);
            $jabatanAkademik->update($validated);

            DB::commit();

            return redirect()->route('jabatan-akademik.index')
                ->with('success', 'Jabatan akademik berhasil diperbarui.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', $e->errors()['nama_jabatan'] ?? []));

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui jabatan akademik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $jabatanAkademik = JabatanAkademik::findOrFail($id);
            $jabatanAkademik->delete();

            DB::commit();

            return redirect()->route('jabatan-akademik.index')
                ->with('success', 'Jabatan akademik berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus jabatan akademik: ' . $e->getMessage());
        }
    }
}
