<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($links as $name=> $link)
        @if($loop->last)
        <li class="breadcrumb-item active" aria-current="page">{{ucwords($name)}}</li>
        @else
        <li class="breadcrumb-item"><a href="{{ $link }}">{{ucwords($name)}}</a></li>
        @endif
        @endforeach
    </ol>
</nav>
