@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- SIDEBAR FILTER --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white fw-bold text-center">Filter Produk</div>
                    <div class="card-body">
                        <form action="{{ route('catalog.index') }}" method="GET">
                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            {{-- Filter Kategori --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Kategori</h6>
                                @foreach ($categories as $cat)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category"
                                            value="{{ $cat->slug }}"
                                            {{ request('category') == $cat->slug ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <label class="form-check-label d-flex justify-content-between align-items-center">
                                            {{ $cat->name }}
                                            <span class="badge bg-secondary rounded-pill">{{ $cat->products_count }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Filter Harga --}}
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2">Rentang Harga</h6>
                                <div class="d-flex gap-2">
                                    <input type="number" name="min_price" class="form-control form-control-sm"
                                        placeholder="Min" value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control form-control-sm"
                                        placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-sm mb-2">Terapkan Filter</button>
                            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 btn-sm">Reset</a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-2">
                    <h4 class="mb-0">Katalog Produk</h4>

                    {{-- Sorting --}}
                    <form method="GET" class="d-inline-block">
                        @foreach (request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                        </select>
                    </form>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-3 product-card hover-shadow"
                                style="transition: transform 0.2s;">
                                <x-product-card :product="$product" />
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('images/empty-state.svg') }}" width="150" class="mb-3 opacity-50">
                            <h5>Produk tidak ditemukan</h5>
                            <p class="text-muted">Coba kurangi filter atau gunakan kata kunci lain.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hover efek untuk card produk */
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Hover efek radio button label */
        .form-check-label:hover {
            cursor: pointer;
            color: #0d6efd;
        }

        /* Filter card */
        .card-body input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .25);
        }

        /* Select sort */
        select.form-select-sm:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .25);
        }
    </style>
@endsection
