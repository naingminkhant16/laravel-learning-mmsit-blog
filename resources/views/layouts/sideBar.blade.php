<div class="list-group mb-3">
    <a href="{{route('home')}}" class="list-group-item list-group-item-action">Home</a>
    <a href="{{route('test')}}" class="list-group-item list-group-item-action">Test</a>
    <a href="{{route('photo.index')}}" class="list-group-item list-group-item-action">Gallary</a>
</div>

<small class="text-black-50">Managae Posts</small>
<div class="list-group mb-3">
    <a href="{{route('post.index')}}" class="list-group-item list-group-item-action">Post List</a>
    <a href="{{route('post.create')}}" class="list-group-item list-group-item-action">Create Post</a>
</div>

<small class="text-black-50">Managae Categories</small>
<div class="list-group mb-3">
    <a href="{{route('category.index')}}" class="list-group-item list-group-item-action">Category List</a>
    <a href="{{route('category.create')}}" class="list-group-item list-group-item-action">Create Category</a>
</div>

{{-- @if (Auth::user()->role === 'admin') --}}
@admin
<small class="text-black-50">Managae Users</small>
<div class="list-group mb-3">
    <a href="{{route('user.index')}}" class="list-group-item list-group-item-action">Users List</a>
    {{-- <a href="{{route('user.create')}}" class="list-group-item list-group-item-action">User Create</a> --}}
</div>
@endadmin
{{-- @endif --}}
