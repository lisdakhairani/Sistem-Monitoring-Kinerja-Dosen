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
use App\Exports\KinerjaDosenExport;
use App\Exports\KinerjaDosenFilteredExport;
use Barryvdh\DomPDF\Facade\Pdf;

class KinerjaController extends Controller
{
     public function index(Request $request)
{
    // Get filter parameters
    $dosenId = $request->input('dosen_id');
    $semesterId = $request->input('semester_id');
    $tahun = $request->input('tahun');

    // Get all dosen (non-admin)
    $dosens = User::where('is_admin', 0)->get();
    $semesters = Semester::all();

    // Base query
    $query = KinerjaDosen::with(['dosen', 'semester'])
        ->when($dosenId, function($query) use ($dosenId) {
            return $query->where('id_dosen', $dosenId);
        })
        ->when($semesterId, function($query) use ($semesterId) {
            return $query->where('id_semester', $semesterId);
        })
        ->when($tahun, function($query) use ($tahun) {
            // Add both options in case the year is stored in different places
            return $query->where(function($q) use ($tahun) {
                $q->whereYear('tanggal_pengisian', $tahun)
                  ->orWhereHas('semester', function($sq) use ($tahun) {
                      $sq->where('tahun_ajaran', 'like', '%'.$tahun.'%');
                  });
            });
        });

    // Rest of your code remains the same...
    $menunggu = (clone $query)->where('status_penilaian', 'Menunggu')
        ->orderBy('created_at', 'desc')
        ->get();

    $sedangDinilai = (clone $query)->where('status_penilaian', 'Sedang Dinilai')
        ->orderBy('created_at', 'desc')
        ->get();

    $selesai = (clone $query)->where('status_penilaian', 'Selesai')
        ->orderBy('created_at', 'desc')
        ->get();

    $menuKinerja = 'active';

    return view('kinerja.admins.kinerja.index', compact(
        'menuKinerja',
        'menunggu',
        'sedangDinilai',
        'selesai',
        'dosens',
        'semesters',
        'dosenId',
        'semesterId',
        'tahun'
    ));
}


    public function update(Request $request, KinerjaDosen $kinerja)
    {
        $validated = $request->validate([
            'status_penilaian' => 'required|in:Menunggu,Sedang Dinilai,Selesai'
        ]);

        $kinerja->update($validated);

        return redirect()->route('kinerja.index')
            ->with('success', 'Status penilaian berhasil diperbarui');
    }

    public function edit(KinerjaDosen $kinerja)
    {
        // Load all related data
        $kinerja->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        // Calculate scores
        $scores = $this->calculateScores($kinerja);
        $menuKinerja = 'active';

        return view('kinerja.admins.kinerja.edit', array_merge(
            ['kinerja' => $kinerja],
            ['menuKinerja' => $menuKinerja],
            $scores
        ));
    }

    public function show(KinerjaDosen $kinerja)
    {
        // Load all related data
        $kinerja->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        // Calculate scores
        $scores = $this->calculateScores($kinerja);
        $menuKinerja = 'active';

        return view('kinerja.admins.kinerja.show', array_merge(
            ['kinerja' => $kinerja],
            ['menuKinerja' => $menuKinerja],
            $scores
        ));
    }

    public function updateScore(Request $request, KinerjaDosen $kinerja)
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
        $kinerja->refresh()->load(['pengajaran', 'penelitian', 'pengabdian', 'penunjang']);

        // Calculate total score
        $totalScore = $this->calculateTotalScore($kinerja);

        // Update kinerja dosen
        $kinerja->update([
            'total_skor' => $totalScore,
            'status_penilaian' => 'Selesai',
            'id_validator' => Auth::id(),
            'tanggal_validasi' => now(),
        ]);

        return redirect()->route('kinerja.show', $kinerja->id)
            ->with('success', 'Skor berhasil diperbarui dan penilaian diselesaikan');
    }

    private function calculateScores(KinerjaDosen $kinerja)
    {
        // Calculate average scores for each category
        $avgPengajaran = $kinerja->pengajaran->avg('skor') ?? 0;
        $avgPenelitian = $kinerja->penelitian->avg('skor') ?? 0;
        $avgPengabdian = $kinerja->pengabdian->avg('skor') ?? 0;
        $avgPenunjang = $kinerja->penunjang->avg('skor') ?? 0;

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

    private function calculateTotalScore(KinerjaDosen $kinerja)
    {
        $avgPengajaran = $kinerja->pengajaran->avg('skor') ?? 0;
        $avgPenelitian = $kinerja->penelitian->avg('skor') ?? 0;
        $avgPengabdian = $kinerja->pengabdian->avg('skor') ?? 0;
        $avgPenunjang = $kinerja->penunjang->avg('skor') ?? 0;

        return ($avgPengajaran * 0.2) +
               ($avgPenelitian * 0.4) +
               ($avgPengabdian * 0.2) +
               ($avgPenunjang * 0.2);
    }

    public function exportExcel(KinerjaDosen $kinerja)
    {
        $kinerja->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        $scores = $this->calculateScores($kinerja);

        return Excel::download(new KinerjaDosenExport($kinerja, $scores),
            'kinerja-dosen-'.$kinerja->dosen->name.'-'.$kinerja->semester->nama_semester.'.xlsx');
    }

    public function exportPdf(KinerjaDosen $kinerja)
    {
        $kinerja->load([
            'pengajaran',
            'penelitian',
            'pengabdian',
            'penunjang',
            'dosen',
            'validator',
            'semester'
        ]);

        $scores = $this->calculateScores($kinerja);

        $pdf = Pdf::loadView('kinerja.admins.kinerja.export_pdf', [
            'kinerja' => $kinerja,
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

        return $pdf->download('kinerja-dosen-'.$kinerja->dosen->name.'-'.$kinerja->semester->nama_semester.'.pdf');
    }

    public function exportFilteredExcel(Request $request)
    {
        $dosenId = $request->input('dosen_id');
        $semesterId = $request->input('semester_id');
        $tahun = $request->input('tahun');

        // Generate nama file berdasarkan filter
        $fileName = 'kinerja-dosen-';
        $fileName .= $dosenId ? User::find($dosenId)->name.'-' : '';
        $fileName .= $semesterId ? Semester::find($semesterId)->nama_semester.'-' : '';
        $fileName .= $tahun ? $tahun.'-' : '';
        $fileName .= date('YmdHis').'.xlsx';

        return Excel::download(
            new KinerjaDosenFilteredExport($dosenId, $semesterId, $tahun),
            $fileName
        );
    }

    public function exportFilteredPdf(Request $request)
    {
        $dosenId = $request->input('dosen_id');
        $semesterId = $request->input('semester_id');
        $tahun = $request->input('tahun');

        // Get filtered data
        $kinerjaDosen = KinerjaDosen::with(['dosen', 'semester', 'pengajaran', 'penelitian', 'pengabdian', 'penunjang'])
            ->when($dosenId, function($query) use ($dosenId) {
                return $query->where('id_dosen', $dosenId);
            })
            ->when($semesterId, function($query) use ($semesterId) {
                return $query->where('id_semester', $semesterId);
            })
            ->when($tahun, function($query) use ($tahun) {
                return $query->whereYear('tanggal_pengisian', $tahun);
            })
            ->get();

        $pdf = Pdf::loadView('kinerja.admins.kinerja.export_filtered_pdf', [
            'kinerjaDosen' => $kinerjaDosen,
            'filterDosen' => $dosenId ? User::find($dosenId)->name : 'Semua Dosen',
            'filterSemester' => $semesterId ? Semester::find($semesterId)->nama_semester : 'Semua Semester',
            'filterTahun' => $tahun ? $tahun : 'Semua Tahun'
        ]);

        return $pdf->download('kinerja-dosen-filtered.pdf');
    }
}
