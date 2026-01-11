@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="card shadow-lg border-0 mb-4 overflow-hidden">

                    {{-- HEADER --}}
                    <div class="card-header bg-white d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        @php
                            $statusClass = match ($order->status) {
                                'pending' => 'warning',
                                'processing' => 'primary',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            };
                        @endphp

                        <span class="badge bg-{{ $statusClass }} px-3 py-2 text-uppercase fs-6">
                            {{ $order->status }}
                        </span>
                    </div>

                    {{-- STATUS TRACKER --}}
                    @php
                        $steps = [
                            'pending' => ['label' => 'Menunggu Pembayaran', 'icon' => 'bi-wallet2'],
                            'processing' => ['label' => 'Diproses', 'icon' => 'bi-box-seam'],
                            'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck'],
                            'delivered' => ['label' => 'Selesai', 'icon' => 'bi-check-circle'],
                        ];

                        $statusOrder = array_keys($steps);
                        $currentIndex = array_search($order->status, $statusOrder);
                    @endphp

                    <div class="card-body bg-light border-top">
                        <div class="position-relative status-tracker-advanced">

                            <div class="progress-line"></div>

                            <div class="d-flex justify-content-between text-center">
                                @foreach ($steps as $key => $step)
                                    @php
                                        $index = array_search($key, $statusOrder);
                                        $active = $index <= $currentIndex;
                                    @endphp

                                    <div class="status-step-advanced {{ $active ? 'active' : '' }}">
                                        <div class="status-icon-advanced">
                                            <i class="bi {{ $step['icon'] }}"></i>
                                        </div>
                                        <p class="small fw-semibold mt-2 mb-0">{{ $step['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- PRODUK --}}
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-bag-check me-2"></i>
                            Produk yang Dipesan
                        </h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr class="border-bottom">
                                            <td class="fw-medium">{{ $item->product_name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">
                                                Rp
                                                {{ number_format($item->product->discount_price ?? $item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end fw-semibold">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @if ($order->shipping_cost > 0)
                                        <tr>
                                            <td colspan="3" class="text-end">Ongkos Kirim</td>
                                            <td class="text-end">
                                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="fw-bold fs-5">
                                        <td colspan="3" class="text-end">TOTAL BAYAR</td>
                                        <td class="text-end text-primary">
                                            @php
                                                $total = 0;
                                                foreach ($order->items as $item) {
                                                    $total += $item->price * $item->quantity;
                                                }
                                            @endphp

                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- ALAMAT --}}
                    <div class="card-body bg-white border-top">
                        <h5 class="fw-bold mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            Alamat Pengiriman
                        </h5>

                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
                            <p class="mb-1 text-muted">{{ $order->shipping_phone }}</p>
                            <p class="mb-0">{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    {{-- PEMBAYARAN --}}
                    @if ($order->status === 'pending' && $snapToken)
                        <div class="card-body text-center bg-primary bg-opacity-10 border-top">
                            <h5 class="fw-bold mb-2">Menunggu Pembayaran</h5>
                            <p class="text-muted mb-3">
                                Silakan selesaikan pembayaran agar pesanan dapat segera diproses.
                            </p>

                            <button id="pay-button" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="bi bi-credit-card me-2"></i>
                                Bayar Sekarang
                            </button>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection

{{-- MIDTRANS --}}
@if ($snapToken)
    @push('scripts')
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');
                if (!payButton) return;

                payButton.addEventListener('click', function() {
                    payButton.disabled = true;
                    payButton.textContent = 'Memproses...';

                    window.snap.pay('{{ $snapToken }}', {
                        onSuccess: function() {
                            window.location.reload();
                        },
                        onPending: function() {
                            window.location.reload();
                        },
                        onError: function() {
                            alert('Pembayaran gagal.');
                            payButton.disabled = false;
                            payButton.textContent = 'Bayar Sekarang';
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.textContent = 'Bayar Sekarang';
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
