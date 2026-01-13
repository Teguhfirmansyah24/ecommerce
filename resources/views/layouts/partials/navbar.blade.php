<header class="app-header border-bottom bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg px-3">

        <!-- Left: App Title -->
        <a href="{{ route('home') }}" class="btn btn-outline-primary fw-bold d-flex align-items-center" target="_blank">
            <i class="bi bi-house-door-fill me-2"></i>
            HOME
        </a>


        <!-- Right: Notification + Profile -->
        <ul class="navbar-nav ms-auto align-items-center">

            <!-- Notification Icon -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="javascript:void(0)" id="notificationDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notificationDropdown">
                    <li><a class="dropdown-item text-center" href="#">No Notification</a></li>
                </ul>
            </li>

            <!-- Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Profile" width="35"
                        height="35" class="rounded-circle border">
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow-sm">

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
