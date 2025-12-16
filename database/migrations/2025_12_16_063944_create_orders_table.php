<?php
// database/migrations/xxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Nomor order unik (contoh: ORD-20241210-ABC123)
            $table->string('order_number', 50)->unique();

            // Total harga (termasuk ongkir)
            $table->decimal('total_amount', 15, 2);

            // Ongkos kirim
            $table->decimal('shipping_cost', 12, 2)->default(0);

            // Status pesanan
            $table->enum('status', [
                'pending',      // Menunggu pembayaran
                'processing',   // Pembayaran diterima, sedang diproses
                'shipped',      // Sudah dikirim
                'delivered',    // Sudah diterima
                'cancelled'     // Dibatalkan
            ])->default('pending');

            // Alamat pengiriman (snapshot saat order)
            $table->string('shipping_name');
            $table->string('shipping_phone', 20);
            $table->text('shipping_address');

            // Metode pembayaran
            $table->string('payment_method')->nullable();

            // Catatan dari pembeli
            $table->text('notes')->nullable();

            $table->timestamps();

            // Index untuk query
            $table->index('order_number');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
