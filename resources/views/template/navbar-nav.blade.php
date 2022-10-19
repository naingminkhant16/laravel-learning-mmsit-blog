<ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-pills">
    <li class="nav-item">
        <x-nav-link name='Home' :url="route('page.index')" />
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
        </a>
        <ul class="dropdown-menu">
            @foreach(\App\Models\Category::all() as $category)
            <li>
                <a class="dropdown-item" href="{{ route('page.category',$category->slug) }}">
                    {{ $category->title }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>

    @auth
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
    @else
    <li class="nav-item">
        <x-nav-link name='Login' :url="route('login')" />
    </li>
    <li class="nav-item">
        <x-nav-link name='Register' :url="route('register')" />
    </li>
    @endauth

</ul>
