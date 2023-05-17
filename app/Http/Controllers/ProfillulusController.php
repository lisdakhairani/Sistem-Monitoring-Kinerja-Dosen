<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Profillulusan;

class ProfillulusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profillulus = Profillulusan::latest()->orderBy('created_at', 'desc')->paginate(5);
        $menuProfillulus = 'active';
        return view('dashboard.profil.profillulus.index', compact('profillulus', 'menuProfillulus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuProfillulus = 'active';
        return view('dashboard.profil.profillulus.create', compact('menuProfillulus'));
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

            Profillulusan::create($validatedData);

            return redirect()->route('profillulus.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('profillulus.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuProfillulus = 'active';
        $profillulus = Profillulusan::findOrFail($id);
        return view('dashboard.profil.profillulus.edit', [
            'profillulus' => $profillulus,
            'menuProfillulus' => $menuProfillulus,
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

            $profillulus = Profillulusan::findOrFail($id);

            $validatedData['user_id'] = auth()->user()->id;

            $profillulus->update($validatedData);

            return redirect()->route('profillulus.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('profillulus.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profillulus = Profillulusan::findOrFail($id);
        if ($profillulus) {
            $profillulus->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
