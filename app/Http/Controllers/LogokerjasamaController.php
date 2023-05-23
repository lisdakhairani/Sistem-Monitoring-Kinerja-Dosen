<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Logokerjasama;
use Illuminate\Support\Facades\Storage;

class LogokerjasamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logokerja = Logokerjasama::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuLogokerja = 'active';
        return view('dashboard.logokerjasama.index', compact('logokerja', 'menuLogokerja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuLogokerja = 'active';
        return view('dashboard.logokerjasama.create', compact('menuLogokerja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|min:3',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Logokerjasama::create($validatedData);

            return redirect()->route('logokerjasama.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('logokerjasama.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuLogokerja = 'active';
        $logokerja = Logokerjasama::findOrFail($id);
        return view('dashboard.logokerjasama.show', compact('menuLogokerja', 'logokerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuLogokerja = 'active';
        $logokerja = Logokerjasama::findOrFail($id);
        return view('dashboard.logokerjasama.edit', [
            'logokerja' => $logokerja,
            'menuLogokerja' => $menuLogokerja
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|min:3',
                'image' => 'image|file|mimes:jpeg,png,jpg,max:3072',
            ]);

            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $logokerja = Logokerjasama::findOrFail($id);

            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['image'] = $request->file('image')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $logokerja->update($validatedData);

            return redirect()->route('logokerjasama.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('logokerjasama.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $logokerja = Logokerjasama::findOrFail($id);
        if ($logokerja) {
            $logokerja->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}