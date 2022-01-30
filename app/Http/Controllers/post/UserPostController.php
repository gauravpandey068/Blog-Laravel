<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $posts = $request->user()->posts()->paginate(10);
        return view('home', [
            'posts' => $posts,
        ]);
    }
}
