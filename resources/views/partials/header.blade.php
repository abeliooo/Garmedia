<header class="py-3">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <div class="dropdown"> <a href="/" class="link-body-emphasis text-decoration-none fw-bold">
                Garmedia
            </a>

        </div>
        <div class="d-flex align-items-center justify-content">
            <div class="dropdown me-3">
                <a href="#" class="link-body-emphasis text-decoration-none dropdown-toggle ms-2"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Bootstrap menu">
                    Category
                </a>

                <ul class="dropdown-menu text-small shadow" style="">
                    <li><a class="dropdown-item active" href="#" aria-current="page">Overview</a></li>
                    <li><a class="dropdown-item" href="#">Inventory</a></li>
                    <li><a class="dropdown-item" href="#">Customers</a></li>
                    <li><a class="dropdown-item" href="#">Products</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Reports</a></li>
                    <li><a class="dropdown-item" href="#">Analytics</a></li>
                </ul>
            </div>

            <form class="w-50" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="q" class="form-control" placeholder="Search Title or Author"
                    aria-label="Search" value="{{ request('q') }}">
            </form>

            <div class="d-flex align-items-center ms-auto">
                <a href="/wishlist" class="link-body-emphasis me-3" aria-label="Wishlist">
                    <i class="bi bi-heart fs-5"></i>
                </a>

                <a href="/cart" class="link-body-emphasis me-3" aria-label="Cart">
                    <i class="bi bi-bookmark-heart fs-5"></i>
                </a>

                <div class="flex-shrink-0 dropdown">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false"> <img src="https://github.com/mdo.png"
                            alt="mdo" width="32" height="32" class="rounded-circle"> </a>
                    <ul class="dropdown-menu text-small shadow">
                        <li><a class="dropdown-item" href="/transaction">Transaction</a></li>
                        <li><a class="dropdown-item" href="/account">Account</a></li>
                        <li><a class="dropdown-item" href="/address">Address</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/review">Review</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</header>
