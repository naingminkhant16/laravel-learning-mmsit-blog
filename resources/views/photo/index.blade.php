@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4>This is {{Auth::user()->name}}'s Gallary</h4>
        {{-- {{Auth::user()->photos}} --}}
        <br>
        <div class="gallery">
            @forelse (Auth::user()->photos as $photo)
            <img src="{{asset('storage/'.$photo->name)}}" alt="" class="mb-3 w-100 rounded">
            @empty

            <p class=" text-center">No Photo Yet</p>
            @endforelse

            {{-- @php
            $user= App\Models\User::where('id',11)->first();
            dd($user->posts()->where('id',251)->get()[0]->photos);
            @endphp --}}
        </div>
    </div>
</div>
@endsection
