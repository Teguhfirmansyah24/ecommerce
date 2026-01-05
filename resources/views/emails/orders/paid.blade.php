{{-- resources/views/emails/orders/paid.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Dibayar</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="mb-3">
                            Halo, {{ $order->user->name }}
                        </h4>

                        <p>
                            Terima kasih. Pembayaran untuk pesanan
                            <strong>#{{ $order->order_number }}</strong>
                            telah kami terima.
                            Pesanan Anda sedang kami proses.
                        </p>

                        <div class="table-responsive my-4">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td></td>
                                        <td class="text-end">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center my-4">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                                Lihat Detail Pesanan
                            </a>
                        </div>

                        <p class="mb-0">
                            Jika ada pertanyaan, silakan balas email ini.
                        </p>

                        <hr>

                        <p class="text-muted mb-0">
                            Salam,<br>
                            {{ config('app.name') }}
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
