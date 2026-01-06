<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Membuat Order baru dari Keranjang belanja.
     *
     * ALUR PROSES (TRANSACTION):
     * 1. Hitung total & Validasi Stok terakhir
     * 2. Buat Record Order (Header)
     * 3. Pindahkan Cart Items ke Order Items (Detail)
     * 4. Kurangi Stok Produk (Atomic Decrement)
     * 5. Hapus Keranjang
     */
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang User
        $cart = $user->cart;

        if (! $cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        // ==================== DATABASE TRANSACTION START ====================
        // Kita menggunakan DB::transaction untuk membungkus semua proses.
        // Jika ada 1 error saja (misal stok kurang saat mau decrement),
        // maka SEMUA query yang sudah jalan akan dibatalkan (Rollback).
        // Order tidak akan terbentuk setengah-setengah.
        return DB::transaction(function () use ($user, $cart, $shippingData) {
            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }
                $totalAmount += $item->product->discount_price * $item->quantity;
            }

            // B. BUAT HEADER ORDER
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone'   => $shippingData['phone'],
                'total_amount'     => $totalAmount,
            ]);

            // C. PINDAHKAN ITEMS
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->discount_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->product->discount_price * $item->quantity,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            // D. Pastikan relasi user di-load sebelum generate Snap Token
            $order->load('user');
            $midtransService = new \App\Services\MidtransService();
            try {
                $snapToken = $midtransService->createSnapToken($order);
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Jika gagal, biarkan snap_token tetap null, bisa di-handle di frontend
            }

            // E. BERSIHKAN KERANJANG
            $cart->items()->delete();
            // $cart->delete(); // opsional

            return $order;
        });
        // ==================== DATABASE TRANSACTION END ====================
    }
}
