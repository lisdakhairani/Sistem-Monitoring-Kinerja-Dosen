<?php

namespace App\Http\Controllers;

use App\Models\Organis;
use App\Models\VisiMisi;
use App\Models\Akreditas;
use App\Models\Kerjasama;
use App\Models\Sejarahpmim;
use Illuminate\Http\Request;
use App\Models\Profillulusan;
use App\Models\Rencanastrategi;

class UserpageController extends Controller
{


    // Nemu Profil
    public function akreditasppimfe()
    {
        $akreditas = Akreditas::orderBy('created_at', 'desc')->get();
        return View('home.profil.akreditasi', compact('akreditas'));
    }

    public function sejarah()
    {
        $sejarah = Sejarahpmim::all();
        return View('home.profil.sejarah', compact('sejarah'));
    }

    public function visimisi()
    {
        $visimisi = VisiMisi::all();
        return View('home.profil.visi-misi', compact('visimisi'));
    }

    public function Profillulus()
    {
        $profillulus = Profillulusan::all();
        return view('home.profil.profillulusan', compact('profillulus'));
    }

    public function kerjasama()
    {
        $kerjasama = Kerjasama::orderBy('created_at', 'desc')->get();
        return view('home.profil.kerjasama', compact('kerjasama'));
    }

    public function rencana()
    {
        $rencana = Rencanastrategi::orderBy('created_at', 'desc')->get();
        return view('home.profil.rencanastrategi', compact('rencana'));
    }

    public function organnis()
    {
        $organnis = Organis::orderBy('created_at', 'desc')->get();
        return view('home.profil.trukturorgan', compact('organnis'));
    }
}
