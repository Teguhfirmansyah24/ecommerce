<?php
// database/migrations/xxxx_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // User yang login (nullable untuk guest)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // Session ID untuk guest checkout
            $table->string('session_id')->nullable();

            $table->timestamps();

            // Index untuk query cepat
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
