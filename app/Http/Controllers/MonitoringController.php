<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\JabatanAkademik;
use App\Models\Pangkat;
use App\Models\Semester;
use App\Models\KinerjaDosen;
use App\Models\KinerjaPenelitian;
use App\Models\KinerjaPengabdian;
use App\Models\KinerjaPengajaran;
use App\Models\KinerjaPenunjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class MonitoringController extends Controller
{
    public function index()
    {
        $Bannerawal = 'active';
        $dosenCount = User::where('is_admin', 0)->count();

        return view('auth.bagianawal', compact('Bannerawal', 'dosenCount'));
    }

     public function dashboardUser()
        {
        $menuDashbordUser = 'active';
        $user = Auth::user();

        // Academic statistics
        $matkulCount = MataKuliah::count();
        $pangkatCount = Pangkat::count();
        $jabatanCount = JabatanAkademik::count();

        // Performance statistics (filtered by logged-in dosen)
        $penelitianCount = KinerjaPenelitian::whereHas('kinerjaDosen', function ($query) use ($user) {
            $query->where('id_dosen', $user->id);
        })->count();

        $pengabdianCount = KinerjaPengabdian::whereHas('kinerjaDosen', function ($query) use ($user) {
            $query->where('id_dosen', $user->id);
        })->count();

        $pengajaranCount = KinerjaPengajaran::whereHas('kinerjaDosen', function ($query) use ($user) {
            $query->where('id_dosen', $user->id);
        })->count();

        $penunjangCount = KinerjaPenunjang::whereHas('kinerjaDosen', function ($query) use ($user) {
            $query->where('id_dosen', $user->id);
        })->count();

        // Chart data
        $kinerjaDosen = KinerjaDosen::with('dosen')
            ->orderBy('total_skor', 'desc')
            ->where('id_dosen', $user->id)
            ->take(10)
            ->get();

        $chartLabels = $kinerjaDosen->pluck('dosen.name')->toArray();
        $chartData = $kinerjaDosen->pluck('total_skor')->toArray();

        // Radar chart data (average scores)
        $radarData = [
            round(KinerjaPengajaran::whereHas('kinerjaDosen', function($query) use ($user) {
                        $query->where('id_dosen', $user->id);
                    })->avg('skor') ?? 0, 2),
            
            round(KinerjaPenelitian::whereHas('kinerjaDosen', function($query) use ($user) {
                        $query->where('id_dosen', $user->id);
                    })->avg('skor') ?? 0, 2),
            
            round(KinerjaPengabdian::whereHas('kinerjaDosen', function($query) use ($user) {
                        $query->where('id_dosen', $user->id);
                    })->avg('skor') ?? 0, 2),
            
            round(KinerjaPenunjang::whereHas('kinerjaDosen', function($query) use ($user) {
                        $query->where('id_dosen', $user->id);
                    })->avg('skor') ?? 0, 2)
        ];

        // Filter options
        $dosens = User::where('is_admin', 0)->where('id', $user->id)->get();
        $semesters = Semester::all();

        // Get distinct years from kinerja_dosen
        $years = KinerjaDosen::selectRaw('YEAR(tanggal_pengisian) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard-user', compact(
            'menuDashbordUser',
            'matkulCount',
            'pangkatCount',
            'jabatanCount',
            'penelitianCount',
            'pengabdianCount',
            'pengajaranCount',
            'penunjangCount',
            'chartLabels',
            'chartData',
            'radarData',
            'dosens',
            'semesters',
            'years'
        ));
    }

    public function dashboardAdmin()
    {
        $menuDashbordAdmin = 'active';

        // User statistics
        $totalUsers = User::count();
        $adminCount = User::where('is_admin', 1)->count();
        $dosenCount = User::where('is_admin', 0)->count();

        // Academic statistics
        $matkulCount = MataKuliah::count();
        $pangkatCount = Pangkat::count();
        $jabatanCount = JabatanAkademik::count();

        // Performance statistics
        $penelitianCount = KinerjaPenelitian::count();
        $pengabdianCount = KinerjaPengabdian::count();
        $pengajaranCount = KinerjaPengajaran::count();
        $penunjangCount = KinerjaPenunjang::count();

        // Chart data
        $kinerjaDosen = KinerjaDosen::with('dosen')
            ->orderBy('total_skor', 'desc')
            ->take(10)
            ->get();

        $chartLabels = $kinerjaDosen->pluck('dosen.name')->toArray();
        $chartData = $kinerjaDosen->pluck('total_skor')->toArray();

        // Radar chart data (average scores)
        $radarData = [
            round(KinerjaPengajaran::avg('skor') ?? 0, 2),
            round(KinerjaPenelitian::avg('skor') ?? 0, 2),
            round(KinerjaPengabdian::avg('skor') ?? 0, 2),
            round(KinerjaPenunjang::avg('skor') ?? 0, 2)
        ];

        // Filter options
        $dosens = User::where('is_admin', 0)->get();
        $semesters = Semester::all();

        // Get distinct years from kinerja_dosen
        $years = KinerjaDosen::selectRaw('YEAR(tanggal_pengisian) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dahsboard-admins', compact(
            'menuDashbordAdmin',
            'totalUsers',
            'adminCount',
            'dosenCount',
            'matkulCount',
            'pangkatCount',
            'jabatanCount',
            'penelitianCount',
            'pengabdianCount',
            'pengajaranCount',
            'penunjangCount',
            'chartLabels',
            'chartData',
            'radarData',
            'dosens',
            'semesters',
            'years'
        ));
    }

    public function filterDashboardData(Request $request)
    {
        try {
            $query = KinerjaDosen::with(['dosen', 'pengajaran', 'penelitian', 'pengabdian', 'penunjang']);

            // Apply filters
            if ($request->has('dosen_id') && $request->dosen_id != '') {
                $query->where('id_dosen', $request->dosen_id);
            }

            if ($request->has('semester_id') && $request->semester_id != '') {
                $query->where('id_semester', $request->semester_id);
            }

            if ($request->has('tahun') && $request->tahun != '') {
                $query->whereYear('tanggal_pengisian', $request->tahun);
            }

            // Get filtered data
            $kinerjaData = $query->orderBy('total_skor', 'desc')->get();

            // Prepare chart data
            $chartLabels = [];
            $chartData = [];

            foreach ($kinerjaData as $kinerja) {
                if ($kinerja->dosen) { // Only include if dosen exists
                    $chartLabels[] = $kinerja->dosen->name;
                    $chartData[] = $kinerja->total_skor;
                }
            }

            // Calculate radar data
            $pengajaran = $kinerjaData->flatMap(function($item) {
                return $item->pengajaran;
            });
            $penelitian = $kinerjaData->flatMap(function($item) {
                return $item->penelitian;
            });
            $pengabdian = $kinerjaData->flatMap(function($item) {
                return $item->pengabdian;
            });
            $penunjang = $kinerjaData->flatMap(function($item) {
                return $item->penunjang;
            });

            $radarData = [
                $pengajaran->isNotEmpty() ? round($pengajaran->avg('skor'), 2) : 0,
                $penelitian->isNotEmpty() ? round($penelitian->avg('skor'), 2) : 0,
                $pengabdian->isNotEmpty() ? round($pengabdian->avg('skor'), 2) : 0,
                $penunjang->isNotEmpty() ? round($penunjang->avg('skor'), 2) : 0
            ];

            return response()->json([
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'radarData' => $radarData,
                'status' => 'success'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
