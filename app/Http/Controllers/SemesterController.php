<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterOptions = ['Semua' => 'Semua', 'Semester Ganjil' => 'Semester Ganjil', 'Semester Genap' => 'Semester Genap'];
        $tahunOptions = ['Semua' => 'Semua'] + Semester::selectRaw('tahun_ajaran as tahun') ->distinct() ->orderByDesc('tahun') ->pluck('tahun', 'tahun') ->toArray();


        $selectedSemester = request('filter_semester', 'Semua');
        $selectedTahun = request('filter_tahun', 'Semua');

        $semesters = Semester::when($selectedSemester != 'Semua', function($query) use ($selectedSemester) {
            $query->where('nama_semester', $selectedSemester);
        })
        ->when($selectedTahun != 'Semua', function($query) use ($selectedTahun) {
            $query->where('tahun_ajaran', $selectedTahun);
        })
        ->orderBy('status', 'desc')
        ->orderBy('tahun_ajaran', 'desc')
        ->orderBy('nama_semester')
        ->paginate(8);

        $menuSemester = 'active';

        return view('kinerja.admins.semester.index', compact('semesters', 'menuSemester', 'semesterOptions', 'tahunOptions', 'selectedSemester', 'selectedTahun'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_semester' => 'required|in:Semester Ganjil,Semester Genap',
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
        ]);

        // Validate year format (e.g., 2023/2024)
        if (!preg_match('/^\d{4}\/\d{4}$/', $request->tahun_ajaran)) {
            return back()->withErrors(['tahun_ajaran' => 'Format tahun ajaran harus seperti 2023/2024.'])->withInput();
        }

        // Check if semester already exists
        $exists = Semester::where('nama_semester', $request->nama_semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->exists();

        if ($exists) {
            return back()->withErrors(['nama_semester' => 'Semester dengan tahun ajaran ini sudah ada.'])->withInput();
        }

        // Deactivate all other semesters if this one is being activated
        if ($request->status) {
            Semester::query()->update(['status' => false]);
        }

        Semester::create([
            'nama_semester' => $request->nama_semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status ?? false,
        ]);

        return redirect()->route('semester.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'nama_semester' => 'required|in:Semester Ganjil,Semester Genap',
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
        ]);

        // Validate year format (e.g., 2023/2024)
        if (!preg_match('/^\d{4}\/\d{4}$/', $request->tahun_ajaran)) {
            return back()->withErrors(['tahun_ajaran' => 'Format tahun ajaran harus seperti 2023/2024.'])->withInput();
        }

        // Check if semester already exists (excluding current one)
        $exists = Semester::where('nama_semester', $request->nama_semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('id', '!=', $semester->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['nama_semester' => 'Semester dengan tahun ajaran ini sudah ada.'])->withInput();
        }

        // Deactivate all other semesters if this one is being activated
        if ($request->status) {
            Semester::where('id', '!=', $semester->id)->update(['status' => false]);
        }

        $semester->update([
            'nama_semester' => $request->nama_semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status ?? false,
        ]);

        return redirect()->route('semester.index')->with('success', 'Semester berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        // Prevent deletion of active semester
        if ($semester->status) {
            return redirect()->route('semester.index')
                ->with('info', 'Tidak dapat menghapus semester yang aktif.');
        }

        $namaSemester = $semester->nama_semester;
        $tahunAjaran = $semester->tahun_ajaran;

        $semester->delete();

        return redirect()->route('semester.index')
            ->with('success', "Semester $namaSemester $tahunAjaran berhasil dihapus.");
    }
}
