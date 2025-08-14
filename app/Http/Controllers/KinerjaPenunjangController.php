<?php

namespace App\Http\Controllers;

use App\Models\KinerjaPenunjang;
use App\Models\Semester;
use App\Models\KinerjaDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KinerjaPenunjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

        $search = $request->input('search');

        $kinerjaPenunjang = KinerjaPenunjang::with(['kinerjaDosen' => function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_kegiatan', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->whereHas('kinerjaDosen', function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
            ->paginate(8);


        $menuKinerjaPenunjang = 'active';

        return view(
            'kinerja.users.kinerja-penunjang.index',
            compact('kinerjaPenunjang', 'kinerjaDosenID', 'menuKinerjaPenunjang')
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

        $kinerjaPenunjang = KinerjaPenunjang::with('kinerjaDosen')
            ->where('id', $id)
            ->firstOrFail();

        // Pastikan penunjang ini milik dosen yang bersangkutan
        if ($kinerjaPenunjang->kinerja_dosen_id != $kinerjaDosenID->id) {
            abort(403, 'Unauthorized action.');
        }

        $menuKinerjaPenunjang = 'active';

        return view('kinerja.users.kinerja-penunjang.show', compact('kinerjaPenunjang', 'menuKinerjaPenunjang', 'kinerjaDosenID'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'jenis_kegiatan' => 'required|in:Reviewer Jurnal,Narasumber / Moderator,Panitia Kegiatan Ilmiah,Pembicara Seminar,Anggota Organisasi Profesi,Sertifikasi Kompetensi',
            'nama_kegiatan' => 'required|string|max:255',
            'tingkat_kegiatan' => 'required|in:Lokal,Nasional,Internasional',
            'tanggal_kegiatan' => 'required|date',
            'institusi_penyelenggara' => 'required|string|max:255',
            'bukti_path' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',

        ]);

        if ($request->hasFile('bukti_path')) {
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_penunjang', 'public');
        }

        KinerjaPenunjang::create($validated);

        return redirect()->route('kinerja-penunjang.index')
            ->with('success', 'Data kinerja penunjang berhasil ditambahkan');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KinerjaPenunjang $kinerjaPenunjang)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'jenis_kegiatan' => 'required|in:Reviewer Jurnal,Narasumber / Moderator,Panitia Kegiatan Ilmiah,Pembicara Seminar,Anggota Organisasi Profesi,Sertifikasi Kompetensi',
            'nama_kegiatan' => 'required|string|max:255',
            'tingkat_kegiatan' => 'required|in:Lokal,Nasional,Internasional',
            'tanggal_kegiatan' => 'required|date',
            'institusi_penyelenggara' => 'required|string|max:255',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',

        ]);

        if ($request->hasFile('bukti_path')) {
            // Hapus file lama jika ada
            if ($kinerjaPenunjang->bukti_path) {
                Storage::disk('public')->delete($kinerjaPenunjang->bukti_path);
            }
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_penunjang', 'public');
        }

        $kinerjaPenunjang->update($validated);

        return redirect()->route('kinerja-penunjang.index')
            ->with('success', 'Data kinerja penunjang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KinerjaPenunjang $kinerjaPenunjang)
    {
        // Hapus file bukti jika ada
        if ($kinerjaPenunjang->bukti_path) {
            Storage::disk('public')->delete($kinerjaPenunjang->bukti_path);
        }

        $kinerjaPenunjang->delete();

        return redirect()->route('kinerja-penunjang.index')
            ->with('success', 'Data kinerja penunjang berhasil dihapus');
    }
}
