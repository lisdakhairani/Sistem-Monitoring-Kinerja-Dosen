<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisimisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visimisi = VisiMisi::latest()->paginate(5);
        $menuVisimisi = 'active';
        return view('dashboard.profil.visimisi.index', compact('visimisi', 'menuVisimisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuVisimisi = 'active';
        return view('dashboard.profil.visimisi.create', compact('menuVisimisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'body' => 'required|min:10',
            ]);

            $validatedData['user_id'] = auth()->user()->id;

            VisiMisi::create($validatedData);

            return redirect()->route('visimisi.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('visimisi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuVisimisi = 'active';
        $visimisi = VisiMisi::findOrFail($id);
        return view('dashboard.profil.visimisi.edit', [
            'visimisi' => $visimisi,
            'menuVisimisi' => $menuVisimisi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'body' => 'required|min:10',
            ]);

            $visimisi = VisiMisi::findOrFail($id);

            $validatedData['user_id'] = auth()->user()->id;

            $visimisi->update($validatedData);

            return redirect()->route('visimisi.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('visimisi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visimisi = VisiMisi::findOrFail($id);
        if ($visimisi) {
            $visimisi->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
