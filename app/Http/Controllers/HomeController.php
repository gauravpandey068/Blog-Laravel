<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application post.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('home', ['posts' => $posts]);
    }

    public function search(Request $requets){
        $search= $requets->search;
        $posts = Post::query()
            ->where('title', 'like', '%'.$search.'%')
            ->orWhere('category', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('home', ['posts' => $posts]);
    }

}
