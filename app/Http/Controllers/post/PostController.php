<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
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
            'image'=> 'required|mimes:jpeg,png,jpg,svg|max:8048'
        ]);

        //change image name
        $image_name = time().now() . '-' . $request->title . '.' . $request->image->extension();

        $imagePath = $request->image->store('uploads', 'public');

        //save the data
        auth()->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imagePath,
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
        //authorize
        if(!Gate::allows('authorization', $post)){
            abort(403, 'Unauthorized action');
        }

        return view('post.edit', ['post' => $post]);
    }
    public function update(Request $request, $id){

        //find the post
        $post = Post::find($id);
        //authorize
        if(!Gate::allows('authorization', $post)){
            abort(403, 'Unauthorized action');
        }
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
        //authorize
        if(!Gate::allows('authorization', $post)){
            abort(403, 'Unauthorized action');
        }
        //delete the post
        $post->delete();
        //redirect
        return redirect()->route('home');
    }
}
