<header class="app-header border-bottom bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg px-3">

        <!-- Left: Logo -->
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2">

        </a>

        <!-- Right: Profile -->
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Profile" width="35"
                        height="35" class="rounded-circle border">
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow-sm">
                    <a href="#" class="dropdown-item d-flex align-items-center gap-2">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>

                    <a href="#" class="dropdown-item d-flex align-items-center gap-2">
                        <i class="bi bi-envelope"></i>
                        <span>My Account</span>
                    </a>

                    <a href="#" class="dropdown-item d-flex align-items-center gap-2">
                        <i class="bi bi-list-check"></i>
                        <span>My Task</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}" class="px-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>

    </nav>
</header>
