@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Users</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>User Lists</h4>
        <hr>
        <div class="mb-3 d-flex justify-content-between">
            <div class="">
                @if (request('search'))
                <span class="me-2">Search By : "{{request('search')}}"</span>
                <a href="{{route('user.index')}}"><i class="bi bi-trash3"></i></a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Control</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td class="w-25">{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            @can('update',$user)
                            <a href="{{route('user.edit',$user->id)}}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-pencil"></i></a>
                            @endcan

                            <a href="{{route('user.show',$user->id)}}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-info-circle"></i></a>

                            @can('delete',$user)
                            <form action="{{route('user.destroy',$user->id)}}" class="d-inline-block" method="post"
                                id="{{'del'.$user->id}}">
                                @csrf
                                @method('delete')
                            </form>
                            <button class="btn btn-sm btn-outline-dark" onclick="confirmDelete({{$user->id}})">
                                <i class="bi bi-trash3"></i></button>
                            @endcan
                        </td>
                        <td>
                            <p class="mb-0 text-black-50">
                                <i class="bi bi-calendar"></i>
                                {{$user->created_at->format("D M Y")}}
                            </p>
                            <p class="mb-0 text-black-50">
                                <i class="bi bi-clock"></i>
                                {{$user->created_at->format("h : m A")}}
                            </p>
                        </td>
                    </tr>
                    </tr>
                    @empty
                    <td colspan="6" class="text-center">There is no related user!</td>
                    @endforelse
                    <tr></tr>
                </tbody>
            </table>
        </div>
        <div class="">
            {{$users->onEachSide(1)->links()}}
        </div>
    </div>
</div>
@endsection