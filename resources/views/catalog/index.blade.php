{{-- ================================================
     FILE: resources/views/catalog/index.blade.php
     FUNGSI: Halaman katalog/daftar produk
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
    <div class="container py-4">
        <div class="row">
            {{-- SIDEBAR FILTER --}}
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('catalog.index') }}" method="GET" id="filter-form">
                            {{-- Pertahankan search query --}}
                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            {{-- Filter Kategori --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Kategori</h6>
                                @foreach ($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category"
                                            id="cat-{{ $category->slug }}" value="{{ $category->slug }}"
                                            {{ request('category') == $category->slug ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <label class="form-check-label d-flex justify-content-between"
                                            for="cat-{{ $category->slug }}">
                                            {{ $category->name }}
                                            <span class="badge bg-secondary">{{ $category->products_count }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Filter Harga --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Rentang Harga</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" name="min_price"
                                            placeholder="Min" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" name="max_price"
                                            placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                    Terapkan
                                </button>
                            </div>

                            {{-- Filter Lainnya --}}
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="on_sale" id="on_sale"
                                        value="1" {{ request('on_sale') ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <label class="form-check-label" for="on_sale">
                                        <i class="bi bi-tag text-danger"></i> Sedang Diskon
                                    </label>
                                </div>
                            </div>

                            {{-- Reset Filter --}}
                            @if (request()->hasAny(['category', 'min_price', 'max_price', 'on_sale']))
                                <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="bi bi-x-circle me-1"></i> Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                {{-- Header & Sorting --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-0">
                            @if (request('q'))
                                Hasil pencarian: "{{ request('q') }}"
                            @elseif(request('category'))
                                {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Produk' }}
                            @else
                                Semua Produk
                            @endif
                        </h4>
                        <small class="text-muted">{{ $products->total() }} produk ditemukan</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="me-2 text-nowrap">Urutkan:</label>
                        <select class="form-select form-select-sm" style="width: auto;"
                            onchange="window.location.href = this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                                {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Harga: Rendah ke Tinggi
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Harga: Tinggi ke Rendah
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}"
                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                Nama: A-Z
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                @if ($products->count())
                    <div class="row g-4">
                        @foreach ($products as $product)
                            <div class="col-6 col-md-4">
                                @include('partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-search display-1 text-muted"></i>
                        <h5 class="mt-3">Produk tidak ditemukan</h5>
                        <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
