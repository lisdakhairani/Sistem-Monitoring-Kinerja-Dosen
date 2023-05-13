<?php

namespace App\Http\Controllers;

use App\Models\Sejarahpmim;
use Illuminate\Http\Request;

class UserSejarahpmimController extends Controller
{
    public function index()
    {
        $sejarah = Sejarahpmim::all();
        return view('home.profil.sejarah', compact('sejarah'));
    }
}
