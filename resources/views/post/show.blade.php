@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
        <li class="breadcrumb-item active">Post Details</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>{{$post->title}}</h4>
        <hr>
        @isset($post->featured_image)
        <div class="mb-3 d-flex justify-content-center"><img src="{{asset('storage/'.$post->featured_image)}}"
                class="img-fluid rounded"></div>
        @endisset
        <div class="mb-3 text-center">
            <span class="badge bg-secondary"><i class="bi bi-grid"></i>
                {{$post->category->title}}</span>
            <span class="badge bg-secondary"><i class="bi bi-person"></i>
                {{$post->user->name}}</span>
            <span class="badge bg-secondary">
                <i class="bi bi-calendar"></i>
                {{$post->created_at->format("D M Y")}}
            </span>
            <span class="badge bg-secondary">
                <i class="bi bi-clock"></i>
                {{$post->created_at->format("h : m A")}}
            </span>
        </div>
        <p>{{$post->body}}</p>
        @forelse ($post->photos as $photo )
        <img src="{{asset('storage/'.$photo->name)}}" alt="" height="100">
        @empty

        @endforelse
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('post.create')}}" class="btn btn-outline-primary">New post</a>
            <a href="{{route('post.index')}}" class="btn btn-primary">All Posts</a>
        </div>
    </div>
</div>
@endsection
