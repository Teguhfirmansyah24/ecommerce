<nav class="navbar navbar-expand-lg navbar-light bg-white bg-opacity-95 shadow-sm sticky-top border-bottom">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width:36px;height:36px;">
                <i class="bi bi-bag-heart-fill"></i>
            </span>
            <span>Toko Teguh</span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- Search --}}
            <form class="d-flex grow w-100 mx-lg-4 my-3 my-lg-0" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group w-100 shadow-sm">
                    <input type="text" name="q" class="form-control border-0"
                        placeholder="Cari produk favoritmu..." value="{{ request('q') }}">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>


            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('catalog.index') }}">
                        Katalog
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @if (auth()->user()->wishlists()->count())
                                <span
                                    class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                                    style="font-size:0.6rem;">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php
                                $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                            @endphp
                            @if ($cartCount)
                                <span
                                    class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle"
                                    style="font-size:0.6rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                            data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border" width="34"
                                height="34">
                            <span class="fw-semibold d-none d-lg-inline">
                                {{ auth()->user()->name }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2"></i> Pesanan
                                </a>
                            </li>

                            @if (auth()->user()->isAdmin())
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-primary fw-semibold"
                                        href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Guest --}}
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
