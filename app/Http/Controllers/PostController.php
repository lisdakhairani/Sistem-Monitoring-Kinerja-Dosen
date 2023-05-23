<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Models\Produk;
use App\Models\Visitor;
use App\Models\Category;
use App\Models\Pemakaian;
use Illuminate\Http\Request;
use App\Models\Logokerjasama;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Hitung pengunjung
        $visitor = Visitor::create([
            'ip_address' => $request->ip()
        ]);
        $visitorCount = Visitor::count();

        // // Hitung pengunjung
        // $visitorCount = Cache::rememberForever('visitor_count', function () {
        //     Visitor::create([
        //         'ip_address' => request()->ip()
        //     ]);
        //     return Visitor::query()->count();
        // });

        // // Menyertakan tag no-cache pada respons
        // header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Pragma: no-cache');
        // header('Expires: 0');

        $pakai = Pemakaian::latest()->limit(5)->get();
        $dataList = Post::latest()->limit(3)->get();
        $dataProduk = Produk::latest()->limit(6)->get();
        $logo = Logokerjasama::all();

        return view('home.Blog', compact('pakai', 'dataList', 'dataProduk', 'visitorCount', 'logo'));
    }



    // public function index(Request $request)
    // {
    //     // hitung pengunjung
    //     $visitor = new Visitor();
    //     $visitor->ip_address = $request->ip();
    //     $visitor->save();

    //     $visitorCount = Visitor::count();
    //     // ahkir
    //     $pakai = Pemakaian::latest()->take(5)->get();
    //     $dataList = Post::latest()->take(3)->get();
    //     $dataProduk = Produk::latest()->take(6)->get();
    //     return view('home.Blog', compact('pakai', 'dataList', 'dataProduk', 'visitorCount'));
    // }

    // public function show($name)
    // {
    //     try {
    //         $post = Post::where('name', $name)->firstOrFail();
    //         return view('home.SingleBlog', compact('post'));
    //     } catch (Exception $e) {
    //         return view('home.notfound');
    //     }
    // }


    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            $silderpost = Post::latest()->take(6)->get();
            return view('home.SigleBlog', compact('post', 'silderpost'));
        } catch (Exception $e) {
            return view('home.notfound');
        }
    }

    public function blogpost()
    {
        $menuBlog = 'active';
        $dataitem = Post::latest()->paginate(6);
        return view('home.home-blog', compact('dataitem', 'menuBlog'));
    }
}