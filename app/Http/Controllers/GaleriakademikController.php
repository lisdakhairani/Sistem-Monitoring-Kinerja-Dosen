<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Galeriakademik;
use Illuminate\Support\Facades\Storage;

class GaleriakademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeriakademik = Galeriakademik::latest()->orderBy('created_at', 'desc')->paginate(5);
        $menugaleriakademik = 'active';
        return view('dashboard.akademik.galeri.index', compact('menugaleriakademik', 'galeriakademik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menugaleriakademik = 'active';
        return view('dashboard.akademik.galeri.create', compact('menugaleriakademik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Galeriakademik::create($validatedData);

            return redirect()->route('galeriakademik.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('galeriakademik.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menugaleriakademik = 'active';
        $galeriakademik = Galeriakademik::findOrFail($id);
        return view('dashboard.akademik.galeri.show', compact('galeriakademik', 'menugaleriakademik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menugaleriakademik = 'active';
        $galeriakademik = Galeriakademik::findOrFail($id);
        return view('dashboard.akademik.galeri.edit', [
            'galeriakademik' => $galeriakademik,
            'menugaleriakademik' => $menugaleriakademik,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3024',
            ]);

            $galeriakademik = Galeriakademik::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $galeriakademik->update($validatedData);

            return redirect()->route('galeriakademik.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('galeriakademik.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeriakademik = Galeriakademik::findOrFail($id);
        if ($galeriakademik) {
            $galeriakademik->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
