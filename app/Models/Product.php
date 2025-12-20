<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Boot
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug yang UNIK saat creating
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $counter = 1;

                // Loop cek apakah slug sudah dipakai?
                // Jika ya, tambahkan angka (contoh: produk-1, produk-2)
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $product->slug = $slug;
            }
        });
    }

    // Relasi

    // Produk termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Produk memiliki banyak gambar
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Gambar utama produk
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Fallback Image: Jika tidak ada image primary, ambil yang paling tua/pertama diupload.
     */
    public function firstImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->oldestOfMany('sort_order');
    }

    // Item pesanan yang mengandung produk ini
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistedBy(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // Accessors

    // Harga yang di tampilkan (diskon atau normal)
    public function getDisplayPriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    // Format harga untuk tampilan
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->display_price, 0, ',', '.');
    }

    // Format harga asli (sebelum diskon)
    public function getFormattedOriginalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Presentasi diskon
    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    // Cek apakah produk memiliki diskon
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null
            && $this->discount_price < $this->price;
    }

    // URL gambar utama atau placeholder
    public function getImageUrlAttribute(): string
    {
        if ($this->primaryImage) {
            return $this->primaryImage->image_url;
        }
        return asset('images/no-image.png');
    }

    // Cek apakah produk tersedia (aktif dan ada stok)
    public function getIsAvailableAttribute(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    public function getStockLabelAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Habis';
        } elseif ($this->stock <= 5) {
            return 'Sisa ' . $this->stock;
        }
        return 'Tersedia';
    }

    public function getStockBadgeColorAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'danger';
        } elseif ($this->stock <= 5) {
            return 'warning';
        }
        return 'success';
    }

    public function getFormattedWeightAttribute(): string
    {
        if ($this->weight >= 1000) {
            return number_format($this->weight / 1000, 1) . ' kg';
        }
        return $this->weight . ' gram';
    }

    // Scopes

    // Filter produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Filter produk unggulan
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Filter produk yang tersedia (ada stok)
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeAvailable($query)
    {
        return $query->active()->inStock();
    }

    // Filter berdasarkan kategori (menggunakan slug)
    public function scopeByCategory($query, string $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeInCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Pencariian produk
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // Filter berdasarkan range harga
    public function scopePriceRange($query, float $min, float $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeMinPrice($query, float $min)
    {
        return $query->where('price', '>=', $min);
    }

    public function scopeMaxPrice($query, float $max)
    {
        return $query->where('price', '<=', $max);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price');
    }

    public function scopeSortBy($query, ?string $sort)
    {
        return match ($sort) {
            'newest' => $query->latest(),
            'oldest' => $query->oldest(),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'popular' => $query->withCount('orderItems')->orderByDesc('order_items_count'),
            default => $query->latest(),
        };
    }

     // ==================== HELPER METHODS ====================

    /**
     * Kurangi stok atomik (thread-safe).
     */
    public function decrementStock(int $quantity): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }

        $this->decrement('stock', $quantity); // Query langsung: UPDATE products SET stock = stock - X
        return true;
    }

    public function incrementStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }
}
