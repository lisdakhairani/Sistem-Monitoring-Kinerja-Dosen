<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    // public function recordVisitor(Request $request)
    // {
    //     // Merekam data pengunjung
    //     $pengunjung = new Pengunjung();
    //     $pengunjung->tanggal = now()->toDateString();
    //     $pengunjung->ip_address = $request->ip();
    //     $pengunjung->user_agent = $request->header('User-Agent');
    //     $pengunjung->save();

    //     // Menghitung total pengunjung
    //     $visitorCount = Pengunjung::count();

    //     // Lanjutkan dengan tindakan lain yang diinginkan setelah merekam pengunjung

    //     return response()->json(['count' => $visitorCount]);
    // }

    // test
    public function recordVisitor(Request $request)
    {
        // Merekam data pengunjung
        $pengunjung = new Pengunjung();
        $pengunjung->tanggal = now()->toDateString();
        $pengunjung->ip_address = $request->ip();
        $pengunjung->user_agent = $request->header('User-Agent');
        $pengunjung->save();

        // Menghitung total pengunjung
        $visitorCount = Pengunjung::count();

        // Lanjutkan dengan tindakan lain yang diinginkan setelah merekam pengunjung

        return response()->json(['count' => $visitorCount]);
    }
}
