{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
    <div class="container py-5">

        {{-- Header Wishlist --}}
        <div class="text-center mb-5 animate-on-scroll">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light shadow-sm mb-3"
                style="width:80px; height:80px;">
                <i class="bi bi-heart-fill text-danger fs-2"></i>
            </div>

            <h1 class="fw-bold">Wishlist Eksklusif</h1>
            <p class="text-muted">
                Koleksi jam tangan pilihan yang mencerminkan gaya dan prestise Anda.
            </p>
        </div>

        @if ($products->count())
            <div class="row row-cols-2 row-cols-md-4 g-4">

                @foreach ($products as $product)
                    <div class="col animate-on-scroll">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach

            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-5 bg-light rounded-3 shadow-sm animate-on-scroll">

                <div class="mb-4">
                    <i class="bi bi-watch text-secondary" style="font-size:4rem;"></i>
                </div>

                <h3 class="fw-semibold">Wishlist Masih Kosong</h3>

                <p class="text-muted">
                    Jam tangan mewah belum masuk koleksi Anda.
                    Saatnya memilih yang paling mencerminkan karakter Anda.
                </p>

                <a href="{{ route('catalog.index') }}" class="btn btn-primary px-4 mt-3">
                    Jelajahi Koleksi
                </a>

            </div>

        @endif

    </div>
@endsection
