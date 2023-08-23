<?php

namespace App\Http\Controllers;

use App\Models\Organis;
use App\Models\VisiMisi;
use App\Models\Akreditas;
use App\Models\CategoriInternasional;
use App\Models\CategorisPublikasi;
use App\Models\Kerjasama;
use App\Models\Sejarahpmim;
use Illuminate\Http\Request;
use App\Models\Profillulusan;
use App\Models\PublikasiInternasional;
use App\Models\PublikasiNasional;
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

    public function publikasinasional(Request $request) {        
        $keyword = $request->input('keyword');

        $lembaga = PublikasiNasional::query();
        $categories = CategorisPublikasi::all();
        $category_id = $request->input('category');

        if (!empty($category_id)) {
            $lembaga->where('category_id', $category_id);
        }

        $lembaga = $lembaga->orderBy('created_at', 'asc')
            ->where('nama', 'LIKE', '%' . $keyword . '%')
            ->paginate(20);
        return view('home.kemahasiswaan.publikasi', compact('lembaga', 'categories'));        
    }
    public function internasional(Request $request) {        
        $keyword = $request->input('keyword');

        $lembaga = PublikasiInternasional::query();
        $categories = CategoriInternasional::all();
        $category_id = $request->input('category');

        if (!empty($category_id)) {
            $lembaga->where('category_id', $category_id);
        }

        $lembaga = $lembaga->orderBy('created_at', 'asc')
            ->where('nama', 'LIKE', '%' . $keyword . '%')
            ->paginate(20);
        return view('home.kemahasiswaan.publikasi-inter', compact('lembaga', 'categories'));        
    }
    
}
