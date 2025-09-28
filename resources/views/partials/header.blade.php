<header class="py-3">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <div class="dropdown"> <a href="/landing" class="link-body-emphasis text-decoration-none fw-bold">
                Garmedia
            </a>

        </div>
        <div class="d-flex align-items-center justify-content">
            <div class="dropdown me-3">
                <a href="#" class="link-body-emphasis text-decoration-none dropdown-toggle ms-2"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Bootstrap menu">
                    Category
                </a>

                <ul class="dropdown-menu text-small shadow">
                    @foreach ($genres as $genre)
                        <li><a class="dropdown-item" href="{{ route('search', ['q' => $genre->name]) }}">{{ $genre->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <form class="w-50" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="q" class="form-control" placeholder="Search Title or Author"
                    aria-label="Search" value="{{ request('q') }}">
            </form>

            <div class="d-flex align-items-center ms-auto">
                @auth
                    <a href="{{ route('wishlist') }}" class="link-body-emphasis me-3" aria-label="Wishlist">
                        <i class="bi bi-heart fs-5"></i>
                    </a>

                    <a href="{{ route('cart.index') }}" class="link-body-emphasis me-3" aria-label="Cart">
                        <i class="bi bi-cart fs-5"></i>
                    </a>

                    <div class="flex-shrink-0 dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                alt="{{ Auth::user()->name }}" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="{{ route('transactions.index') }}">Transaction</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.index') }}">Account</a></li>
                            <li><a class="dropdown-item" href="{{ route('addresses.index') }}">Address</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('review') }}">Review</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign-up</a>
                @endauth
            </div>

        </div>
    </div>
</header>
