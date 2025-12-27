<?php
// app/Http/Controllers/MidtransNotificationController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     */
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     * Access: Public (Midtrans Server)
     */
    public function handle(Request $request)
    {
        // 1. Ambil data notifikasi
        $payload = $request->all();

        // Log untuk debugging (Cev storage/logs/laravel.log jika ada masalah)
        Log::info('Midtrans Notification Received', $payload);

        // 2. Extract Data Penting
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;

        // 3. Validasi Field Wajib
        if (!$orderId || !$transactionStatus || !$signatureKey) {
            Log::warning('Midtrans Notification: Missing required fields', $payload);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // ============================================================
        // 4. VALIDASI SIGNATURE KEY (KRITIS!)
        // ============================================================
        // Ini adalah lapisan keamanan utama. Kita harus men-generate ulang
        // signature di sisi kita dan membandingkannya dengan kiriman Midtrans.
        // Rumus: SHA512(order_id + status_code + gross_amount + ServerKey)
        // ============================================================
        $serverKey = config('midtrans.server_key');

        // Buat string hash
        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            // Jika beda, berarti request PALSU (potensi serangan hacker)
            Log::warning('Midtrans Notification: Invalid signature', [
                'order_id' => $orderId,
                'received' => $signatureKey,
                'expected' => $expectedSignature,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 5. Cari Order di Database
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning("Midtrans Notification: Order not found", ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ============================================================
        // 6. IDEMPOTENCY CHECK & CONCURRENCY
        // ============================================================
        // Midtrans bisa mengirim notifikasi yang sama berkali-kali (retry mechanism).
        // Kita harus pastikan logika kita aman jika dipanggil double.
        // Jika order sudah berstatus final (processing/shipped/delivered), stop.
        // ============================================================
        if (in_array($order->status, ['processing', 'shipped', 'delivered', 'cancelled'])) {
            Log::info("Midtrans Notification: Order already processed", ['order_id' => $orderId]);
            return response()->json(['message' => 'Order already processed'], 200);
        }

        // 7. Update Data Tambahan di Payment Record
        // Simpan transaction_id dari Midtrans untuk referensi refund nanti
        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_type'            => $paymentType,
                'raw_response'            => json_encode($payload),
            ]);
        }

        // ============================================================
        // 8. MAPPING STATUS TRANSAKSI
        // ============================================================
        // Logika utama penentuan nasib order ada di sini.
        // ============================================================
        switch ($transactionStatus) {
            case 'capture':
                // Khusus Kartu Kredit (Authorize & Capture)
                if ($fraudStatus === 'challenge') {
                    // Transaksi dicurigai fraud oleh FDS Midtrans -> Review
                    $this->handlePending($order, $payment, 'Menunggu review fraud');
                } else {
                    $this->handleSuccess($order, $payment);
                }
                break;

            case 'settlement':
                // Pembayaran sukses (Bank Transfer, E-Wallet, dll)
                $this->handleSuccess($order, $payment);
                break;

            case 'pending':
                // User belum bayar / Menunggu pembayaran
                $this->handlePending($order, $payment, 'Menunggu pembayaran');
                break;

            case 'deny':
                // Pembayaran ditolak oleh bank/provider
                $this->handleFailed($order, $payment, 'Pembayaran ditolak');
                break;

            case 'expire':
                // Token expired (tidak dibayar tepat waktu)
                $this->handleFailed($order, $payment, 'Pembayaran kadaluarsa');
                break;

            case 'cancel':
                // Dibatalkan user/admin
                $this->handleFailed($order, $payment, 'Pembayaran dibatalkan');
                break;

            case 'refund':
            case 'partial_refund':
                $this->handleRefund($order, $payment);
                break;

            default:
                Log::info("Midtrans Notification: Unknown status", [
                    'order_id' => $orderId,
                    'status'   => $transactionStatus,
                ]);
        }

        // 9. Return 200 OK
        // Wajib return 200 agar Midtrans tahu notifikasi berhasil diterima.
        // Jika tidak, Midtrans akan terus mengirim ulang notifikasi.
        return response()->json(['message' => 'Notification processed'], 200);
    }

    /**
     * Handle pembayaran sukses.
     */
    protected function handleSuccess(Order $order, ?Payment $payment): void
    {
        Log::info("Payment SUCCESS for Order: {$order->order_number}");

        // Update Order
        $order->update([
            'status' => 'processing', // Siap diproses/dikirim
            'payment_status' => 'paid', // Tandai sudah dibayar
        ]);

        // Update Payment
        if ($payment) {
            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);
        }

        // TODO: Kirim email konfirmasi pembayaran
        // event(new PaymentSuccessful($order));
    }

    /**
     * Handle pembayaran pending.
     */
    protected function handlePending(Order $order, ?Payment $payment, string $message = ''): void
    {
        Log::info("Payment PENDING for Order: {$order->order_number}", ['message' => $message]);

        // Order tetap pending
        // Payment tetap pending
        if ($payment) {
            $payment->update(['status' => 'pending']);
        }
    }

    /**
     * Handle pembayaran gagal/expired/cancelled.
     */
    protected function handleFailed(Order $order, ?Payment $payment, string $reason = ''): void
    {
        Log::info("Payment FAILED for Order: {$order->order_number}", ['reason' => $reason]);

        // Update Order
        $order->update([
            'status' => 'cancelled',
        ]);

        // Update Payment
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // ============================================================
        // RESTOCK LOGIC (Kembalikan stok produk)
        // ============================================================
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }

        // TODO: Kirim email notifikasi pembayaran gagal
    }

    /**
     * Handle refund.
     */
    protected function handleRefund(Order $order, ?Payment $payment): void
    {
        Log::info("Payment REFUNDED for Order: {$order->order_number}");

        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }

        // TODO: Logic tambahan untuk refund
    }
}
