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

class PostController extends Controller
{
    // public function index(Request $request)
    // {
    //     $visitor = new Visitor();
    //     $visitor->ip_address = $request->ip();
    //     $visitor->save();

    //     $visitorCount = Visitor::count();
    //     return view('home.Blog', compact('visitorCount'));
    // }

    public function index(Request $request)
    {
        // hitung pengunjung
        $visitor = new Visitor();
        $visitor->ip_address = $request->ip();
        $visitor->save();

        $visitorCount = Visitor::count();
        // ahkir
        $pakai = Pemakaian::latest()->take(5)->get();
        $dataList = Post::latest()->take(3)->get();
        $dataProduk = Produk::latest()->take(6)->get();
        return view('home.Blog', compact('pakai', 'dataList', 'dataProduk', 'visitorCount'));
    }

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
