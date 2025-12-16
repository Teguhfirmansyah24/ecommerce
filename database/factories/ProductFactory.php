<?php
// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->words(rand(2, 5), true);
        $price = fake()->numberBetween(10000, 5000000);

        // 30% kemungkinan punya diskon
        $discountPrice = fake()->optional(0.3)->numberBetween(
            (int)($price * 0.5),  // min 50% dari harga
            (int)($price * 0.9)   // max 90% dari harga
        );

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(5),
            'description' => fake()->paragraphs(rand(2, 4), true),
            'price' => $price,
            'discount_price' => $discountPrice,
            'stock' => fake()->numberBetween(0, 100),
            'weight' => fake()->numberBetween(100, 5000),
            'is_active' => fake()->boolean(90),    // 90% aktif
            'is_featured' => fake()->boolean(15),   // 15% featured
        ];
    }

    /**
     * State untuk produk featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    /**
     * State untuk produk out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}
