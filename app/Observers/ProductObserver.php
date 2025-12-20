<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use functions\activity;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Clear cache produk featured
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');

        // // Log activity
        activity()
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->log('Produk baru dibuat: ' . $product->name);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Clear related caches
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');

        // Jika kategori berubah
        if ($product->isDirty('category_id')) {
            Cache::forget('category_' . $product->getOriginal('category_id') . '_products');
            Cache::forget('category_' . $product->category_id . '_products');
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Clear caches
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');
    }
}
