@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold text-dark mb-0">Daftar Produk</h4>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i>
            Tambah Produk
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row g-2 mb-4">

        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari produk..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-4">
            <select name="category" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-outline-primary btn-sm w-100 d-flex justify-content-center align-items-center gap-1">
                <i class="bi bi-funnel"></i>
                Filter
            </button>
        </div>

    </form>


    <div class="card border-0 shadow-sm">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center" width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}"
                                    class="rounded border" width="55">
                            </td>

                            <td class="fw-medium">{{ $product->name }}</td>

                            <td class="text-muted">{{ $product->category->name }}</td>

                            <td class="fw-semibold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.products.show', $product) }}"
                                    class="btn btn-sm btn-outline-info me-1">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Data produk kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <div class="mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

@endsection
