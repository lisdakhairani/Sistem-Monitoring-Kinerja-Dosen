<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Semestersatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SemestersatuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semester1 = Semestersatu::latest()->paginate(10);
        $menuSemester1 = 'active';
        return view('dashboard.akademik.semester1.index', compact('menuSemester1', 'semester1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuSemester1 = 'active';
        return view('dashboard.akademik.semester1.create', compact('menuSemester1'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kodemk' => 'nullable|min:1',
                'matakuliah' => 'nullable|min:1',
                'sks' => 'nullable|min:1',
                'filedata' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5072',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $semester1 = Semestersatu::create($validatedData);

            return redirect()->route('semestersatu.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('semestersatu.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuSemester1 = 'active';
        $semester1 = Semestersatu::findOrFail($id);
        return view('dashboard.akademik.semester1.show', compact('semester1', 'menuSemester1'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuSemester1 = 'active';
        $semester1 = Semestersatu::findOrFail($id);
        return view('dashboard.akademik.semester1.edit', [
            'semester1' => $semester1,
            'menuSemester1' => $menuSemester1
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'kodemk' => 'nullable|min:1',
                'matakuliah' => 'nullable|min:1',
                'sks' => 'nullable|min:1',
                'filedata' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5072',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $semester1 = Semestersatu::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $semester1->update($validatedData);

            return redirect()->route('semestersatu.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('semestersatu.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $semester1 = Semestersatu::findOrFail($id);
        if ($semester1) {
            $semester1->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
