<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/sapa/{nama}', function ($nama) {
    return "Halo $nama! Selamat datang di toko saya";
});

Route::get('/kategori/{nama}', function ($nama = 'semua') {
    return "Menampilkan Kategori $nama";
});

Route::get('/produk/{id}', function ($id) {
    return "Detail produk #$id";
})->name('produk.detail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
