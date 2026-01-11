@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="text-center mb-5 animate-on-scroll">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light shadow-sm mb-3"
                style="width:80px; height:80px;">
                <i class="bi bi-credit-card text-primary fs-2"></i>
            </div>
            <h2 class="fw-bold">Checkout</h2>
            <p class="text-muted">
                Lengkapi informasi pengiriman untuk menyelesaikan pembelian jam tangan pilihan Anda.
            </p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- Form Pengiriman --}}
                <div class="col-lg-8 animate-on-scroll">
                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white fw-bold">
                            Informasi Pengiriman
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-medium">Nama Penerima</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control"
                                    placeholder="Nama lengkap penerima" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control" placeholder="Contoh: 08xxxxxxxxxx"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Alamat Lengkap</label>
                                <textarea name="address" rows="4" class="form-control" placeholder="Masukkan alamat pengiriman lengkap" required></textarea>
                            </div>

                            <div class="alert alert-light border mt-4 small">
                                <i class="bi bi-shield-check me-2 text-success"></i>
                                Data Anda aman dan hanya digunakan untuk proses pengiriman.
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Ringkasan Pesanan --}}
                <div class="col-lg-4 animate-on-scroll">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 1rem;">

                        <div class="card-header bg-white fw-bold">
                            Ringkasan Pesanan
                        </div>

                        <div class="card-body">

                            <div class="mb-3" style="max-height: 260px; overflow-y: auto;">

                                @foreach ($cart->items as $item)
                                    <div class="d-flex justify-content-between align-items-start small mb-2">
                                        <div class="pe-2">
                                            <div class="fw-medium">
                                                {{ Str::limit($item->product->name, 40) }}
                                            </div>
                                            <span class="text-muted">
                                                {{ $item->quantity }} x {{ $item->product->formatted_price }}
                                            </span>
                                        </div>

                                        <div class="fw-semibold text-primary">
                                            {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total Pembayaran</span>
                                <span class="fw-bold fs-5 text-primary">
                                    Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Buat Pesanan
                            </button>

                            <p class="text-center small text-muted mt-3 mb-0">
                                Dengan menekan tombol ini, Anda menyetujui proses pemesanan.
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection
