<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'comment' => 'required|min:4|max:1000',
        ]);
        $post->comment()->create([
            'comments' => $request->comment,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Post $post, Comment $comment)
    {
        //authorize
        if (!Gate::allows('authorizationComment', $comment)) {
            abort(403, 'Unauthorized action');
        }

        $this->validate($request, [
            'comment' => 'required|min:5|max:1000',
        ]);
        $comment->comments = $request->comment;
        $comment->save();
        return redirect()->back();
    }

    public function destroy(Request $request, Post $post, Comment $comment)
    {
        // authorize
        if (!Gate::allows('authorizationComment', $comment)) {
            abort(403, 'Unauthorized action');
        }
        $post->comment()->where('id', $comment->id)->delete();
        return redirect()->back();
    }

}
