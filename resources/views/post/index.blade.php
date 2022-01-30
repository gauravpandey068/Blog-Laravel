@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center bg-white fs-3">
                        Add New Post
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <div class="mb-3">
                                            {{$error}}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('post')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control"
                                       placeholder="Title" name="title" required value="{{old('title')}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" required name="image">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Body</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Body"
                                          rows="10" name="description" required>{{old('description')}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tag</label>
                                <input type="text" class="form-control"
                                       placeholder="Tag" name="category" value="{{old('category')}}" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
