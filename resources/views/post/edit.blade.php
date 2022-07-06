@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
        <li class="breadcrumb-item active">Edit Post</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>Create New Post</h4>
        <hr>
        <form action="{{route('post.update',$post->id)}}" method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('put')
        </form>
        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror " form="editForm" name="title"
                value="{{old('title',$post->title)}}" id="title">
            @error('title')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Select Category</label>
            <select class="form-select @error('category') is-invalid @enderror " name="category" id="category"
                form="editForm">
                @foreach (App\Models\Category::all() as $category)
                <option value="{{$category->id}}" @if($category->id == old('category',$post->category_id)) selected
                    @endif >
                    {{$category->title}}
                </option>
                @endforeach
            </select>
            @error('category')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <div class="mb-1">
                {{-- //show photos --}}
                @forelse ($post->photos as $photo )
                <div class="d-inline-block mb-1 position-relative">
                    <img src="{{asset('storage/'.$photo->name)}}" alt="" height="100">
                    {{-- delete photo form --}}
                    <form action="{{route('photo.destroy',$photo->id)}}"
                        class="d-inline-block position-absolute top-0 start-0" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-trash3"></i></button>
                    </form>
                </div>
                @empty

                @endforelse
            </div>
            <div class="">
                <label for="photos" class="form-label">Post Photos</label>
                <input type="file"
                    class="form-control @error('photos') is-invalid @enderror  @error('photos.*') is-invalid @enderror"
                    name="photos[]" form="editForm" multiple id="photos">
                @error('photos')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                @error('photos.*')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Post Body</label>
            <textarea type="text" class="form-control @error('body') is-invalid @enderror " rows="10" name="body"
                form="editForm" id="body">{{old('body',$post->body)}}</textarea>
            @error('body')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-between align-items-end">
            <div class="d-flex align-items-end">
                @isset($post->featured_image)
                {{-- <div class=""> --}}
                    <img src="{{asset('storage/'.$post->featured_image)}}" class="rounded me-2" height="100">
                    {{--
                </div> --}}
                @endisset
                <div class="">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror "
                        form="editForm" name="featured_image" id="featured_image">
                    @error('featured_image')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class=""><button class="btn btn-primary btn-lg" form="editForm" type="submit">Update</button></div>
        </div>


    </div>
</div>
@endsection
