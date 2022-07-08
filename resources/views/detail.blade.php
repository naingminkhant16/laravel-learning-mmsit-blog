@extends('master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4>{{$post->title}}</h4>
                    <hr>
                    @isset($post->featured_image)
                    <div class="mb-3 d-flex justify-content-center"><img
                            src="{{asset('storage/'.$post->featured_image)}}" class="img-fluid rounded"></div>
                    @endisset
                    <div class="mb-3 text-center">
                        <a href="{{route('page.category',$post->category->slug)}}" class="text-decoration-none">
                            <span class="badge bg-secondary"><i class="bi bi-grid"></i>
                                {{$post->category->title}}</span>
                        </a>
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
                    <div class="text-center">
                        @forelse ($post->photos as $photo )
                        <img src="{{asset('storage/'.$photo->name)}}" class="mb-1 rounded" alt="" height="100">
                        @empty
                    </div>

                    @endforelse
                    <hr>
                    <div class="d-flex justify-content-end align-items-center">
                        {{-- <a href="{{route('post.create')}}" class="btn btn-outline-primary">New post</a> --}}
                        <a href="{{route('page.index')}}" class="btn btn-primary">All Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
