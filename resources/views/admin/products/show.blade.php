@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold text-dark mb-0">Detail Produk</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}"
                class="btn btn-outline-warning d-flex align-items-center gap-1">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>

            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>


    <div class="row g-4">

        {{-- ================= IMAGES ================= --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">

                    {{-- Primary Image --}}
                    <img src="{{ asset('storage/' . $product->primaryImage?->image_path) }}"
                        class="img-fluid rounded mb-3 w-100 border" style="object-fit:cover;max-height:320px">

                    {{-- Gallery --}}
                    <div class="row g-2">
                        @foreach ($product->images as $image)
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded border"
                                    style="object-fit:cover;height:90px;width:100%">
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>


        {{-- ================= PRODUCT INFO ================= --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <h4 class="fw-bold mb-1">
                        {{ $product->name }}
                    </h4>

                    <p class="text-muted mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-tags"></i>
                        {{ $product->category->name }}
                    </p>

                    {{-- Price --}}
                    <h5 class="fw-bold mb-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}

                        @if ($product->discount_price)
                            <span class="text-muted fs-6 text-decoration-line-through ms-2">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </span>
                        @endif
                    </h5>

                    {{-- Status --}}
                    <div class="mb-3 d-flex gap-2">
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>

                        @if ($product->is_featured)
                            <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                Unggulan
                            </span>
                        @endif
                    </div>

                    <hr>

                    {{-- Description --}}
                    <div class="mb-4 text-muted">
                        {!! $product->description ?: '-' !!}
                    </div>

                    {{-- Meta --}}
                    <div class="row small text-muted">

                        <div class="col-md-4 mb-2">
                            <strong class="text-dark">Stok</strong>
                            <div>{{ $product->stock }}</div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <strong class="text-dark">Berat</strong>
                            <div>{{ $product->weight }} gram</div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <strong class="text-dark">Dibuat</strong>
                            <div>{{ $product->created_at->format('d M Y') }}</div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
