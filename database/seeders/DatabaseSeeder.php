<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Customer
        User::factory()->create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
