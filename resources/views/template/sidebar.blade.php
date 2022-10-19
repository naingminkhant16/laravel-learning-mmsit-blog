<div class="mb-4">
    <h3 class="">Post Search</h3>
    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control">
            <button class="btn btn-primary">
                Search
            </button>
        </div>
    </form>
    @isset($category)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p>Filter By : {{ $category->title }}</p>
        <a href="{{ route('page.index') }}" class="btn  btn-outline-primary">See All</a>
    </div>
    @endisset
</div>
<div class="mb-4">
    <h3>Category List</h3>
    <div class="list-group">
        <a href="{{route('page.index')}}" class="list-group-item list-group-item-action {{request()->url()==route('page.index')?
            'active':''}}">All Categories</a>
        @foreach($categories as $category)
        <a class="list-group-item list-group-item-action
        {{request()->url()==route('page.category',$category->slug)?
        'active':''}}" href="{{ route('page.category',$category->slug) }}">
            {{ $category->title }}
        </a>
        @endforeach
    </div>
</div>
