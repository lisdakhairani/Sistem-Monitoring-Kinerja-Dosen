<?php

namespace App\Http\Controllers;

use App\Models\KinerjaDosen;
use App\Models\User;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKinerjaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $semesterAktif = Semester::where('status', 1)->first();

        $kinerjaDosen = KinerjaDosen::where('id_dosen', $user->id)
            ->where('id_semester', $semesterAktif->id ?? null)
            ->first();

        $menuDataKinerja = 'active';

        return view('kinerja.users.data-kinerja.index', compact('kinerjaDosen', 'menuDataKinerja', 'semesterAktif', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dosen' => 'required|exists:users,id',
            'id_semester' => 'required|exists:semesters,id',
        ]);

        $existing = KinerjaDosen::where('id_dosen', $request->id_dosen)
            ->where('id_semester', $request->id_semester)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Data kinerja untuk semester ini sudah ada');
        }

        $data = [
            'id_dosen' => $request->id_dosen,
            'id_semester' => $request->id_semester,
            'status_penilaian' => 'Menunggu',
            'tanggal_pengisian' => now(),
        ];

        KinerjaDosen::create($data);

        return redirect()->route('data-kinerja.index')
            ->with('success', 'Data kinerja dosen berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_dosen' => 'required|exists:users,id',
            'id_semester' => 'required|exists:semesters,id',
        ]);

        $kinerjaDosen = KinerjaDosen::findOrFail($id);

        $data = [
            'is_updated' => 1,
        ];

        $kinerjaDosen->update($data);

        return redirect()->route('data-kinerja.index')
            ->with('success', 'Data kinerja dosen dapat diperbarui');
    }

    public function updateStored(Request $request, string $id)
    {
        $request->validate([
            'id_dosen' => 'required|exists:users,id',
            'id_semester' => 'required|exists:semesters,id',
        ]);

        $kinerjaDosen = KinerjaDosen::findOrFail($id);

        $data = [
            'tanggal_pengisian' => now(),
            'is_updated' => 0,
        ];

        $kinerjaDosen->update($data);

        return redirect()->route('data-kinerja.index')
            ->with('success', 'Data kinerja dosen berhasil disimpan');
    }
}
