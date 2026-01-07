@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Daftar Pesanan</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            {{-- Filter Status --}}
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Diproses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index', ['status' => 'delivered']) }}">Sampai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">Batal</a>
                </li>
            </ul>
        </div>
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
                                <td class="ps-4 fw-bold text-primary">#{{ $order->order_number }}</td>
                                <td>
                                    <div class="fw-bold">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info text-dark">Diproses</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-primary">Dikirim</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-success">Sampai</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger">Batal</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Tidak ada pesanan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
