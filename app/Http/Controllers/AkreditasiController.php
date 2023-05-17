<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Akreditasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkreditasiController extends Controller
{
    //akreditasi
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akreditasi = Akreditasi::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuAkreditasi = 'active';
        return view('dashboard.menudownload.akreditasi.index', compact('akreditasi', 'menuAkreditasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuAkreditasi = 'active';
        return view('dashboard.menudownload.akreditasi.create', compact('menuAkreditasi'));
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

            Akreditasi::create($validatedData);

            return redirect()->route('akreditasi.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('akreditasi.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuAkreditasi = 'active';
        $akreditasi = Akreditasi::findOrFail($id);
        return view('dashboard.menudownload.akreditasi.show', compact('akreditasi', 'menuAkreditasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuAkreditasi = 'active';
        $akreditasi = Akreditasi::findOrFail($id);
        return view('dashboard.menudownload.akreditasi.edit', [
            'akreditasi' => $akreditasi,
            'menuAkreditasi' => $menuAkreditasi
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

            $akreditasi = Akreditasi::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $akreditasi->update($validatedData);

            return redirect()->route('akreditasi.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('akreditasi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $akreditasi = Akreditasi::findOrFail($id);
        if ($akreditasi) {
            $akreditasi->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
