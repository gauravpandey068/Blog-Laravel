<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use App\Models\Comment;
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
            'image' => 'required|mimes:jpeg,png,jpg,svg|max:8048'
        ]);


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
        $comments = $post->comment()->orderBy('created_at', 'desc')->paginate(10);
        return view('post.post', ['post' => $post, 'comments' => $comments]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        //authorize
        if (!Gate::allows('authorizationPost', $post)) {
            abort(403, 'Unauthorized action');
        }

        return view('post.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {

        //find the post
        $post = Post::find($id);
        //authorize
        if (!Gate::allows('authorizationPost', $post)) {
            abort(403, 'Unauthorized action');
        }
        //validate the data
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required|max:20',
            'image' => 'mimes:jpeg,png,jpg,svg|max:8048'
        ]);
        if($request->image){
            $imagePath = $request->image->store('uploads', 'public');
        }else{
            $imagePath = $post->image;
        }
        //update the data
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;
        $post->image = $imagePath;
        $post->save();
        //redirect
        return redirect()->route('post.show', ['id' => $post->id]);
    }

    public function destroy($id)
    {
        //find the post
        $post = Post::find($id);
        //authorize
        if (!Gate::allows('authorizationPost', $post)) {
            abort(403, 'Unauthorized action');
        }
        //delete the post
        $post->delete();
        //redirect
        return redirect()->route('home');
    }
}
