@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100 border-start border-success border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Pendapatan</p>
                        <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Pesanan</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['total_orders'] }}</h4>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="bi bi-bag text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Perlu Diproses</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['pending_orders'] }}</h4>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded p-3">
                        <i class="bi bi-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Stok Menipis</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['low_stock'] }}</h4>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded p-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-semibold text-dark">Grafik Order Bulanan</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-semibold text-dark">Pendapatan Harian</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="dailyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Pesanan Terbaru</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Order</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td class="fw-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}">
                                                #{{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @include('components.order-status-badge', [
                                                'status' => $order->status,
                                            ])
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-semibold">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}"
                            class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Produk
                        </a>

                        <a href="{{ route('admin.categories.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-tags"></i>
                            Kelola Kategori
                        </a>

                        <a href="{{ route('admin.reports.sales') }}"
                            class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-bar-chart"></i>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const labels = @json(array_keys($monthlyOrders));
        const data = @json(array_values($monthlyOrders));

        new Chart(document.getElementById('orderChart'), {
            type: 'line',
            data: {
                labels: labels.map(m => 'Bulan ' + m),
                datasets: [{
                    label: 'Jumlah Order',
                    data: data,
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const dailyLabels = @json(array_keys($dailyRevenue));
        const dailyData = @json(array_values($dailyRevenue));

        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dailyData,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endpush
