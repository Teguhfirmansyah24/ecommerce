<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
            font-size: 0.95rem;
            color: #212529;
        }

        .login-card {
            border: none;
            border-radius: 0.75rem;
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
            <div class="col-md-9 col-lg-6">

                <div class="card login-card shadow-sm">
                    <div class="card-header bg-white text-center py-3">
                        <h5 class="fw-semibold mb-1">
                            <i class="bi bi-lock-fill me-1"></i>Login
                        </h5>
                        <small class="text-muted">Silakan masuk untuk melanjutkan</small>
                    </div>

                    <div class="card-body px-4 py-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="nama@email.com" required autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                    required>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="small muted-link text-decoration-none">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </form>

                        <hr class="my-3">

                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18"
                                    class="me-2">
                                Login dengan Google
                            </a>
                        </div>

                        <p class="text-center mb-2 small">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                                Daftar
                            </a>
                        </p>

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
