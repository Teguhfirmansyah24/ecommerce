{{-- ======================================== FILE:
resources/views/layouts/app.blade.php FUNGSI: Template utama yang digunakan
semua halaman ======================================== --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- ↑ str_replace mengganti underscore dengan dash Contoh: en_US menjadi
en-US --}}

<head>
    <meta charset="utf-8" />
    {{-- ↑ Encoding karakter UTF-8 untuk mendukung karakter Indonesia --}}

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- ↑ Membuat halaman responsive di semua ukuran layar --}}

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- ↑ CSRF Token untuk keamanan form Mencegah serangan Cross-Site Request
    Forgery --}}

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) {{-- ↑ Load file
    CSS dan JS yang sudah di-compile oleh Vite - app.scss berisi Bootstrap dan
    custom styles - app.js berisi Bootstrap JS dan custom scripts --}}

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>
    {{-- ============================================
         NAVBAR
         ============================================ --}}
    @include('partials.navbar')

    {{-- ============================================
         FLASH MESSAGES
         ============================================ --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- ============================================
         FOOTER
         ============================================ --}}
    @include('partials.footer')

    {{-- Stack untuk JS tambahan per halaman --}}
    @stack('scripts')

    <script>
        /**
         * Fungsi AJAX untuk Toggle Wishlist
         * Menggunakan Fetch API (Modern JS) daripada jQuery.
         */
        async function toggleWishlist(productId) {
            try {
                // 1. Ambil CSRF token dari meta tag HTML
                // Laravale mewajibkan token ini untuk setiap request POST demi keamanan.
                const token = document.querySelector('meta[name="csrf-token"]').content;

                // 2. Kirim Request ke Server
                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token, // Tempel token di header
                    },
                });

                // 3. Handle jika user belum login (Error 401 Unauthorized)
                if (response.status === 401) {
                    window.location.href = "/login"; // Lempar ke halaman login
                    return;
                }

                // 4. Baca respon JSON dari server
                const data = await response.json();

                if (data.status === "success") {
                    // 5. Update UI tanpa reload halaman
                    updateWishlistUI(productId, data.added); // Ganti warna ikon
                    updateWishlistCounter(data.count); // Update angka di header
                    showToast(data.message); // Tampilkan notifikasi
                }
            } catch (error) {
                console.error("Error:", error);
                showToast("Terjadi kesalahan sistem.", "error");
            }
        }

        function updateWishlistUI(productId, isAdded) {
            // Cari semua tombol wishlist untuk produk ini (bisa ada di card & detail page)
            const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);

            buttons.forEach((btn) => {
                const icon = btn.querySelector("i"); // Menggunakan tag <i> untuk Bootstrap Icons
                if (isAdded) {
                    // Ubah jadi merah solid (Love penuh)
                    icon.classList.remove("bi-heart", "text-secondary");
                    icon.classList.add("bi-heart-fill", "text-danger");
                } else {
                    // Ubah jadi abu-abu outline (Love kosong)
                    icon.classList.remove("bi-heart-fill", "text-danger");
                    icon.classList.add("bi-heart", "text-secondary");
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                // Bootstrap badge display toggle logic
                badge.style.display = count > 0 ? "inline-block" : "none";
            }
        }
    </script>
</body>

</html>
