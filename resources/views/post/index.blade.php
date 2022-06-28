@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Posts</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>Post Lists</h4>
        <hr>
        <div class="mb-3 d-flex justify-content-between">
            <div class="">
                @if (request('search'))
                <span class="me-2">Search By : "{{request('search')}}"</span>
                <a href="{{route('post.index')}}"><i class="bi bi-trash3"></i></a>
                @endif
            </div>
            <form action="" class="w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control">
                    <button class="btn btn-secondary"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <div class="overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Owner</th>
                        <th>Control</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td class="w-25">{{$post->title}}</td>
                        <td>{{App\Models\Category::find($post->category_id)->title}}</td>
                        <td>{{App\Models\User::find($post->user_id)->name}}</td>
                        <td>
                            <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-pencil"></i></a>
                            <a href="{{route('post.show',$post->id)}}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-info-circle"></i></a>
                            <form action="{{route('post.destroy',$post->id)}}" class="d-inline-block" method="post"
                                id="{{'del'.$post->id}}">
                                @csrf
                                @method('delete')
                            </form>
                            <button class="btn btn-sm btn-outline-dark" onclick="confirmDelete({{$post->id}})">
                                <i class="bi bi-trash3"></i></button>
                        </td>
                        <td>
                            <p class="mb-0 text-black-50">
                                <i class="bi bi-calendar"></i>
                                {{$post->created_at->format("D M Y")}}
                            </p>
                            <p class="mb-0 text-black-50">
                                <i class="bi bi-clock"></i>
                                {{$post->created_at->format("h : m A")}}
                            </p>
                        </td>
                    </tr>
                    </tr>
                    @empty
                    <td colspan="6" class="text-center">There is no related post!</td>
                    @endforelse
                    <tr></tr>
                </tbody>
            </table>
        </div>
        <div class="">
            {{$posts->onEachSide(1)->links()}}
        </div>
    </div>
</div>
@endsection