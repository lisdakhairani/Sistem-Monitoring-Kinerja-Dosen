<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Organis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organis = Organis::all();
        $menuOrganis = 'active';
        return view('dashboard.profil.organis.index', compact('menuOrganis', 'organis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuOrganis = 'active';
        return view('dashboard.profil.organis.create', compact('menuOrganis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|min:5',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Organis::create($validatedData);

            return redirect()->route('organis.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('organis.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuOrganis = 'active';
        $organis = Organis::findOrFail($id);
        return view('dashboard.profil.organis.edit', [
            'organis' => $organis,
            'menuOrganis' => $menuOrganis,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|min:5',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            $organis = Organis::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $organis->update($validatedData);

            return redirect()->route('organis.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('organis.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organis = Organis::findOrFail($id);
        if ($organis) {
            $organis->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}