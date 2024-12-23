<header class="header">
    <div class="inner-header">
        <div class="logo">
            <a href="{{ route('welcome') }}">Your Logo</a>
        </div>
        <nav>
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest

            @auth
                <a href="{{ route('profile') }}">Profile</a>
                <a href="{{ route('settings') }}">Settings</a>
                @if(auth()->user() && auth()->user()->hasRole('admin'))
                    <a href="/admin">Admin Panel</a>
                @endif

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            @endauth
        </nav>
    </div>
</header>
