@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card mb-3">
                <h5 class="card-title mt-3 text-black fw-bold fs-3">{{$post->title}}</h5>
                <p class="card-text"><small class="text-muted"><span>Author: {{$post->user->name}}  </span>
                        Last updated {{$post->updated_at->diffForHumans()}}</small></p>
                <p class="card-text"><small class="text-muted">
                        Tag: {{$post->category}} </small></p>
                @if(Auth::check())
                    @if(Auth::user() == $post->user)
                        <div class="d-flex">
                            <div class="p-2"><a href="{{route('post.edit', $post->id)}}"
                                                class="btn btn-primary">Edit</a></div>

                            <div class="p-2">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Delete {{$post->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this Post?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    No
                                                </button>
                                                <form action="{{route('post.destroy',['id'=>$post->id])}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        <a href="#" class="ms-2 btn btn-outline-info disabled" tabindex="-1" role="button"
                           aria-disabled="true">Like</a>
                    </div>
                @endguest
            </div>
            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="card-title text-black fw-bold fs-3">{{$post->comment->count()}} {{Str::plural('Comment', $post->comment->count())}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-title">Leave Your Comments</p>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <div class="mb-3">
                                        {{$error}}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('post.comment.store', $post->id)}}" method="post">
                        @csrf
                        <div class="form-floating">
                            <textarea class="form-control" name="comment" placeholder="Leave a comment here"
                                      id="floatingTextarea" rows="5" required></textarea>
                            <label for="floatingTextarea">Comments</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Comment</button>
                    </form>
                    <hr>
                    @foreach($post->comment as $comment)
                        <div class="card-body">
                            <div class="card-text">
                                <h5 class="card-title">
                                    <span class="fw-bold">{{$comment->user->name}}</span>
                                    <span class="text-muted">{{$comment->updated_at->diffForHumans()}}</span>
                                    @auth
                                        @if(auth()->user()->id == $comment->user_id)
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                    </svg>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal1" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                    Comment</h5>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{route('post.comment.update', [$post->id, $comment->id])}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control" name="comment"
                                                                                  id="floatingTextarea" rows="4"
                                                                                  required>{{$comment->comments}}</textarea>
                                                                        <label for="floatingTextarea">Comments</label>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancel
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Save
                                                                            changes
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-outline-danger ms-2" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-trash"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal2" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                    Comment</h5>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Comment?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">No
                                                                </button>
                                                                <form
                                                                    action="{{route('post.comment.destroy',[$post->id, $comment->id])}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-outline-danger ms-2">Yes
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </h5>
                                <p class="card-text">{!! nl2br(e($comment->comments)) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
