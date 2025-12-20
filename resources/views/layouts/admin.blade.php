<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Teguh</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/laravel.png" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.partials.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.partials.navbar')
            <!--  Header End -->
            <div class="container-fluid">
                <!--  Row 1 -->
                @include('partials.flash-messages')
                @yield('content')
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Copyright <a href="https://adminmart.com/" target="_blank"
                            class="pe-1 text-primary text-decoration-underline">Teguh Store</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }} "></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
