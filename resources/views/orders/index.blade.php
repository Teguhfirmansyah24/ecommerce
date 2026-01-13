@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Pesanan Saya</h1>
                <p class="text-muted mb-0">Pantau status pesanan Anda secara real-time</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Order</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $statusMap = [
                                        'pending' => [
                                            'label' => 'Menunggu Pembayaran',
                                            'class' => 'warning text-dark',
                                            'icon' => 'bi-clock',
                                        ],
                                        'processing' => [
                                            'label' => 'Diproses',
                                            'class' => 'info text-dark',
                                            'icon' => 'bi-box-seam',
                                        ],
                                        'shipped' => ['label' => 'Dikirim', 'class' => 'primary', 'icon' => 'bi-truck'],
                                        'delivered' => [
                                            'label' => 'Selesai',
                                            'class' => 'success',
                                            'icon' => 'bi-check-circle',
                                        ],
                                        'cancelled' => [
                                            'label' => 'Dibatalkan',
                                            'class' => 'danger',
                                            'icon' => 'bi-x-circle',
                                        ],
                                    ];

                                    $status = $statusMap[$order->status] ?? [
                                        'label' => ucfirst($order->status),
                                        'class' => 'secondary',
                                        'icon' => 'bi-question-circle',
                                    ];
                                @endphp

                                <tr class="order-row">
                                    <td class="fw-bold text-primary">#{{ $order->order_number }}</td>

                                    <td>
                                        <div class="fw-medium">{{ $order->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-{{ $status['class'] }} px-3 py-2 d-inline-flex align-items-center gap-1">
                                            <i class="bi {{ $status['icon'] }}"></i>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <td class="fw-bold">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-bag-x" style="font-size: 3rem;"></i>
                                        <p class="mt-3 mb-0 fw-medium">Belum ada pesanan</p>
                                        <small>Silakan lakukan pembelian terlebih dahulu</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

            <div class="card-footer bg-white border-0 d-flex justify-content-end">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection
