@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>Category Lists</h4>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    {{-- @if (Auth::user()->role!=='author') --}}
                    @notAuthor
                    <th>Owner</th>
                    @endnotAuthor
                    {{-- @endif --}}
                    <th>Post Count</th>
                    <th>Control</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}
                        <br>
                        <span class="badge bg-secondary">{{$category->slug}}</span>
                    </td>
                    {{-- @if (Auth::user()->role!=='author') --}}
                    @notAuthor
                    <td>{{$category->user->name ??'unknow'}}</td>
                    @endnotAuthor
                    {{-- @endif --}}

                    <td>
                        {{$category->posts()->count()}}
                        {{-- <br>
                        //Nested Eager Loading
                        @forelse ($category->user->photos as $photo)
                        <img src="{{asset('storage/'.$photo->name)}}" alt="" class="mb-3 rounded" height="50">
                        @empty
                        <span class="badge bg-secondary">no photos</span>
                        @endforelse --}}
                    </td>
                    <td>
                        @can('update',$category)
                        <a href="{{route('category.edit',$category->id)}}" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-pencil"></i></a>
                        @endcan

                        @can('delete',$category)
                        <form action="{{route('category.destroy',$category->id)}}" class="d-inline-block" method="post"
                            id="{{'del'.$category->id}}">
                            @csrf
                            @method('delete')
                        </form>
                        <button class="btn btn-sm btn-outline-dark" onclick="confirmDelete({{$category->id}})">
                            <i class="bi bi-trash3"></i></button>
                        @endcan
                    </td>
                    <td>
                        <p class="mb-0 text-black-50">
                            <i class="bi bi-calendar"></i>
                            {{$category->created_at->format("D M Y")}}
                        </p>
                        <p class="mb-0 text-black-50">
                            <i class="bi bi-clock"></i>
                            {{$category->created_at->format("h : m A")}}
                        </p>
                    </td>
                </tr>
                </tr>
                @empty

                @endforelse
                <tr></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
