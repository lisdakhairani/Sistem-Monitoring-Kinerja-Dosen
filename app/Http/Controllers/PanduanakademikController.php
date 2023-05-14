<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Panduanakademik;
use Illuminate\Support\Facades\Storage;

class PanduanakademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panduan = Panduanakademik::latest()->paginate(5);
        $menuPanduan = 'active';
        return view('dashboard.akademik.panduank.index', compact('menuPanduan', 'panduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuPanduan = 'active';
        return view('dashboard.akademik.panduank.create', compact('menuPanduan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Panduanakademik::create($validatedData);

            return redirect()->route('panduanakademik.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('panduanakademik.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuPanduan = 'active';
        $panduan = Panduanakademik::findOrFail($id);
        return view('dashboard.akademik.panduank.show', compact('panduan', 'menuPanduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuPanduan = 'active';
        $panduan = Panduanakademik::findOrFail($id);
        return view('dashboard.akademik.panduank.edit', [
            'panduan' => $panduan,
            'menuPanduan' => $menuPanduan
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
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $panduan = Panduanakademik::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $panduan->update($validatedData);

            return redirect()->route('panduanakademik.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('panduanakademik.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $panduan = Panduanakademik::findOrFail($id);
        if ($panduan) {
            $panduan->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
