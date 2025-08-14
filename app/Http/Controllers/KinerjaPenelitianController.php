<?php

namespace App\Http\Controllers;

use App\Models\KinerjaPenelitian;
use App\Models\KinerjaDosen;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class KinerjaPenelitianController extends Controller
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

        $kinerjaPenelitian = KinerjaPenelitian::with(['kinerjaDosen' => function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where('judul_penelitian', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->whereHas('kinerjaDosen', function($query) use ($user) {
                $query->where('id_dosen', $user->id);
            })
            ->paginate(8);

        $menuKinerjaPenelitian = 'active';

        return view(
            'kinerja.users.kinerja-penelitian.index',
            compact('kinerjaPenelitian', 'kinerjaDosenID', 'menuKinerjaPenelitian')
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

        $kinerjaPenelitian = KinerjaPenelitian::with('kinerjaDosen')
            ->where('id', $id)
            ->firstOrFail();

        // Pastikan penelitian ini milik dosen yang bersangkutan
        if ($kinerjaPenelitian->kinerja_dosen_id != $kinerjaDosenID->id) {
            abort(403, 'Unauthorized action.');
        }

        $menuKinerjaPenelitian = 'active';

        return view('kinerja.users.kinerja-penelitian.show', compact('kinerjaPenelitian', 'menuKinerjaPenelitian', 'kinerjaDosenID'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required',
            'judul_penelitian' => 'required|string|max:255',
            'jenis_penelitian' => 'required|in:Tim,Mandiri',
            'peran_penelitian' => 'required|in:Ketua,Anggota',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric|min:0',
            'tahun_penelitian' => 'required|digits:4',
            'status_penelitian' => 'required|in:Sedang Berjalan,Selesai',
            'output_luaran' => 'required|string|max:255',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bentuk_penelitian' => 'required|in:Buku,Monograf,Jurnal Internasional,Jurnal Nasional,Prosiding,Penelitian Non-Publikasi',
            'nomor_volume_isbn' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'jumlah_halaman' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('bukti_path')) {
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_penelitian', 'public');
        }

        KinerjaPenelitian::create($validated);

        return redirect()->route('kinerja-penelitian.index')
            ->with('success', 'Data kinerja penelitian berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KinerjaPenelitian $kinerjaPenelitian)
    {
        $validated = $request->validate([
            'kinerja_dosen_id' => 'required|exists:kinerja_dosen,id',
            'judul_penelitian' => 'required|string|max:255',
            'jenis_penelitian' => 'required|in:Tim,Mandiri',
            'peran_penelitian' => 'required|in:Ketua,Anggota',
            'sumber_dana' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric|min:0',
            'tahun_penelitian' => 'required|digits:4',
            'status_penelitian' => 'required|in:Sedang Berjalan,Selesai',
            'output_luaran' => 'required|string|max:255',
            'bukti_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bentuk_penelitian' => 'required|in:Buku,Monograf,Jurnal Internasional,Jurnal Nasional,Prosiding,Penelitian Non-Publikasi',
            'nomor_volume_isbn' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'jumlah_halaman' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('bukti_path')) {
            // Hapus file lama jika ada
            if ($kinerjaPenelitian->bukti_path) {
                Storage::disk('public')->delete($kinerjaPenelitian->bukti_path);
            }
            $validated['bukti_path'] = $request->file('bukti_path')->store('bukti_penelitian', 'public');
        }

        $kinerjaPenelitian->update($validated);

        return redirect()->route('kinerja-penelitian.index')
            ->with('success', 'Data kinerja penelitian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KinerjaPenelitian $kinerjaPenelitian)
    {
        // Hapus file bukti jika ada
        if ($kinerjaPenelitian->bukti_path) {
            Storage::disk('public')->delete($kinerjaPenelitian->bukti_path);
        }

        $kinerjaPenelitian->delete();

        return redirect()->route('kinerja-penelitian.index')
            ->with('success', 'Data kinerja penelitian berhasil dihapus');
    }
}
