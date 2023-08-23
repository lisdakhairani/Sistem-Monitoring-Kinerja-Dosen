<?php

namespace App\Http\Controllers;

use App\Models\CategoriInternasional;
use App\Models\PublikasiInternasional;
use Exception;
use Illuminate\Http\Request;

class PublikasiInternasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */    
    public function index(Request $request)
    {
        $category_id = $request->input('category');
        $query = PublikasiInternasional::where('user_id', auth()->user()->id);

        if (!empty($category_id)) {            
            $query->where('category_id', $category_id);
        }

        $lembaga = $query->orderBy('created_at', 'desc')->paginate(10);
        $MenuInternasional = 'active';
        $categories = CategoriInternasional::all();

        return view('dashboard.kemahasiswaan.publikasi-internasional.index', compact('MenuInternasional', 'lembaga', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MenuInternasional = 'active';
        $categories = CategoriInternasional::all();
        return view('dashboard.kemahasiswaan.publikasi-internasional.create', compact('MenuInternasional', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'category_id' => 'required',
                'program_studi' => 'nullable|min:5',
                'nama' => 'nullable|min:1',
                'kategori' => 'nullable|min:2',
                'nama_jurnal' => 'nullable|min:1',
                'nama_judul' => 'nullable|min:1',
                'link_jurnal' => 'nullable|min:1',
            ]);

            $validatedData['user_id'] = auth()->user()->id;

            PublikasiInternasional::create($validatedData);

            return redirect()->route('publikasiinternasional.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('publikasiinternasional.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $MenuInternasional = 'active';
        $lembaga = PublikasiInternasional::with('category')->findOrFail($id);
        return view('dashboard.kemahasiswaan.publikasi-internasional.edit', [
            'lembaga' => $lembaga,
            'MenuInternasional' => $MenuInternasional,
            'categories' => CategoriInternasional::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'category_id' => 'required',
                'program_studi' => 'nullable|min:5',
                'nama' => 'nullable|min:1',
                'kategori' => 'nullable|min:2',
                'nama_jurnal' => 'nullable|min:1',
                'nama_judul' => 'nullable|min:1',
                'link_jurnal' => 'nullable|min:1',
            ]);

            $lembaga = PublikasiInternasional::findOrFail($id);

            $validatedData['user_id'] = auth()->user()->id;

            $lembaga->update($validatedData);

            return redirect()->route('publikasiinternasional.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('publikasiinternasional.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lembaga = PublikasiInternasional::findOrFail($id);
        if ($lembaga) {
            $lembaga->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
