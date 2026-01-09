<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
            font-size: 0.95rem;
            color: #212529;
        }

        .register-card {
            border: none;
            border-radius: 0.75rem;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.9rem;
        }

        .muted-link {
            color: #6c757d;
        }

        .muted-link:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12">

                <div class="card register-card">
                    <div class="card-header bg-white text-center py-3 border-bottom">
                        <h5 class="fw-semibold mb-1">
                            <i class="bi bi-person-plus-fill me-1"></i>Register
                        </h5>
                        <small class="text-muted">Buat akun baru untuk melanjutkan</small>
                    </div>

                    <div class="card-body px-4 py-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>

                        {{-- Divider --}}
                        <div class="position-relative my-3">
                            <hr>
                            <span
                                class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">
                                atau daftar dengan
                            </span>
                        </div>

                        {{-- Google Register --}}
                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18"
                                    class="me-2">
                                Daftar dengan Google
                            </a>
                        </div>

                        {{-- Link login --}}
                        <p class="text-center mb-2 small">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                                Login
                            </a>
                        </p>

                        {{-- Kembali ke home --}}
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="small muted-link text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
