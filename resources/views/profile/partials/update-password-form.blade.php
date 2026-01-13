<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="fw-bold mb-1">Keamanan Akun</h5>
                <p class="text-muted small mb-0">
                    Gunakan password yang kuat untuk melindungi akun kamu.
                </p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.password.update') }}">
            @csrf
            @method('put')

            {{-- Current Password --}}
            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold">
                    Password Saat Ini
                </label>
                <input type="password" name="current_password" id="current_password"
                    class="form-control rounded-3 @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password" placeholder="Masukkan password lama">

                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Password Baru
                </label>
                <input type="password" name="password" id="password"
                    class="form-control rounded-3 @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password" placeholder="Minimal 8 karakter">

                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">
                    Konfirmasi Password Baru
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control rounded-3 @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password" placeholder="Ulangi password baru">

                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-lock-fill me-1"></i> Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success small fade-out">
                        <i class="bi bi-check-circle me-1"></i> Password berhasil diperbarui
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
