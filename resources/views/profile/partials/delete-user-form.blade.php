<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="fw-bold text-danger mb-1">Hapus Akun</h5>
                <p class="text-muted small mb-0">
                    Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                </p>
            </div>
            <i class="bi bi-exclamation-triangle-fill text-danger fs-3"></i>
        </div>

        <div class="alert alert-danger bg-danger bg-opacity-10 border-0 small mb-4">
            <strong>Perhatian:</strong> Setelah akun dihapus, seluruh data, pesanan, dan riwayat aktivitas akan
            dihapus secara permanen. Pastikan kamu sudah mengunduh data penting.
        </div>

        <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal"
            data-bs-target="#confirmUserDeletionModal">
            <i class="bi bi-trash3 me-1"></i> Hapus Akun
        </button>

    </div>
</div>

<!-- MODAL KONFIRMASI -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('delete')

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger">
                    Konfirmasi Penghapusan Akun
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">

                <p class="text-muted small mb-3">
                    Masukkan password kamu untuk memastikan bahwa ini adalah keputusan yang disengaja.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                        placeholder="Masukkan password kamu" required>

                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="submit" class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-trash3 me-1"></i> Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->userDeletion->isNotEmpty())
    <script type="module">
        const modal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        modal.show();
    </script>
@endif
