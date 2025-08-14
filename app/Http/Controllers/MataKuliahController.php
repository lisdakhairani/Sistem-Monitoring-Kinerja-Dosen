<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $search = request('search');
            $matakuliahs = MataKuliah::when($search, function($query) use ($search) {
                $query->where('nama_matakuliah', 'like', '%'.$search.'%')
                      ->orWhere('kode_matakuliah', 'like', '%'.$search.'%');
            })->paginate(8);

            $menuMataKuliah = "active";

            return view('kinerja.admins.matakuliah.index', compact('matakuliahs', 'menuMataKuliah', 'search'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data mata kuliah: '.$e->getMessage());
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
                'kode_matakuliah' => 'required|string|max:10|unique:matakuliah,kode_matakuliah',
                'nama_matakuliah' => 'required|string|max:100',
                'sks' => 'required|integer|min:1',
            ], [
                'kode_matakuliah.unique' => 'Kode mata kuliah ini sudah digunakan. Silakan gunakan kode yang berbeda.',
                'kode_matakuliah.required' => 'Kode mata kuliah wajib diisi.',
                'nama_matakuliah.required' => 'Nama mata kuliah wajib diisi.',
                'sks.required' => 'Jumlah SKS wajib diisi.',
                'sks.min' => 'Jumlah SKS minimal 1.'
            ]);

            MataKuliah::create($validated);

            DB::commit();

            return redirect()->route('mata-kuliah.index')
                ->with('success', 'Mata kuliah berhasil ditambahkan.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', $e->errors()['kode_matakuliah'] ?? $e->errors()[array_key_first($e->errors())]));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan mata kuliah: '.$e->getMessage())
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
                'kode_matakuliah' => 'required|string|max:10|unique:matakuliah,kode_matakuliah,'.$id.',id',
                'nama_matakuliah' => 'required|string|max:100',
                'sks' => 'required|integer|min:1',
            ], [
                'kode_matakuliah.unique' => 'Kode mata kuliah ini sudah digunakan. Silakan gunakan kode yang berbeda.',
                'kode_matakuliah.required' => 'Kode mata kuliah wajib diisi.',
                'nama_matakuliah.required' => 'Nama mata kuliah wajib diisi.',
                'sks.required' => 'Jumlah SKS wajib diisi.',
                'sks.min' => 'Jumlah SKS minimal 1.'
            ]);

            $matakuliah = MataKuliah::findOrFail($id);
            $matakuliah->update($validated);

            DB::commit();

            return redirect()->route('mata-kuliah.index')
                ->with('success', 'Mata kuliah berhasil diperbarui.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', $e->errors()['kode_matakuliah'] ?? $e->errors()[array_key_first($e->errors())]));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui mata kuliah: '.$e->getMessage())
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
            $matakuliah = MataKuliah::findOrFail($id);
            $matakuliah->delete();

            DB::commit();

            return redirect()->route('mata-kuliah.index')
                ->with('success', 'Mata kuliah berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus mata kuliah: '.$e->getMessage());
        }
    }
}
