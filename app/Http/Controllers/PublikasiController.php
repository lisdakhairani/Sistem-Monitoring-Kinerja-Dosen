<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publikasi = Publikasi::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuPublikasi = 'active';
        return view('dashboard.kemahasiswaan.publikasi.index', compact('menuPublikasi', 'publikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuPublikasi = 'active';
        return view('dashboard.kemahasiswaan.publikasi.create', compact('menuPublikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Publikasi::create($validatedData);

            return redirect()->route('publikasi.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('publikasi.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuPublikasi = 'active';
        $publikasi = Publikasi::findOrFail($id);
        return view('dashboard.kemahasiswaan.publikasi.show', compact('menuPublikasi', 'publikasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuPublikasi = 'active';
        $publikasi = Publikasi::findOrFail($id);
        return view('dashboard.kemahasiswaan.publikasi.edit', [
            'publikasi' => $publikasi,
            'menuPublikasi' => $menuPublikasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $publikasi = Publikasi::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $publikasi->update($validatedData);

            return redirect()->route('publikasi.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('publikasi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publikasi = Publikasi::findOrFail($id);
        if ($publikasi) {
            $publikasi->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
