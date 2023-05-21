<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Prestasisiswa;
use Illuminate\Support\Facades\Storage;

class PrestasisiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasisiswa::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuPrestasi = 'active';
        return view('dashboard.kemahasiswaan.prestasi.index', compact('prestasi', 'menuPrestasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuPrestasi = 'active';
        return view('dashboard.kemahasiswaan.prestasi.create', compact('menuPrestasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:5',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
                'body' => 'nullable|min:10',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Prestasisiswa::create($validatedData);

            return redirect()->route('prestasisiswa.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('prestasisiswa.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuPrestasi = 'active';
        $prestasi = Prestasisiswa::findOrFail($id);
        return view('dashboard.kemahasiswaan.prestasi.show', compact('prestasi', 'menuPrestasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuPrestasi = 'active';
        $prestasi = Prestasisiswa::find($id);
        return view('dashboard.kemahasiswaan.prestasi.edit', [
            'prestasi' => $prestasi,
            'menuPrestasi' => $menuPrestasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:5',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
                'body' => 'nullable|min:10',
            ]);

            $prestasi = Prestasisiswa::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $prestasi->update($validatedData);

            return redirect()->route('prestasisiswa.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('prestasisiswa.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = Prestasisiswa::findOrFail($id);
        if ($prestasi) {
            $prestasi->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
