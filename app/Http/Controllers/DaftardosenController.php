<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Daftardosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftardosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftardosen = Daftardosen::latest()->paginate(10);
        $menuDosen = 'active';
        return view('dashboard.profil.daftardosen.index', compact('daftardosen', 'menuDosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuDosen = 'active';
        return view('dashboard.profil.daftardosen.create', compact('menuDosen'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:3',
                'nip' => 'nullable|min:3',
                'jabatan' => 'nullable|min:3',
                'sinta' => 'nullable|min:3',
                'scopus' => 'nullable|min:3',
                'scholar' => 'nullable|min:3',
                'image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:3072',

            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Daftardosen::create($validatedData);

            return redirect()->route('daftardosen.index')->with(['success' => 'created successfully']);
        } catch (Exception $e) {
            return redirect()->route('daftardosen.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
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
        $menuDosen = 'active';
        $daftardosen = Daftardosen::findOrFail($id);
        return view('dashboard.profil.daftardosen.edit', [
            'daftardosen' => $daftardosen,
            'menuDosen' => $menuDosen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|min:3',
                'nip' => 'nullable|min:3',
                'jabatan' => 'nullable|min:3',
                'sinta' => 'nullable|min:3',
                'scopus' => 'nullable|min:3',
                'scholar' => 'nullable|min:3',
                'image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:3072',

            ]);

            $daftardosen = Daftardosen::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $daftardosen->update($validatedData);

            return redirect()->route('daftardosen.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('daftardosen.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daftardosen = Daftardosen::findOrFail($id);
        if ($daftardosen) {
            $daftardosen->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
