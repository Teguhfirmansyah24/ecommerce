@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row g-4">

            {{-- SIDEBAR FILTER --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm animate-on-scroll">

                    <div class="card-header bg-white fw-bold text-center border-bottom">
                        Filter Produk
                    </div>

                    <div class="card-body">

                        <form action="{{ route('catalog.index') }}" method="GET">

                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            {{-- KATEGORI --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Kategori</h6>

                                @foreach ($categories as $cat)
                                    <div class="form-check mb-2 d-flex justify-content-between align-items-center">

                                        <div>
                                            <input class="form-check-input" type="radio" name="category"
                                                value="{{ $cat->slug }}"
                                                {{ request('category') == $cat->slug ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            <label class="form-check-label ms-1">
                                                {{ $cat->name }}
                                            </label>
                                        </div>

                                        <span class="badge bg-light text-dark border">
                                            {{ $cat->active_products_count }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- HARGA --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Rentang Harga</h6>

                                <div class="d-flex gap-2">
                                    <input type="number" name="min_price" class="form-control form-control-sm"
                                        placeholder="Min" value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control form-control-sm"
                                        placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-sm mb-2">
                                Terapkan Filter
                            </button>

                            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 btn-sm">
                                Reset
                            </a>

                        </form>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="col-lg-9">

                {{-- HEADER --}}
                <div
                    class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3 animate-on-scroll">

                    <div>
                        <h4 class="fw-bold mb-0">Katalog Jam Tangan</h4>
                        <small class="text-muted">Temukan jam tangan terbaik untuk gaya Anda</small>
                    </div>

                    {{-- SORTING --}}
                    <form method="GET" class="d-inline-block">

                        @foreach (request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <select name="sort" class="form-select form-select-sm shadow-sm" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Harga Terendah
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Harga Tertinggi
                            </option>
                        </select>
                    </form>
                </div>

                {{-- PRODUK --}}
                <div class="row row-cols-1 row-cols-md-3 g-4">

                    @forelse($products as $product)
                        <div class="col animate-on-scroll">

                            <div class="h-100 hover-lift">

                                <x-product-card :product="$product" />

                            </div>

                        </div>

                    @empty

                        <div class="col-12 text-center py-5 animate-on-scroll">
                            <img src="{{ asset('images/empty-state.svg') }}" width="160" class="mb-3 opacity-50">
                            <h5 class="fw-semibold">Produk tidak ditemukan</h5>
                            <p class="text-muted">
                                Coba kurangi filter atau gunakan kata kunci lain.
                            </p>
                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                <div class="mt-5 animate-on-scroll">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
@endsection
