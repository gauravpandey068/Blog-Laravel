@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="row">
                    @if($posts->count())
                        @foreach($posts as $post)
                            <div class="card m-2" style="width: 18rem;">
                                <a href="{{route('post.show', $post->id)}}" class="text-decoration-none text-black">
                                <img src="/storage/{{$post->image}}" class="card-img-top mt-1" height="150" width="150" alt="{{$post->title}}">
                                <div class="card-body">
                                    <h5 class="card-title text-black fw-bold">{{$post->title}}</h5>
                                    <p class="card-text">Author: {{$post->user->name}}</p>
                                </div>
                                <div class="card-footer bg-white border-white">
                                    <small class="text-muted">Created at {{$post->created_at->diffForHumans() }}</small>
                                </div>
                                </a>
                            </div>
                        @endforeach
                            <div class="mt-5 mb-5">
                                {{$posts->links()}}
                            </div>
                    @else
                        <div class="card-body m-5">
                            <p class="text-center text-primary fs-2">No Posts Found!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
