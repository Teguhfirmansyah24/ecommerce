@extends('layouts.app')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="h3 mb-4 text-warning fw-bold">Pembayaran Pending</h1>
        <p class="mb-4">Status pembayaran pesanan Anda masih menunggu. Silakan selesaikan pembayaran sesuai instruksi yang
            diberikan.</p>
        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">Lihat Detail Pesanan</a>
    </div>
@endsection
