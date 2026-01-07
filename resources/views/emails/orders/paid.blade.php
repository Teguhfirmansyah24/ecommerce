{{-- resources/views/emails/orders/paid.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Dibayar</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background-color: #f5f5f5; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="20" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 6px;">

                    {{-- Header --}}
                    <tr>
                        <td>
                            <h2 style="margin: 0;">Halo, {{ $order->user->name }}</h2>
                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td>
                            <p>
                                Terima kasih. Pembayaran untuk pesanan
                                <strong>#{{ $order->order_number }}</strong>
                                telah kami terima.
                            </p>

                            <p>
                                Saat ini pesanan Anda sedang kami proses.
                            </p>
                        </td>
                    </tr>

                    {{-- Table --}}
                    <tr>
                        <td>
                            <table width="100%" cellpadding="8" cellspacing="0" border="1"
                                style="border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f0f0f0;">
                                        <th align="left">Produk</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td align="center">{{ $item->quantity }}</td>
                                            <td align="right">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td></td>
                                        <td align="right">
                                            <strong>
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    {{-- Button --}}
                    <tr>
                        <td align="center">
                            <a href="{{ route('orders.show', $order) }}"
                                style="
                                   display: inline-block;
                                   padding: 12px 20px;
                                   background-color: #111827;
                                   color: #ffffff;
                                   text-decoration: none;
                                   border-radius: 4px;
                               ">
                                Lihat Detail Pesanan
                            </a>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td>
                            <p>
                                Jika ada pertanyaan, silakan balas email ini.
                            </p>

                            <p>
                                Salam,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
