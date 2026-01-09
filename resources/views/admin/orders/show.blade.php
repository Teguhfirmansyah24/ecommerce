@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-semibold text-dark mb-0">
                        Detail Pesanan
                    </h2>
                    <small class="text-muted">
                        Order #{{ $order->order_number }} • {{ $order->created_at->format('d M Y H:i') }}
                    </small>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="row g-4">

                {{-- ================= ITEM PESANAN ================= --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-box-seam me-1"></i> Item Pesanan
                            </h5>
                        </div>

                        <div class="card-body">
                            @foreach ($order->items as $item)
                                <div class="d-flex align-items-center mb-3 p-2 rounded bg-light">

                                    <img src="{{ $item->product->image_url }}" class="rounded border me-3"
                                        style="width:60px;height:60px;object-fit:cover">

                                    <div class="grow">
                                        <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                        <small class="text-muted">
                                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </small>
                                    </div>

                                    <div class="fw-bold text-success">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach

                            <hr>

                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                <span>Total Pembayaran</span>
                                <span class="text-primary">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= SIDEBAR ================= --}}
                <div class="col-lg-4">

                    {{-- INFO CUSTOMER --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-person me-1"></i> Info Customer
                            </h5>
                        </div>

                        <div class="card-body">
                            <p class="mb-1 fw-bold">{{ $order->user->name }}</p>
                            <p class="mb-1 text-muted">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    {{-- UPDATE STATUS --}}
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-gear me-1"></i> Update Status Order
                            </h6>

                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label class="form-label small text-muted">
                                        Status Saat Ini:
                                        <strong class="text-primary">{{ ucfirst($order->status) }}</strong>
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing (Sedang Dikemas)
                                        </option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped (Dikirim)
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered (Sampai Tujuan)
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled (Batalkan & Restock)
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                    <i class="bi bi-save me-1"></i> Update Status
                                </button>
                            </form>

                            @if ($order->status == 'cancelled')
                                <div class="alert alert-danger mt-3 mb-0 small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pesanan ini telah dibatalkan. Stok produk telah dikembalikan otomatis.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
