<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function index()
    {
        return view('post.index');
    }
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required|max:20',
        ]);
        //save the data
        auth()->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
        ]);
        //redirect
        return redirect()->route('home');
    }
    public function show($id)
    {
        $post = Post::find($id);
        return view('post.post', ['post' => $post]);
    }
    public function edit($id)
    {
        $post = Post::find($id);
        return view('post.edit', ['post' => $post]);
    }
    public function update(Request $request, $id){
        //find the post
        $post = Post::find($id);
        //validate the data
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required|max:20',
        ]);
        //update the data
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;
        $post->save();
        //redirect
        return redirect()->route('post.show', ['id' => $post->id]);
    }
    public function destroy($id){
        //find the post
        $post = Post::find($id);
        //delete the post
        $post->delete();
        //redirect
        return redirect()->route('home');
    }
}
