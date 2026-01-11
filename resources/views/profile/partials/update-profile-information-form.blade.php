<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="fw-bold mb-1">Informasi Profil</h5>
                <p class="text-muted small mb-0">
                    Perbarui data akun yang digunakan untuk transaksi dan komunikasi.
                </p>
            </div>
            <i class="bi bi-person-badge fs-3 text-secondary"></i>
        </div>

        <form id="send-verification" method="post" action="">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" id="name"
                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                    placeholder="Nama lengkap kamu">

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control rounded-3 @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required autocomplete="username"
                    placeholder="email@domain.com">

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <div class="alert alert-warning py-2 px-3 small mb-1 rounded-3">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Email kamu belum diverifikasi.

                            <button form="send-verification"
                                class="btn btn-link p-0 align-baseline text-decoration-none fw-semibold">
                                Kirim ulang verifikasi
                            </button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success py-2 px-3 small rounded-3">
                                <i class="bi bi-check-circle me-1"></i>
                                Link verifikasi baru telah dikirim.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Phone --}}
            <div class="mb-3">
                <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                <input type="tel" name="phone" id="phone"
                    class="form-control rounded-3 @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx atau +628xxxxxxxxxx">

                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="form-text">
                    Digunakan untuk konfirmasi pesanan dan pengiriman.
                </div>
            </div>

            {{-- Address --}}
            <div class="mb-3">
                <label for="address" class="form-label fw-semibold">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3"
                    class="form-control rounded-3 @error('address') is-invalid @enderror" placeholder="Alamat lengkap untuk pengiriman">{{ old('address', $user->address) }}</textarea>

                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success small fade-out">
                        <i class="bi bi-check-circle me-1"></i> Profil berhasil diperbarui
                    </span>

                    <script>
                        setTimeout(() => {
                            const el = document.querySelector('.fade-out');
                            if (el) el.style.display = 'none';
                        }, 2500);
                    </script>
                @endif
            </div>

        </form>

    </div>
</div>
