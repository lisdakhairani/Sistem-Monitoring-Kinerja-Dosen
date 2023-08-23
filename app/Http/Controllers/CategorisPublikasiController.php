<?php

namespace App\Http\Controllers;

use App\Models\CategorisPublikasi;
use Exception;
use Illuminate\Http\Request;

class CategorisPublikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goripublik = CategorisPublikasi::where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        $gorilembagaMenu = 'active';
        return view('dashboard.kemahasiswaan.categories-publikasi.index', compact('goripublik', 'gorilembagaMenu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gorilembagaMenu = 'active';
        return view('dashboard.kemahasiswaan.categories-publikasi.form_add', compact('gorilembagaMenu'));
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
            CategorisPublikasi::create($validatedData);

            return redirect()->route('categoripublik.index')->with(['success' => 'berhasil diupdate']);
        } catch (Exception $e) {
            return redirect()->route('categoripublik.index')->with(['failed' => 'Ada kesalahan system']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gorilembagaMenu = 'active';
        $goripublik = CategorisPublikasi::findOrFail($id);        
        return view('dashboard.kemahasiswaan.categories-publikasi.index', compact('goripublik', 'gorilembagaMenu'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gorilembagaMenu = 'active';
        $goripublik = CategorisPublikasi::findOrFail($id);
        return view('dashboard.kemahasiswaan.categories-publikasi.form_edit', compact('goripublik', 'gorilembagaMenu'));
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
            $goripublik = CategorisPublikasi::findOrFail($id);        
            $validatedData['user_id'] = auth()->user()->id;            
            $goripublik->update($validatedData);

            return redirect()->route('categoripublik.index')->with(['success' => 'berhasil diupdate']);
        } catch (Exception $e) {
            return redirect()->route('categoripublik.index')->with(['failed' => 'gagal diupdate. error: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $goripublik = CategorisPublikasi::findOrFail($id);
        if ($goripublik) {
            $goripublik->delete();
            return redirect()->back()->with(['success' => ' berhasil dihapus']);
        } else {
            return redirect()->back()->with(['failed' => 'User not found']);
        }
    }
}
