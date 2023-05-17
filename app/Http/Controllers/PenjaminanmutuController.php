<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Penjaminanmutu;
use Illuminate\Support\Facades\Storage;

class PenjaminanmutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjaminanmutu = Penjaminanmutu::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuPenjaminanmutu = 'active';
        return view('dashboard.menudownload.penjaminanmutu.index', compact('penjaminanmutu', 'menuPenjaminanmutu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuPenjaminanmutu = 'active';
        return view('dashboard.menudownload.penjaminanmutu.create', compact('menuPenjaminanmutu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:5024',
                'body' => 'required|min:3',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Penjaminanmutu::create($validatedData);

            return redirect()->route('penjaminanmutu.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('penjaminanmutu.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuPenjaminanmutu = 'active';
        $penjaminanmutu = Penjaminanmutu::findOrFail($id);
        return view('dashboard.menudownload.penjaminanmutu.show', compact('penjaminanmutu', 'menuPenjaminanmutu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuPenjaminanmutu = 'active';
        $penjaminanmutu = Penjaminanmutu::findOrFail($id);
        return view('dashboard.menudownload.penjaminanmutu.edit', [
            'penjaminanmutu' => $penjaminanmutu,
            'menuPenjaminanmutu' => $menuPenjaminanmutu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
                'body' => 'required|min:3',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $penjaminanmutu = Penjaminanmutu::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $penjaminanmutu->update($validatedData);

            return redirect()->route('penjaminanmutu.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('penjaminanmutu.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjaminanmutu = Penjaminanmutu::findOrFail($id);
        if ($penjaminanmutu) {
            $penjaminanmutu->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
