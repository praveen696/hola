<header>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Hola!</a></li>
            @if(!Auth::check())
                <li class="float-right"><a href="{{ route('signin') }}">Login</a></li>
            @else
                <li class="float-right"><a href="{{ route('logout') }}">Logout</a></li>
            @endif
        </ul>
    </nav>
</header>