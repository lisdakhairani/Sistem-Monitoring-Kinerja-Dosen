<?php

namespace App\Http\Controllers;

use App\Models\KinerjaPengajaran;
use App\Models\Semester;
use App\Models\KinerjaDosen;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KinerjaPengajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $semesterAktif = Semester::where('status', 1)->first();
        $matkuls = MataKuliah::all();

        // Cek apakah data kinerja dosen sudah ada
        $kinerjaDosenID = KinerjaDosen::where('id_dosen', $user->id)
            ->where('id_semester', $semesterAktif->id ?? null)
            ->first();

        if (!$kinerjaDosenID) {
            return redirect()
                ->route('data-kinerja.index')
                ->with('error', 'Data kinerja dosen belum dilakukan.');
        }

        $search = $request->input('search');

        $kinerjaPengajaran = KinerjaPengajaran::with(['kinerjaDosen' => function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_matkul', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->whereHas('kinerjaDosen', function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
            ->paginate(8);

        $menuKinerjaPengajaran = 'active';

        return view(
            'kinerja.users.kinerja-pengajaran.index',
            compact('kinerjaPengajaran', 'kinerjaDosenID', 'menuKinerjaPengajaran', 'matkuls', 'semesterAktif')
        );
    }

    public function show($id)
    {
        $user = Auth::user();
        $semesterAktif = Semester::where('status', 1)->first();

        // Cek apakah data kinerja dosen sudah ada
        $kinerjaDosenID = KinerjaDosen::where('id_dosen', $user->id)
            ->where('id_semester', $semesterAktif->id ?? null)
            ->first();

        if (!$kinerjaDosenID) {
            return redirect()
                ->route('data-kinerja.index')
                ->with('error', 'Data kinerja dosen belum dilakukan.');
        }

        $kinerjaPengajaran = KinerjaPengajaran::with('kinerjaDosen')
            ->where('id', $id)
            ->firstOrFail();

        // Get list of matkuls for dropdown
        $matkuls = MataKuliah::all();
        $menuKinerjaPengajaran = 'active';

        // Pastikan pengajaran ini milik dosen yang bersangkutan
        if ($kinerjaPengajaran->kinerja_dosen_id != $kinerjaDosenID->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('kinerja.users.kinerja-pengajaran.show', compact('kinerjaPengajaran', 'menuKinerjaPengajaran', 'kinerjaDosenID', 'matkuls', 'semesterAktif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'nama_matkul' => 'required|string|max:255',
            'kode_matkul' => 'required|string|max:50',
            'sks' => 'required|integer|min:1',
            'semester' => 'required|string|max:20',
            'tahun_ajaran' => 'required|string|max:20',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'bukti_path' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip|max:5120',
            'jenis_pengajaran' => 'required|in:Tim,Mandiri',
        ]);

        if ($request->hasFile('bukti_path')) {
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_pengajaran', 'public');
        }

        KinerjaPengajaran::create($validated);

        return redirect()->route('kinerja-pengajaran.index')
            ->with('success', 'Data kinerja pengajaran berhasil ditambahkan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KinerjaPengajaran $kinerjaPengajaran)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'nama_matkul' => 'required|string|max:255',
            'kode_matkul' => 'required|string|max:50',
            'sks' => 'required|integer|min:1',
            'semester' => 'required|string|max:20',
            'tahun_ajaran' => 'required|string|max:20',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:5120',
            'jenis_pengajaran' => 'required|in:Tim,Mandiri',
        ]);

        if ($request->hasFile('bukti_path')) {
            // Hapus file lama jika ada
            if ($kinerjaPengajaran->bukti_path) {
                Storage::disk('public')->delete($kinerjaPengajaran->bukti_path);
            }
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_pengajaran', 'public');
        }

        $kinerjaPengajaran->update($validated);

        return redirect()->route('kinerja-pengajaran.index')
            ->with('success', 'Data kinerja pengajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KinerjaPengajaran $kinerjaPengajaran)
    {
        // Hapus file bukti jika ada
        if ($kinerjaPengajaran->bukti_path) {
            Storage::disk('public')->delete($kinerjaPengajaran->bukti_path);
        }

        $kinerjaPengajaran->delete();

        return redirect()->route('kinerja-pengajaran.index')
            ->with('success', 'Data kinerja pengajaran berhasil dihapus');
    }
}
