<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        if($post->likedBy($request->user())){
            return redirect()->back();
        }
        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);
        return redirect()->back();
    }
    public function unlike(Request $request, Post $post)
    {
        $post->likes()->where('user_id', $request->user()->id)->delete();
        return redirect()->back();
    }
}
