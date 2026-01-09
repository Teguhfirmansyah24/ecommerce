{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold text-dark mb-0">
                Laporan Penjualan
            </h2>
        </div>
    </div>

    {{-- FILTER CARD --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
                </div>

                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-semibold">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.reports.export-sales', request()->all()) }}"
                        class="btn btn-success fw-semibold">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold">Total Pendapatan</div>
                    <div class="h3 fw-bold text-dark mb-0">
                        Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                    </div>
                    <small class="text-muted">Periode ini</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold">Total Transaksi</div>
                    <div class="h3 fw-bold text-dark mb-0">
                        {{ number_format($summary->total_orders ?? 0) }}
                    </div>
                    <small class="text-muted">Order dibayar</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- PERFORMA KATEGORI --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-tags me-1"></i> Performa Kategori
                    </h5>
                </div>

                <div class="card-body">
                    @foreach ($byCategory as $cat)
                        @php
                            $percent = ($cat->total / ($summary->total_revenue ?: 1)) * 100;
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">{{ $cat->name }}</span>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($cat->total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TABEL TRANSAKSI --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt me-1"></i> Rincian Transaksi
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="fw-bold text-primary">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>

                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>

                                    <td>
                                        <div class="fw-bold">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </td>

                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-clipboard-x fs-3 d-block mb-2"></i>
                                        Tidak ada data penjualan pada periode ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white">
                    {{ $orders->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
