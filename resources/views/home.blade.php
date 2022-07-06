@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        This is home //
        {{-- @isAdmin('editor')
        he is admin
        @endisAdmin --}}
        {{Auth::user()->isAdmin()?"yes" :'no';}}
    </div>
</div>
@endsection