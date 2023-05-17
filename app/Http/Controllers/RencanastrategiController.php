<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Rencanastrategi;
use Illuminate\Support\Facades\Storage;

class RencanastrategiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rencana = Rencanastrategi::latest()->orderBy('created_at', 'desc')->paginate(5);
        $menuRencana = 'active';
        return view('dashboard.profil.rencanastrategi.index', compact('menuRencana', 'rencana'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuRencana = 'active';
        return view('dashboard.profil.rencanastrategi.create', compact('menuRencana'));
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

            $rencana = Rencanastrategi::create($validatedData);

            return redirect()->route('rencanastrategi.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('rencanastrategi.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuRencana = 'active';
        $rencana = Rencanastrategi::findOrFail($id);
        return view('dashboard.profil.rencanastrategi.show', compact('rencana', 'menuRencana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuRencana = 'active';
        $rencana = Rencanastrategi::findOrFail($id);
        return view('dashboard.profil.rencanastrategi.edit', [
            'rencana' => $rencana,
            'menuRencana' => $menuRencana
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

            $rencana = Rencanastrategi::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $rencana->update($validatedData);

            return redirect()->route('rencanastrategi.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('rencanastrategi.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rencana = Rencanastrategi::findOrFail($id);
        if ($rencana) {
            $rencana->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
