{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     FUNGSI: Footer website (Enhanced UI)
     ================================================ --}}

@push('styles')
    <style>
        .footer-link {
            transition: color .2s ease, padding-left .2s ease;
        }

        .footer-link:hover {
            color: #ffffff !important;
            padding-left: .25rem;
        }

        .social-icon {
            transition: transform .2s ease, color .2s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            color: #ffffff !important;
        }
    </style>
@endpush

<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-bag-heart-fill text-primary fs-4"></i>
                    TokoOnline
                </h5>
                <p class="text-secondary small">
                    Toko online terpercaya dengan berbagai produk berkualitas.
                    Belanja mudah, aman, dan nyaman untuk semua kebutuhan Anda.
                </p>

                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5 social-icon">
                        <i class="bi bi-instagram"></i>
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
                <h6 class="text-white fw-semibold mb-3">Menu</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="text-secondary text-decoration-none footer-link">
                            Katalog Produk
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Tentang Kami
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Kontak
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
                            Cara Belanja
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none footer-link">
                            Kebijakan Privasi
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
                        <span>Jl. Rancamanyar No. 25 Bandung</span>
                    </li>
                    <li class="mb-2 d-flex">
                        <i class="bi bi-telephone me-2"></i>
                        <span>(022) 123-4567</span>
                    </li>
                    <li class="mb-2 d-flex">
                        <i class="bi bi-envelope me-2"></i>
                        <span>info@tokoonline.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary small mb-0">
                    &copy; {{ date('Y') }} TokoOnline. Semua hak dilindungi undang-undang.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="{{ asset('assets/images/logos/Laravel.png') }}" alt="Tech Stack" height="30"
                    class="opacity-75">
            </div>
        </div>
    </div>
</footer>
