@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
        <li class="breadcrumb-item active">Create Post</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>Create New Post</h4>
        <hr>
        <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror " name="title"
                    value="{{old('title')}}" id="title">
                @error('title')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Select Category</label>
                <select class="form-select @error('category') is-invalid @enderror " name="category" id="category">
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{$category->id}}" @if($category->id == old('category')) selected @endif >
                        {{$category->title}}
                    </option>
                    @endforeach
                </select>
                @error('category')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Post Body</label>
                <textarea type="text" class="form-control @error('body') is-invalid @enderror " rows="10" name="body"
                    id="body">{{old('body')}}</textarea>
                @error('body')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror "
                        name="featured_image" id="featured_image">
                    @error('featured_image')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class=""><button class="btn btn-primary" type="submit">Upload</button></div>
            </div>
        </form>
    </div>
</div>
@endsection