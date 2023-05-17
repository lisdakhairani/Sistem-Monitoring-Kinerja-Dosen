<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tracerstudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TracerstudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tracer = Tracerstudy::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuTracer = 'active';
        return view('dashboard.kemahasiswaan.tracer.index', compact('menuTracer', 'tracer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuTracer = 'active';
        return view('dashboard.kemahasiswaan.tracer.create', compact('menuTracer'));
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

            Tracerstudy::create($validatedData);

            return redirect()->route('tracerstudy.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('tracerstudy.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuTracer = 'active';
        $tracer = Tracerstudy::findOrFail($id);
        return view('dashboard.kemahasiswaan.tracer.show', compact('menuTracer', 'tracer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuTracer = 'active';
        $tracer = Tracerstudy::findOrFail($id);
        return view('dashboard.kemahasiswaan.tracer.edit', [
            'tracer' => $tracer,
            'menuTracer' => $menuTracer
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

            $tracer = Tracerstudy::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $tracer->update($validatedData);

            return redirect()->route('tracerstudy.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('tracerstudy.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tracer = Tracerstudy::findOrFail($id);
        if ($tracer) {
            $tracer->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
