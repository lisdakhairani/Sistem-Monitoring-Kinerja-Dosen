<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KerjasamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kerjasama = Kerjasama::latest()->paginate(5);
        $menuKerjasama = 'active';
        return view('dashboard.profil.kerjasama.index', compact('menuKerjasama', 'kerjasama'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuKerjasama = 'active';
        return view('dashboard.profil.kerjasama.create', compact('menuKerjasama'));
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

            Kerjasama::create($validatedData);

            return redirect()->route('kerjasama.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('kerjasama.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuKerjasama = 'active';
        $kerjasama = Kerjasama::findOrFail($id);
        return view('dashboard.profil.kerjasama.show', compact('kerjasama', 'menuKerjasama'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuKerjasama = 'active';
        $kerjasama = Kerjasama::findOrFail($id);
        return view('dashboard.profil.kerjasama.edit', [
            'kerjasama' => $kerjasama,
            'menuKerjasama' => $menuKerjasama
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

            $kerjasama = Kerjasama::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $kerjasama->update($validatedData);

            return redirect()->route('kerjasama.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('kerjasama.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kerjasama = Kerjasama::findOrFail($id);
        if ($kerjasama) {
            $kerjasama->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}