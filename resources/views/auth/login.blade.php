{{-- ======================================== FILE:
resources/views/auth/login.blade.php FUNGSI: Halaman form login
======================================== --}} @extends('layouts.app') {{-- ↑
Menggunakan layout dari layouts/app.blade.php Halaman ini akan "masuk" ke bagian
@yield('content') --}} @section('content')
    {{-- ↑ Mulai section yang akan
ditampilkan di @yield('content') --}}

    <div class="container">
        <div class="row justify-content-center">
            {{-- ↑ justify-content-center = posisikan di tengah horizontal --}}

            <div class="col-md-6">
                {{-- ↑ col-md-6 = lebar 50% di layar medium ke atas --}}

                <div class="card shadow-sm">
                    {{-- Card Header --}}
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">🔐 Login ke Akun Anda</h4>
                    </div>

                    <div class="card-body p-4">
                        {{-- ================================================ FORM LOGIN
          ================================================ method="POST" = Kirim
          data secara aman (tidak terlihat di URL) action = URL tujuan submit
          form ================================================ --}}
                        <form method="POST" action="{{ route('login') }}">
                            {{-- ================================================ CSRF TOKEN
            ================================================ @csrf WAJIB ada di
            setiap form POST/PUT/DELETE Ini adalah proteksi keamanan dari
            Laravel ================================================ --}} @csrf
                            {{-- ================== FIELD EMAIL ================== --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>

                                <input id="email" type="email"
                                    class="form-control @error('email')
              is-invalid @enderror"
                                    {{-- ↑ @error('email') = jika ada error pada
              field email, tambahkan class 'is-invalid' untuk styling merah --}} name="email" value="{{ old('email') }}" {{-- ↑ old('email') = isi
              kembali nilai sebelumnya jika form gagal validasi --}}
                                    required autocomplete="email" autofocus placeholder="nama@email.com">
                                {{--
              Tampilkan pesan error jika ada --}} @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- ================== FIELD PASSWORD ================== --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>

                                <input id="password" type="password" {{--
                ↑
                type="password"
                ="karakter"
                akan
                disembunyikan
                (●●●●)
                --}}
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="••••••••" />

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- ================== CHECKBOX REMEMBER ME ================== --}}
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}> {{-- ↑ Jika
              sebelumnya dicentang, tetap centang --}}

                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            {{-- ↑ "Ingat Saya" = Simpan session lebih lama (tidak logout
            otomatis) --}} {{-- ================== TOMBOL SUBMIT
            ================== --}}
                            <div class="d-grid gap-2">
                                {{-- ↑ d-grid = display grid, membuat button full width --}}
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Login
                                </button>
                            </div>

                            {{-- ================== LINK LUPA PASSWORD ================== --}}
                            <div class="mt-3 text-center">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <hr />
                            {{-- ↑ Garis pemisah --}} {{-- ================== SOCIAL LOGIN
            ================== --}} {{-- Tombol ini akan diaktifkan di Hari 4
            --}}
                            <div class="d-grid gap-2">
                                <a href="{{ route('auth.google') }}" class="btn btn-outline-danger">
                                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20"
                                        class="me-2" />
                                    Login dengan Google
                                </a>
                            </div>

                            {{-- ================== LINK REGISTER ================== --}}
                            <p class="mt-4 text-center mb-0">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection {{-- ↑ Akhir dari section content --}}
