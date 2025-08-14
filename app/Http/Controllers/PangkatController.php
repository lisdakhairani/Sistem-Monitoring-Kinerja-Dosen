<?php

namespace App\Http\Controllers;

use App\Models\Pangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class PangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $search = request('search');
            $pangkats = Pangkat::when($search, function($query) use ($search) {
                $query->where('nama_pangkat', 'like', '%'.$search.'%')
                      ->orWhere('golongan', 'like', '%'.$search.'%');
            })->paginate(8);

            $menuPangkat = 'active';

            return view('kinerja.admins.pangkat.index',
                compact('pangkats', 'menuPangkat', 'search'));

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memuat data pangkat: ' . $e->getMessage());
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
                'nama_pangkat' => 'required|string|max:50|unique:pangkat,nama_pangkat',
                'golongan' => 'required|string|max:5',
            ], [
                'nama_pangkat.required' => 'Nama pangkat wajib diisi',
                'nama_pangkat.max' => 'Nama pangkat maksimal 50 karakter',
                'nama_pangkat.unique' => 'Pangkat ini sudah ada',
                'golongan.required' => 'Golongan wajib diisi',
                'golongan.max' => 'Golongan maksimal 5 karakter'
            ]);

            Pangkat::create($validated);

            DB::commit();

            return redirect()->route('pangkat.index')
                ->with('success', 'Pangkat berhasil ditambahkan.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', array_merge(
                    $e->errors()['nama_pangkat'] ?? [],
                    $e->errors()['golongan'] ?? []
                )));

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan pangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pangkat)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama_pangkat' => 'required|string|max:50|unique:pangkat,nama_pangkat,'.$id_pangkat.',id_pangkat',
                'golongan' => 'required|string|max:5',
            ], [
                'nama_pangkat.required' => 'Nama pangkat wajib diisi',
                'nama_pangkat.max' => 'Nama pangkat maksimal 50 karakter',
                'nama_pangkat.unique' => 'Pangkat ini sudah ada',
                'golongan.required' => 'Golongan wajib diisi',
                'golongan.max' => 'Golongan maksimal 5 karakter'
            ]);

            $pangkat = Pangkat::findOrFail($id_pangkat);
            $pangkat->update($validated);

            DB::commit();

            return redirect()->route('pangkat.index')
                ->with('success', 'Pangkat berhasil diperbarui.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal: ' . implode(' ', array_merge(
                    $e->errors()['nama_pangkat'] ?? [],
                    $e->errors()['golongan'] ?? []
                )));

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pangkat)
    {
        DB::beginTransaction();

        try {
            $pangkat = Pangkat::findOrFail($id_pangkat);
            $pangkat->delete();

            DB::commit();

            return redirect()->route('pangkat.index')
                ->with('success', 'Pangkat berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus pangkat: ' . $e->getMessage());
        }
    }
}
