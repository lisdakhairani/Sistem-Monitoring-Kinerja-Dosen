<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staf = Staf::latest()->paginate(10);
        $menuStaf = 'active';
        return view('dashboard.profil.staf.index', compact('menuStaf', 'staf'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuStaf = 'active';
        return view('dashboard.profil.staf.create', compact('menuStaf'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:3',
                'nip' => 'nullable|min:3',
                'jabatan' => 'nullable|min:3',
                'image' => 'nullable|image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Staf::create($validatedData);

            return redirect()->route('staf.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('staf.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuStaf = 'active';
        $staf = Staf::findOrFail($id);
        return view('dashboard.profil.staf.edit', [
            'staf' => $staf,
            'menuStaf' => $menuStaf,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:3',
                'nip' => 'nullable|min:3',
                'jabatan' => 'nullable|min:3',
                'image' => 'nullable|image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            $staf = Staf::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $staf->update($validatedData);

            return redirect()->route('staf.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('staf.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staf = Staf::findOrFail($id);
        if ($staf) {
            $staf->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
