@extends('master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="py-1">
                <h4 class="text-center">{{$post->title}}</h4>
                @isset($post->featured_image)
                <br>
                <div class="mb-3 d-flex justify-content-center"><img src="{{asset('storage/'.$post->featured_image)}}"
                        class="img-fluid rounded"></div>
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
                <p class="" style="white-space: pre-wrap">{{$post->body}}</p>

                @if($post->photos)
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse ($post->photos as $key=>$photo )
                        <div class="carousel-item @if($key==0)active @endif">
                            <a class="venobox" data-gall="myGallery" href="{{asset('storage/'.$photo->name)}}">
                                <img src="{{asset('storage/'.$photo->name)}}" class="d-block w-100" height="300"
                                    style="object-fit: contain">
                            </a>
                        </div>
                        @empty

                        @endforelse
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @endif

                <div class="d-flex mt-3 justify-content-end align-items-center">
                    @can('update',$post)
                    <a href="{{route('post.edit',$post->id)}}" class="btn me-2 btn-sm btn-primary">Edit</a>
                    @endcan
                    <a href="{{route('page.index')}}" class="btn btn-sm btn-primary">All Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
