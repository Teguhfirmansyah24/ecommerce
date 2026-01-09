<aside class="left-sidebar bg-light border-end vh-100">
    <div>

        <!-- Brand -->
        <div class="brand-logo d-flex align-items-center px-4 py-3 border-bottom">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-gem fs-4 text-warning"></i>
                <span class="fw-bold fs-5 text-dark">Luxury Watch</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav px-3 pt-3" data-simplebar="">
            <ul id="sidebarnav" class="list-unstyled">

                <li class="text-muted small fw-semibold mb-2">MAIN</li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link d-flex align-items-center gap-2 rounded px-3 py-2"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="text-muted small fw-semibold mt-4 mb-2">MANAGEMENT</li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link d-flex align-items-center gap-2 rounded px-3 py-2"
                        href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link d-flex align-items-center gap-2 rounded px-3 py-2"
                        href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link d-flex align-items-center gap-2 rounded px-3 py-2"
                        href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link d-flex align-items-center gap-2 rounded px-3 py-2"
                        href="{{ route('admin.reports.sales') }}">
                        <i class="bi bi-bar-chart"></i>
                        <span>Sales Report</span>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>
