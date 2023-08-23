<?php

namespace App\Http\Controllers;

use App\Models\CategoriInternasional;
use Exception;
use Illuminate\Http\Request;

class CategoriInternasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goriinter = CategoriInternasional::where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        $MenuInternasional = 'active';
        return view('dashboard.kemahasiswaan.categories-internasional.index', compact('goriinter', 'MenuInternasional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MenuInternasional = 'active';
        return view('dashboard.kemahasiswaan.categories-internasional.form_add', compact('MenuInternasional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required',                
            ]);            

            $validatedData['user_id'] = auth()->user()->id;
            CategoriInternasional::create($validatedData);

            return redirect()->route('categoriinternasional.index')->with(['success' => 'berhasil diupdate']);
        } catch (Exception $e) {
            return redirect()->route('categoriinternasional.index')->with(['failed' => 'Ada kesalahan system']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $MenuInternasional = 'active';
        $goriinter = CategoriInternasional::findOrFail($id);        
        return view('dashboard.kemahasiswaan.categories-internasional.index', compact('goriinter', 'MenuInternasional'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $MenuInternasional = 'active';
        $goriinter = CategoriInternasional::findOrFail($id);
        return view('dashboard.kemahasiswaan.categories-internasional.form_edit', compact('goriinter', 'MenuInternasional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required', 
            ]);
            $goriinter = CategoriInternasional::findOrFail($id);        
            $validatedData['user_id'] = auth()->user()->id;            
            $goriinter->update($validatedData);

            return redirect()->route('categoriinternasional.index')->with(['success' => 'berhasil diupdate']);
        } catch (Exception $e) {
            return redirect()->route('categoriinternasional.index')->with(['failed' => 'gagal diupdate. error: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $goriinter = CategoriInternasional::findOrFail($id);
        if ($goriinter) {
            $goriinter->delete();
            return redirect()->back()->with(['success' => ' berhasil dihapus']);
        } else {
            return redirect()->back()->with(['failed' => 'User not found']);
        }
    }
}
