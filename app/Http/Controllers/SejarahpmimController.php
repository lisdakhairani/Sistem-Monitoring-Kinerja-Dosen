<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sejarahpmim;
use Illuminate\Http\Request;

class SejarahpmimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sejarah = Sejarahpmim::latest()->paginate(5);
        $menuSejarah = 'active';
        return view('dashboard.profil.sejarahpmim.index', compact('sejarah', 'menuSejarah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuSejarah = 'active';
        return view('dashboard.profil.sejarahpmim.create', compact('menuSejarah'));
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

            Sejarahpmim::create($validatedData);

            return redirect()->route('sejarahpmim.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('sejarahpmim.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuSejarah = 'active';
        $sejarah = Sejarahpmim::findOrFail($id);
        return view('dashboard.profil.sejarahpmim.edit', [
            'sejarah' => $sejarah,
            'menuSejarah' => $menuSejarah,
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

            $sejarah = Sejarahpmim::findOrFail($id);

            $validatedData['user_id'] = auth()->user()->id;

            $sejarah->update($validatedData);

            return redirect()->route('sejarahpmim.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('sejarahpmim.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sejarah = Sejarahpmim::findOrFail($id);
        if ($sejarah) {
            $sejarah->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
