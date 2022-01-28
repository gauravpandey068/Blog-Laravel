@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mb-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/IMG_logo_%282017%29.svg"
                     class="card-img-top" alt="{{$post->title}}">
                <div class="card-body">
                    <p class="card-text"><small class="text-muted"><span>Author: {{$post->user->name}}  </span>
                            Last updated {{$post->updated_at->diffForHumans()}}</small></p>
                    <p class="card-text"><small class="text-muted">
                            Category: {{$post->category}} </small></p>
                    @if(Auth::check())
                        @if(Auth::user() == $post->user)
                            <div class="d-flex">
                                <div class="p-2"><a href="{{route('post.edit', $post->id)}}"
                                                    class="btn btn-primary">Edit</a></div>

                                <div class="p-2">
                                    <form action="{{route('post.destroy',['id'=>$post->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                    <h5 class="card-title mt-3 text-black fw-bold fs-3">{{$post->title}}</h5>
                    <p class="card-text mt-3">{!! nl2br(e($post->description)) !!}</p>

                </div>
            </div>
        </div>
    </div>
@endsection
