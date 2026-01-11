<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="fw-bold mb-1">Foto Profil</h5>
                <p class="text-muted small mb-0">
                    Gunakan foto yang jelas untuk identitas akun kamu.
                </p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.updateAvatar') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="d-flex align-items-center gap-4">

                {{-- Avatar Preview --}}
                <div class="position-relative">
                    <img id="avatar-preview" class="rounded-circle object-fit-cover border shadow-sm"
                        style="width: 110px; height: 110px;"
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                        alt="{{ $user->name }}">

                    @if ($user->avatar)
                        <button type="button"
                            onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                            class="btn btn-danger btn-sm rounded-circle position-absolute top-0 start-100 translate-middle p-1 shadow"
                            style="width: 26px; height: 26px; line-height: 1;" title="Hapus foto">
                            <i class="bi bi-x"></i>
                        </button>
                    @endif
                </div>

                {{-- Upload Area --}}
                <div class="grow">
                    <label class="form-label fw-semibold">Upload Foto Baru</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)"
                        class="form-control @error('avatar') is-invalid @enderror">

                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, WebP. Maksimal 2MB.
                    </small>

                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-1"></i> Simpan Foto
                </button>

                @if ($user->avatar)
                    <button type="button"
                        onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                        class="btn btn-outline-danger rounded-pill px-4">
                        <i class="bi bi-trash3 me-1"></i> Hapus
                    </button>
                @endif
            </div>
        </form>

    </div>
</div>

{{-- Hidden Form Delete Avatar --}}
<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];

        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>
