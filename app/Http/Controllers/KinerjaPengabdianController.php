<?php

namespace App\Http\Controllers;

use App\Models\KinerjaPengabdian;
use App\Models\Semester;
use App\Models\KinerjaDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class KinerjaPengabdianController extends Controller
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

        $kinerjaPengabdian = KinerjaPengabdian::with(['kinerjaDosen' => function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where('judul_kegiatan', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->whereHas('kinerjaDosen', function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
            ->paginate(8);

        $menuKinerjaPengabdian = 'active';

        return view(
            'kinerja.users.kinerja-pengabdian.index',
            compact('kinerjaPengabdian', 'kinerjaDosenID', 'menuKinerjaPengabdian')
        );
    }

     /**
     * Display the specified resource.
     */
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

        $kinerjaPengabdian = KinerjaPengabdian::with('kinerjaDosen')
            ->where('id', $id)
            ->firstOrFail();

        // Pastikan pengabdian ini milik dosen yang bersangkutan
        if ($kinerjaPengabdian->kinerja_dosen_id != $kinerjaDosenID->id) {
            abort(403, 'Unauthorized action.');
        }

        $menuKinerjaPengabdian = 'active';

        return view('kinerja.users.kinerja-pengabdian.show', compact('kinerjaPengabdian', 'menuKinerjaPengabdian', 'kinerjaDosenID'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'judul_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'peran_pengabdian' => 'required|in:Ketua,Anggota',
            'lokasi' => 'required|string|max:255',
            'tahun_kegiatan' => 'required|digits:4',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric|min:0',
            'output' => 'required|string',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'tingkat_kegiatan' => 'required|in:Lokal,Nasional,Internasional',
            'bidang_keahlian' => 'required|string|max:255',
        ]);

        if ($request->hasFile('bukti_path')) {
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_pengabdian', 'public');
        }

        KinerjaPengabdian::create($validated);

        return redirect()->route('kinerja-pengabdian.index')
            ->with('success', 'Data kinerja pengabdian berhasil ditambahkan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KinerjaPengabdian $kinerjaPengabdian)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'judul_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'peran_pengabdian' => 'required|in:Ketua,Anggota',
            'lokasi' => 'required|string|max:255',
            'tahun_kegiatan' => 'required|digits:4',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric|min:0',
            'output' => 'required|string',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'tingkat_kegiatan' => 'required|in:Lokal,Nasional,Internasional',
            'bidang_keahlian' => 'required|string|max:255',
        ]);

        if ($request->hasFile('bukti_path')) {
            // Hapus file lama jika ada
            if ($kinerjaPengabdian->bukti_path) {
                Storage::disk('public')->delete($kinerjaPengabdian->bukti_path);
            }
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_pengabdian', 'public');
        }

        $kinerjaPengabdian->update($validated);

        return redirect()->route('kinerja-pengabdian.index')
            ->with('success', 'Data kinerja pengabdian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KinerjaPengabdian $kinerjaPengabdian)
    {
        // Hapus file bukti jika ada
        if ($kinerjaPengabdian->bukti_path) {
            Storage::disk('public')->delete($kinerjaPengabdian->bukti_path);
        }

        $kinerjaPengabdian->delete();

        return redirect()->route('kinerja-pengabdian.index')
            ->with('success', 'Data kinerja pengabdian berhasil dihapus');
    }
}
