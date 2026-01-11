{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     TEMA: Footer Toko Jam Tangan (Premium Edition)
     ================================================ --}}

<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-watch text-warning fs-4"></i>
                    TEGUH WATCH
                </h5>
                <p class="text-secondary small">
                    Teguh Watch menghadirkan jam tangan pilihan dengan desain elegan,
                    presisi tinggi, dan kualitas premium. Waktu Anda berharga, dan
                    kami pastikan setiap detiknya tampil berkelas.
                </p>

                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="text-secondary text-decoration-none footer-link">
                            Koleksi Jam
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Tentang Brand
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Promo & Diskon
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Bantuan</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            FAQ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Cara Pemesanan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Garansi Produk
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white fw-semibold mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled text-secondary small">
                    <li class="mb-2 d-flex">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span>Jl. Rancamanyar No. 88, Bandung</span>
                    </li>
                    <li class="mb-2 d-flex">
                        <i class="bi bi-telephone me-2"></i>
                        <span>+62 812 3456 7890</span>
                    </li>
                    <li class="mb-2 d-flex">
                        <i class="bi bi-envelope me-2"></i>
                        <span>support@Teguhwatch.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary small mb-0">
                    &copy; {{ date('Y') }} TeguhWatch. Jam tangan premium untuk gaya hidup berkelas.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Tech Stack" height="30"
                    class="opacity-75">
            </div>
        </div>
    </div>
</footer>
