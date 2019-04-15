<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return view('home');

        $posts = Post::latest()->paginate(10);
        return view('home', compact('posts'))
            ->with('i', (request()->input('page',1) -1)*10);
    }
}
