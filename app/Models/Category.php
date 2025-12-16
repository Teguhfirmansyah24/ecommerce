<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Boot Method
    protected static function boot()
    {
        parent::boot();

        // Event "creating" dipanggil sebelum model disimpan (baru)
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Event "updating" dipanggil sebelum model diupdate
        static::updating(function ($category) {
            // Jika nama berubah, update slug juga
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relasi

    // Kategori memiliki banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Hanya produk aktif dan tersedia
    public function activeProducts()
    {
        return $this->hasMany(Product::class)
                    ->where('is_active', true)
                    ->where('stock', '>', 0);
    }

    // Scope

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors

    // Hitung jumlah produk aktif dalam kategori
    public function getProductCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }

    // URL gambar kategori atau placeholder
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/category-placeholder.png');
    }
}
