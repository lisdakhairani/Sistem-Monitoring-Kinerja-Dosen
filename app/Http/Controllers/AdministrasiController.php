<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrasi = Administrasi::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuAdministrasi = 'active';
        return view('dashboard.menudownload.administrasi.index', compact('administrasi', 'menuAdministrasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuAdministrasi = 'active';
        return view('dashboard.menudownload.administrasi.create', compact('menuAdministrasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:5024',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Administrasi::create($validatedData);

            return redirect()->route('administrasi.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('administrasi.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuAdministrasi = 'active';
        $administrasi = Administrasi::findOrFail($id);
        return view('dashboard.menudownload.administrasi.show', compact('administrasi', 'menuAdministrasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuAdministrasi = 'active';
        $administrasi = Administrasi::findOrFail($id);
        return view('dashboard.menudownload.administrasi.edit', [
            'administrasi' => $administrasi,
            'menuAdministrasi' => $menuAdministrasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:5024',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $administrasi = Administrasi::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $administrasi->update($validatedData);

            return redirect()->route('administrasi.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('administrasi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $administrasi = Administrasi::findOrFail($id);
        if ($administrasi) {
            $administrasi->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
