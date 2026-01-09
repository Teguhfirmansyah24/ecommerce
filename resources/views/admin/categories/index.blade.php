@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold text-dark mb-0">Manajemen Kategori</h4>

        <button class="btn btn-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card border-0 shadow-sm">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kategori</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">

                                    @if ($category->image)
                                        <img src="{{ Storage::url($category->image) }}" class="rounded border me-3"
                                            width="44" height="44" style="object-fit:cover">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                            style="width:44px;height:44px">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        <small class="text-muted">{{ $category->slug }}</small>
                                    </div>

                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    {{ $category->products_count }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if ($category->is_active)
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">

                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $category->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Belum ada kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="card-footer bg-white">
            {{ $categories->links() }}
        </div>

    </div>


    @foreach ($categories as $category)
        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">

                <form class="modal-content border-0 shadow-sm" action="{{ route('admin.categories.update', $category) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h6 class="modal-title fw-semibold">Edit Kategori</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Aktif</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-dark">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endforeach


    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <form class="modal-content border-0 shadow-sm" action="{{ route('admin.categories.store') }}" method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h6 class="modal-title fw-semibold">Tambah Kategori</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Aktif</label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-dark">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
