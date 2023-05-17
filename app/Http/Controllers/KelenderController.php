<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Kelender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelender = Kelender::latest()->orderBy('created_at', 'desc')->paginate(5);
        $menuKelender = 'active';
        return view('dashboard.akademik.kelender.index', compact('kelender', 'menuKelender'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuKelender = 'active';
        return view('dashboard.akademik.kelender.create', compact('menuKelender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:5072',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $kelender = Kelender::create($validatedData);

            return redirect()->route('kelender.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('kelender.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuKelender = 'active';
        $kelender = Kelender::findOrFail($id);
        return view('dashboard.akademik.kelender.show', compact('kelender', 'menuKelender'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuKelender = 'active';
        $kelender = Kelender::findOrFail($id);
        return view('dashboard.akademik.kelender.edit', [
            'kelender' => $kelender,
            'menuKelender' => $menuKelender
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:5072',
                'body' => 'required|min:10',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $kelender = Kelender::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $kelender->update($validatedData);

            return redirect()->route('kelender.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('kelender.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelender = Kelender::findOrFail($id);
        if ($kelender) {
            $kelender->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
