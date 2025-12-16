<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    // Kolom yang disembunyikan saat serialisasi ke JSON/arry
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data otomatis
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi

    // User memiliki satu keranjang aktif
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // User memiliki banyak item whishlist
    public function wishlishts()
    {
        return $this->hasMany(Wishlist::class);
    }

    // User memiliki banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi many-to-many ke products melalui wishlists
    public function wishlistsProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }

    // Helper Method

    // Cek apakah user admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user customer
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // Cek apakah produk ada di wishlists user
    public function hasInWishlists(Product $product): bool
    {
        return $this->wishlists()->where('product_id', $product->id)->exists();
    }
}
