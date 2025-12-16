<?php
// database/migrations/xxxx_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // Restrict delete: jangan hapus produk kalau ada di order
            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            // Snapshot data produk saat order
            // (karena harga/nama produk bisa berubah di kemudian hari)
            $table->string('product_name');
            $table->decimal('price', 12, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
