{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold mb-4">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                {{-- Form Alamat --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Informasi Pengiriman</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Pesanan --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm position-sticky" style="top: 1rem;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Ringkasan Pesanan</h5>

                            <div class="mb-3" style="max-height: 250px; overflow-y: auto;">
                                @foreach ($cart->items as $item)
                                    <div class="d-flex justify-content-between small mb-2">
                                        <span>
                                            {{ $item->product->name }} x {{ $item->quantity }}
                                        </span>
                                        <span class="fw-semibold">
                                            {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fw-bold mb-3">
                                <span>Total</span>
                                <span>
                                    Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
