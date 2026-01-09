@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-semibold text-dark mb-0">
                    Manajemen Pesanan
                </h2>
            </div>

            <div class="card shadow-sm border-0">

                {{-- FILTER STATUS --}}
                <div class="card-header bg-white py-3">
                    <ul class="nav nav-pills card-header-pills gap-2">
                        @php
                            $statuses = [
                                '' => ['Semua', 'secondary'],
                                'pending' => ['Pending', 'warning'],
                                'processing' => ['Diproses', 'info'],
                                'shipped' => ['Dikirim', 'primary'],
                                'delivered' => ['Sampai', 'success'],
                                'cancelled' => ['Batal', 'danger'],
                            ];
                        @endphp

                        @foreach ($statuses as $key => [$label, $color])
                            <li class="nav-item">
                                <a class="nav-link fw-semibold {{ request('status') == $key ? 'active bg-' . $color . ' text-white' : 'text-' . $color }}"
                                    href="{{ route('admin.orders.index', $key ? ['status' => $key] : []) }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- TABLE --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">No. Order</th>
                                    <th>Customer</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">
                                            #{{ $order->order_number }}
                                        </td>

                                        <td>
                                            <div class="fw-bold">{{ $order->user->name }}</div>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </td>

                                        <td>
                                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </td>

                                        <td class="fw-bold text-success">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            @php
                                                $statusMap = [
                                                    'pending' => ['warning', 'clock', 'Pending'],
                                                    'processing' => ['info', 'gear', 'Diproses'],
                                                    'shipped' => ['primary', 'truck', 'Dikirim'],
                                                    'delivered' => ['success', 'check-circle', 'Sampai'],
                                                    'cancelled' => ['danger', 'x-circle', 'Batal'],
                                                ];
                                                [$color, $icon, $label] = $statusMap[$order->status];
                                            @endphp

                                            <span
                                                class="badge bg-{{ $color }}-subtle text-{{ $color }} px-3 py-2 fw-semibold">
                                                <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
                                            </span>
                                        </td>

                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="btn btn-sm btn-outline-primary fw-semibold">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                                            Tidak ada pesanan ditemukan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PAGINATION --}}
                <div class="card-footer bg-white">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
@endsection
