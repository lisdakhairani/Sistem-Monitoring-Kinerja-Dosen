<?php

namespace App\Http\Controllers;

use App\Models\CategorisPublikasi;
use App\Models\PublikasiNasional;
use Exception;
use Illuminate\Http\Request;

class PublikasiNasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */    
    public function index(Request $request)
    {
        $category_id = $request->input('category');
        $query = PublikasiNasional::where('user_id', auth()->user()->id);

        if (!empty($category_id)) {            
            $query->where('category_id', $category_id);
        }

        $lembaga = $query->orderBy('created_at', 'desc')->paginate(10);
        $gorilembagaMenu = 'active';
        $categories = CategorisPublikasi::all();

        return view('dashboard.kemahasiswaan.publikasi-nasional.index', compact('gorilembagaMenu', 'lembaga', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gorilembagaMenu = 'active';
        $categories = CategorisPublikasi::all();
        return view('dashboard.kemahasiswaan.publikasi-nasional.create', compact('gorilembagaMenu', 'categories'));
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

            PublikasiNasional::create($validatedData);

            return redirect()->route('publikasi-nasional.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('publikasi-nasional.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $gorilembagaMenu = 'active';
        $lembaga = PublikasiNasional::with('category')->findOrFail($id);
        return view('dashboard.kemahasiswaan.publikasi-nasional.edit', [
            'lembaga' => $lembaga,
            'gorilembagaMenu' => $gorilembagaMenu,
            'categories' => CategorisPublikasi::all()
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

            $lembaga = PublikasiNasional::findOrFail($id);

            $validatedData['user_id'] = auth()->user()->id;

            $lembaga->update($validatedData);

            return redirect()->route('publikasi-nasional.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('publikasi-nasional.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lembaga = PublikasiNasional::findOrFail($id);
        if ($lembaga) {
            $lembaga->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
