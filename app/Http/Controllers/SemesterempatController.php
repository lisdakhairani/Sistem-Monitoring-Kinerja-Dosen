<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Semesterempat;
use Illuminate\Support\Facades\Storage;

class SemesterempatController extends Controller
{
    //semesterempat
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semester4 = Semesterempat::latest()->paginate(10);
        $menuSemester1 = 'active';
        return view('dashboard.akademik.semester4.index', compact('menuSemester1', 'semester4'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuSemester1 = 'active';
        return view('dashboard.akademik.semester4.create', compact('menuSemester1'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'matakuliah' => 'nullable|min:1',
                'sks' => 'nullable|min:1',
                'filedata' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5072',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $semester4 = Semesterempat::create($validatedData);

            return redirect()->route('semesterempat.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('semesterempat.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuSemester1 = 'active';
        $semester4 = Semesterempat::findOrFail($id);
        return view('dashboard.akademik.semester4.show', compact('semester4', 'menuSemester1'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuSemester1 = 'active';
        $semester4 = Semesterempat::findOrFail($id);
        return view('dashboard.akademik.semester4.edit', [
            'semester4' => $semester4,
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
                'matakuliah' => 'nullable|min:1',
                'sks' => 'nullable|min:1',
                'filedata' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5072',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $semester4 = Semesterempat::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $semester4->update($validatedData);

            return redirect()->route('semesterempat.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('semesterempat.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $semester4 = Semesterempat::findOrFail($id);
        if ($semester4) {
            $semester4->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}