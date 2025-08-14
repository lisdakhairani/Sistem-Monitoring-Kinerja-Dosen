<?php

namespace App\Http\Controllers;

use App\Models\KinerjaDosen;
use App\Models\KinerjaPengajaran;
use App\Models\KinerjaPenelitian;
use App\Models\KinerjaPengabdian;
use App\Models\KinerjaPenunjang;
use App\Models\User;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipDosenExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $dosenId = $request->input('dosen_id');
        $semesterId = $request->input('semester_id');
        $tahun = $request->input('tahun');

        $user = Auth::user();
        $dosens = User::where('is_admin', 0)->where('id', $user->id)->get();
        $semesters = Semester::all();

        // Query for each status
        $menunggu = KinerjaDosen::with(['dosen', 'semester'])
            ->when($dosenId, function($query) use ($dosenId) {
                return $query->where('id_dosen', $dosenId);
            })
            ->when($semesterId, function($query) use ($semesterId) {
                return $query->where('id_semester', $semesterId);
            })
            ->when($tahun, function($query) use ($tahun) {
                return $query->whereYear('tanggal_pengisian', $tahun);
            })
            ->where('status_penilaian', 'Menunggu')
            ->where('id_dosen', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $sedangDinilai = KinerjaDosen::with(['dosen', 'semester'])
            ->when($dosenId, function($query) use ($dosenId) {
                return $query->where('id_dosen', $dosenId);
            })
            ->when($semesterId, function($query) use ($semesterId) {
                return $query->where('id_semester', $semesterId);
            })
            ->when($tahun, function($query) use ($tahun) {
                return $query->whereYear('tanggal_pengisian', $tahun);
            })
            ->where('status_penilaian', 'Sedang Dinilai')
            ->where('id_dosen', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $selesai = KinerjaDosen::with(['dosen', 'semester'])
            ->when($dosenId, function($query) use ($dosenId) {
                return $query->where('id_dosen', $dosenId);
            })
            ->when($semesterId, function($query) use ($semesterId) {
                return $query->where('id_semester', $semesterId);
            })
            ->when($tahun, function($query) use ($tahun) {
                return $query->whereYear('tanggal_pengisian', $tahun);
            })
            ->where('id_dosen', $user->id)
            ->where('status_penilaian', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        $menuArsip = 'active';

        return view('kinerja.users.arsip.index', compact('menuArsip', 'menunggu', 'sedangDinilai', 'selesai', 'dosens', 'semesters'));
    }




    public function show(KinerjaDosen $arsip)
    {
        // Load all related data
        $arsip->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);
        $menuArsip = 'active';

        // Calculate scores
        $scores = $this->calculateScores($arsip);



        return view('kinerja.users.arsip.show', array_merge(
            compact('arsip', 'menuArsip'),
            $scores
        ));

    }

    public function updateScore(Request $request, KinerjaDosen $arsip)
    {
        // Validate the request
        $request->validate([
            'pengajaran.*.id' => 'required|exists:kinerja_pengajaran,id',
            'pengajaran.*.skor' => 'nullable|numeric|min:0|max:100',
            'penelitian.*.id' => 'required|exists:kinerja_penelitian,id',
            'penelitian.*.skor' => 'nullable|numeric|min:0|max:100',
            'pengabdian.*.id' => 'required|exists:kinerja_pengabdian,id',
            'pengabdian.*.skor' => 'nullable|numeric|min:0|max:100',
            'penunjang.*.id' => 'required|exists:kinerja_penunjang,id',
            'penunjang.*.skor' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update pengajaran scores
        if ($request->has('pengajaran')) {
            foreach ($request->pengajaran as $item) {
                if (isset($item['skor'])) {
                    KinerjaPengajaran::where('id', $item['id'])
                        ->update(['skor' => $item['skor']]);
                }
            }
        }

        // Update penelitian scores
        if ($request->has('penelitian')) {
            foreach ($request->penelitian as $item) {
                if (isset($item['skor'])) {
                    KinerjaPenelitian::where('id', $item['id'])
                        ->update(['skor' => $item['skor']]);
                }
            }
        }

        // Update pengabdian scores
        if ($request->has('pengabdian')) {
            foreach ($request->pengabdian as $item) {
                if (isset($item['skor'])) {
                    KinerjaPengabdian::where('id', $item['id'])
                        ->update(['skor' => $item['skor']]);
                }
            }
        }

        // Update penunjang scores
        if ($request->has('penunjang')) {
            foreach ($request->penunjang as $item) {
                if (isset($item['skor'])) {
                    KinerjaPenunjang::where('id', $item['id'])
                        ->update(['skor' => $item['skor']]);
                }
            }
        }

        // Reload the kinerja with updated relationships
        $arsip->refresh()->load(['pengajaran', 'penelitian', 'pengabdian', 'penunjang']);

        // Calculate total score
        $totalScore = $this->calculateTotalScore($arsip);

        // Update arsip dosen
        $arsip->update([
            'total_skor' => $totalScore,
            'status_penilaian' => 'Selesai',
            'id_validator' => Auth::id(),
            'tanggal_validasi' => now(),
        ]);

        return redirect()->route('kinerja.show', $arsip->id)
            ->with('success', 'Skor berhasil diperbarui dan penilaian diselesaikan');
    }

    private function calculateScores(KinerjaDosen $arsip)
    {
        // Calculate average scores for each category
        $avgPengajaran = $arsip->pengajaran->avg('skor') ?? 0;
        $avgPenelitian = $arsip->penelitian->avg('skor') ?? 0;
        $avgPengabdian = $arsip->pengabdian->avg('skor') ?? 0;
        $avgPenunjang = $arsip->penunjang->avg('skor') ?? 0;

        // Calculate weighted scores
        $weightedPengajaran = $avgPengajaran * 0.2;
        $weightedPenelitian = $avgPenelitian * 0.4;
        $weightedPengabdian = $avgPengabdian * 0.2;
        $weightedPenunjang = $avgPenunjang * 0.2;

        // Calculate total score
        $totalScore = $weightedPengajaran + $weightedPenelitian + $weightedPengabdian + $weightedPenunjang;

        return [
            'avgPengajaran' => $avgPengajaran,
            'avgPenelitian' => $avgPenelitian,
            'avgPengabdian' => $avgPengabdian,
            'avgPenunjang' => $avgPenunjang,
            'weightedPengajaran' => $weightedPengajaran,
            'weightedPenelitian' => $weightedPenelitian,
            'weightedPengabdian' => $weightedPengabdian,
            'weightedPenunjang' => $weightedPenunjang,
            'totalScore' => $totalScore,
        ];
    }

    private function calculateTotalScore(KinerjaDosen $arsip)
    {
        $avgPengajaran = $arsip->pengajaran->avg('skor') ?? 0;
        $avgPenelitian = $arsip->penelitian->avg('skor') ?? 0;
        $avgPengabdian = $arsip->pengabdian->avg('skor') ?? 0;
        $avgPenunjang = $arsip->penunjang->avg('skor') ?? 0;

        return ($avgPengajaran * 0.2) +
               ($avgPenelitian * 0.4) +
               ($avgPengabdian * 0.2) +
               ($avgPenunjang * 0.2);
    }

    public function exportExcel(KinerjaDosen $arsip)
    {
        $arsip->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        $scores = $this->calculateScores($arsip);

        return Excel::download(new ArsipDosenExport($arsip, $scores),
            'kinerja-dosen-'.$arsip->dosen->name.'-'.$arsip->semester->nama_semester.'.xlsx');
    }

    public function exportPdf(KinerjaDosen $arsip)
    {
        $arsip->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        $scores = $this->calculateScores($arsip);

        $pdf = Pdf::loadView('kinerja.users.arsip.export_pdf', [
            'arsip' => $arsip,
            'avgPengajaran' => $scores['avgPengajaran'],
            'avgPenelitian' => $scores['avgPenelitian'],
            'avgPengabdian' => $scores['avgPengabdian'],
            'avgPenunjang' => $scores['avgPenunjang'],
            'weightedPengajaran' => $scores['weightedPengajaran'],
            'weightedPenelitian' => $scores['weightedPenelitian'],
            'weightedPengabdian' => $scores['weightedPengabdian'],
            'weightedPenunjang' => $scores['weightedPenunjang'],
            'totalScore' => $scores['totalScore'],
        ]);

        return $pdf->download('kinerja-dosen-'.$arsip->dosen->name.'-'.$arsip->semester->nama_semester.'.pdf');
    }
}
