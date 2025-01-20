<header class="header">
    <div class="inner-header">
        <div class="logo">
            <a href="{{ route('welcome') }}">
                <img src="{{asset('storage/shops.png')}}" alt="Icon">
            </a>
        </div>
        <div class="nav">
            <nav>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endguest
                    <a href="{{ route('products.index') }}">Shop</a>
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
            <div class="wishlist">
                <a href="{{ route('wishlist.index') }}">
                    <i class="fa-solid fa-heart"></i>
                    @auth
                        @php
                            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                        @endphp
                        <span class="badge">
                {{ $wishlistCount }}
            </span>
                    @endauth
                    @guest
                        <span class="badge">
                0
            </span>
                    @endguest
                </a>
            </div>

            <div class="cart">
                <a href="{{ route('cart.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @auth
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        <span class="badge">
                {{ $cartCount }}
            </span>
                    @endauth
                    @guest
                        <span class="badge">
                0
            </span>
                    @endguest
                </a>
            </div>
        </div>
    </div>
</header>
