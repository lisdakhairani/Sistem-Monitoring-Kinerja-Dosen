<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Downloadakademik;
use Illuminate\Support\Facades\Storage;

class DownloadakademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downloadk = Downloadakademik::latest()->orderBy('created_at', 'desc')->paginate(10);
        $menuDownloadk = 'active';
        return view('dashboard.akademik.downloadk.index', compact('menuDownloadk', 'downloadk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuDownloadk = 'active';
        return view('dashboard.akademik.downloadk.create', compact('menuDownloadk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'filedata' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
                'body' => 'required|min:3',
            ]);

            if ($request->file('filedata')) {
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            Downloadakademik::create($validatedData);

            return redirect()->route('downloadakademik.index')->with(['success' => 'Berhasil dibuat']);
        } catch (Exception $e) {
            return redirect()->route('downloadakademik.index')->with(['failed' => 'Ada kesalahan sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $menuDownloadk = 'active';
        $downloadk = Downloadakademik::findOrFail($id);
        return view('dashboard.akademik.downloadk.show', compact('downloadk', 'menuDownloadk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menuDownloadk = 'active';
        $downloadk = Downloadakademik::findOrFail($id);
        return view('dashboard.akademik.downloadk.edit', [
            'downloadk' => $downloadk,
            'menuDownloadk' => $menuDownloadk
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

            $downloadk = Downloadakademik::findOrFail($id);

            if ($request->file('filedata')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['filedata'] = $request->file('filedata')->store('images');
            }

            $validatedData['user_id'] = auth()->user()->id;

            $downloadk->update($validatedData);

            return redirect()->route('downloadakademik.index')->with(['success' => 'Update successfully']);
        } catch (Exception $e) {
            return redirect()->route('downloadakademik.index')->with(['failed' => 'Ada kesalahan system. error :' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $downloadk = Downloadakademik::findOrFail($id);
        if ($downloadk) {
            $downloadk->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);
        } else {
            return redirect()->back()->with(['failed' => 'Ada kesalahan system']);
        }
    }
}
