@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mb-3">
                <h5 class="card-title mt-3 text-black fw-bold fs-3">{{$post->title}}</h5>
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
                <img src="/storage/{{$post->image}}"
                     class="card-img-top" alt="{{$post->title}}">
                <div class="card-body">
                    <p class="card-text mt-3">{!! nl2br(e($post->description)) !!}</p>

                </div>
                @auth
                    <div class="card-footer bg-white mt-3 mb-3 d-flex">
                        <span
                            class="fw-bold fs-4 text-primary me-3">{{$post->likes->count() }}</span>
                        @if(!$post->likedBy(auth()->user()))
                            <form action="{{route('post.like',$post->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">Like</button>
                            </form>
                        @else
                            <form action="{{route('post.unlike',$post->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Unlike</button>
                            </form>
                        @endif
                    </div>
                @endauth
                @guest
                    <div class="card-footer bg-white mt-3 mb-3 d-flex">
                        <span
                            class="fs-4 text-primary fw-bold me-2">{{$post->likes->count() }}</span>
                        <a href="#" class="ms-2 btn btn-outline-info disabled" tabindex="-1" role="button" aria-disabled="true">Like</a>
                    </div>
                @endguest
            </div>
        </div>
@endsection
