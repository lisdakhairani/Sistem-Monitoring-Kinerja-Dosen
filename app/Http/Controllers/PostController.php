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

        $pakai = Pemakaian::latest()->limit(5)->get();
        $dataList = Post::latest()->limit(3)->get();
        $dataProduk = Produk::latest()->limit(6)->get();
        $logo = Logokerjasama::all();

        return view('home.Blog', compact('pakai', 'dataList', 'dataProduk', 'visitorCount', 'logo'));
    }


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

    public function blogpost(Request $request)
    {
        $menuBlog = 'active';
        $keyword = $request->input('keyword');

        $dataitem = Post::latest()
            ->where('title', 'LIKE', '%' . $keyword . '%')
            ->orWhere('body', 'LIKE', '%' . $keyword . '%')
            ->paginate(6);

        return view('home.home-blog', compact('dataitem', 'menuBlog'));
    }


    // public function blogpost()
    // {
    //     $menuBlog = 'active';
    //     $dataitem = Post::latest()->paginate(6);
    //     return view('home.home-blog', compact('dataitem', 'menuBlog'));
    // }
}
