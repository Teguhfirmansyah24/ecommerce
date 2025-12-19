{{-- ======================================== FILE:
resources/views/layouts/app.blade.php FUNGSI: Template utama yang digunakan
semua halaman ======================================== --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- ↑ str_replace mengganti underscore dengan dash Contoh: en_US menjadi
en-US --}}

<head>
    <meta charset="utf-8" />
    {{-- ↑ Encoding karakter UTF-8 untuk mendukung karakter Indonesia --}}

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- ↑ Membuat halaman responsive di semua ukuran layar --}}

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- ↑ CSRF Token untuk keamanan form Mencegah serangan Cross-Site Request
    Forgery --}}

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) {{-- ↑ Load file
    CSS dan JS yang sudah di-compile oleh Vite - app.scss berisi Bootstrap dan
    custom styles - app.js berisi Bootstrap JS dan custom scripts --}}

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>
    <div id="app">
        {{-- ============================================
         NAVBAR
         ============================================ --}}
        @include('partials.navbar')

        {{-- ============================================
         FLASH MESSAGES
         ============================================ --}}
        <div class="container mt-3">
            @include('partials.flash-messages')
        </div>

        {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
        <main class="min-vh-100">
            @yield('content')
        </main>

        {{-- ============================================
         FOOTER
         ============================================ --}}
        @include('partials.footer')

        {{-- Stack untuk JS tambahan per halaman --}}
        @stack('scripts')
    </div>
</body>

</html>
