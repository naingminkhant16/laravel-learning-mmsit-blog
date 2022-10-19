@extends('layouts.app')

@section('content')
<x-breadcrumb />
<div class="card">
    <div class="card-body">
        This is Home || {{ Auth::user()->isAuthor() ? "yes" : "no" }}
        <br>
        <div>
            {{
            QrCode::size(250)
            ->color(200,221,221)
            ->backgroundcolor(135,142,211)
            ->style('round')
            ->generate(request()->url());
            }}
        </div>
        {{App\Models\User::find(Auth::id())}}
        <br>
        {{Auth::user()}}
    </div>
</div>
@endsection
