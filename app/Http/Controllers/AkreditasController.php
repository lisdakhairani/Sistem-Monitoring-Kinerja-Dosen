<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Akreditas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkreditasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akreditas = Akreditas::all();
        $menuAkreditas = 'active';
        return view('dashboard.profil.akreditas.index', compact('menuAkreditas', 'akreditas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuAkreditas = 'active';
        return view('dashboard.profil.akreditas.create', compact('menuAkreditas'));
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

            Akreditas::create($validatedData);

            return redirect()->route('akreditas.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('akreditas.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuAkreditas = 'active';
        $akreditas = Akreditas::findOrFail($id);
        return view('dashboard.profil.akreditas.edit', [
            'akreditas' => $akreditas,
            'menuAkreditas' => $menuAkreditas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            $akreditas = Akreditas::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $akreditas->update($validatedData);

            return redirect()->route('akreditas.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('akreditas.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $akreditas = Akreditas::findOrFail($id);
        if ($akreditas) {
            $akreditas->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
