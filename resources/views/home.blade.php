@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- Hero Section - Tema Toko Jam Tangan --}}
    <section class="bg-light py-5 overflow-hidden hero-watch">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Konten Teks --}}
                <div class="col-lg-5" data-aos="fade-right">
                    <h1 class="display-5 fw-bold text-uppercase mb-3">
                        Koleksi Jam Tangan <br> Mewah & Elegan
                    </h1>

                    <p class="text-muted mb-4">
                        Jelajahi koleksi jam tangan premium dengan desain mewah, presisi tinggi, dan kualitas terbaik untuk
                        menunjang gaya hidup modern Anda.
                    </p>

                    <a href="{{ route('catalog.index') }}" class="btn btn-dark btn-lg text-uppercase shadow-sm">
                        Lihat Koleksi
                    </a>
                </div>

                {{-- Visual Produk --}}
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="position-relative">

                        <img src="{{ asset('storage/products/product-7-1768098302-0.jpg') }}"
                            class="img-fluid rounded-4 shadow-lg w-100" style="max-height: 450px; object-fit: cover;">

                        {{-- Label --}}
                        <div
                            class="position-absolute top-0 end-0 bg-dark text-white px-4 py-2 rounded-start text-uppercase small">
                            Koleksi Terbaru
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- Kategori Jam Tangan --}}
    <section class="py-5 bg-light">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase">Kategori Jam Tangan</h2>
                <p class="text-muted">
                    Pilih kategori jam tangan sesuai dengan gaya dan kebutuhan Anda.
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">

                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                            class="text-decoration-none text-dark">

                            <div class="card border-0 shadow-sm text-center h-100 watch-category">

                                <div class="card-body">

                                    <div class="category-image mb-3">
                                        <img src="{{ $category->image_url }}" class="img-fluid rounded-3" width="100"
                                            height="100" style="object-fit: cover;">
                                    </div>

                                    <h6 class="fw-semibold text-uppercase mb-1">
                                        {{ $category->name }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ $category->products_count }} Produk
                                    </small>

                                </div>

                            </div>

                        </a>

                    </div>
                @endforeach

            </div>

        </div>
    </section>


    {{-- Best Selling Watches --}}
    <section class="py-5 bg-light">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-uppercase mb-0">Produk Unggulan</h2>

                <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark text-uppercase">
                    Lihat Semua
                </a>
            </div>

            <div class="row g-4">

                @foreach ($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">

                        <div class="h-100 watch-product">

                            @include('partials.product-card', ['product' => $product])

                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </section>

    {{-- Brand Promotion --}}
    <section class="py-5 bg-white">
        <div class="container">

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 watch-promo">
                        <div class="card-body d-flex flex-column justify-content-center p-5">

                            <h3 class="fw-bold text-uppercase">
                                Koleksi Terlaris
                            </h3>

                            <p class="text-muted">
                                Jam tangan favorit pelanggan dengan desain elegan dan kualitas terpercaya.
                            </p>

                            <a href="{{ route('catalog.index') }}" class="btn btn-dark text-uppercase align-self-start">
                                Lihat Koleksi
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 watch-promo bg-light">
                        <div class="card-body d-flex flex-column justify-content-center p-5">

                            <h3 class="fw-bold text-uppercase">
                                Eksklusif Member
                            </h3>

                            <p class="text-muted">
                                Dapatkan akses lebih awal ke koleksi terbaru dan penawaran khusus.
                            </p>

                            <a href="{{ route('register') }}" class="btn btn-outline-dark text-uppercase align-self-start">
                                Daftar Sekarang
                            </a>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    {{-- Produk Terbaru --}}
    <section class="py-5 bg-light">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase">Produk Terbaru</h2>
                <p class="text-muted">Koleksi jam tangan terbaru dengan desain elegan dan presisi tinggi</p>
            </div>

            <div class="row g-4">
                @foreach ($latestProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

        </div>
    @endsection
