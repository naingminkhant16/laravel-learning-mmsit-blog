@extends('master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <h1 class="text-center mb-3">Blog Posts</h1>
            <div class="mb-3">
                <form action="">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="{{request('search')}}">
                        <button class="btn btn-secondary">Search</button>
                    </div>
                </form>
            </div>
            @isset($category)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="mb-0">Filter By - {{$category->title}}</p>
                <a href="{{route('page.index')}}" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></a>
            </div>
            @endisset
            @forelse ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">{{$post->title}}</h3>
                    <hr>
                    <div class="mb-3">
                        <a href="{{route('page.category',$post->category->slug)}}"><span
                                class="badge bg-secondary">{{$post->category->title}}</span></a>
                    </div>
                    <p class="card-text">{{Str::words($post->body,70)}}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-black-50">
                            <p class="mb-0">{{$post->user->name}}</p>
                            <small class="mb-0">{{$post->created_at->diffForHumans()}}</small>
                        </div>
                        <div class="">
                            <a href="{{route('page.detail',$post->slug)}}" class="btn btn-primary">See More</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card">
                <h4 class="text-center">There is no posts yet!</h4>
            </div>
            @endforelse
            <div class="">
                {{$posts->onEachSide(1)->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
