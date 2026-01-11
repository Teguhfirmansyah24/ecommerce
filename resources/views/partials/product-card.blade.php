@props(['product'])

<div class="card h-100 border-0 shadow-sm product-card">

    <div class="position-relative overflow-hidden bg-light product-image-wrapper">
        <img src="{{ $product->image_url }}" class="card-img-top w-100 h-100 object-fit-cover">

        @if ($product->has_discount)
            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    <div class="card-body d-flex flex-column">
        <small class="text-muted">{{ $product->category->name }}</small>

        <h6 class="fw-semibold mt-1">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-dark text-decoration-none stretched-link">
                {{ $product->name }}
            </a>
        </h6>

        <div class="mt-auto d-flex justify-content-between align-items-center">

            <div>
                @if ($product->has_discount)
                    <span class="fw-bold text-danger">{{ $product->formatted_price }}</span><br>
                    <small class="text-muted text-decoration-line-through">
                        {{ $product->formatted_original_price }}
                    </small>
                @else
                    <span class="fw-bold text-primary">{{ $product->formatted_price }}</span>
                @endif
            </div>

            <button onclick="toggleWishlist({{ $product->id }})"
                class="btn btn-light btn-sm rounded-circle wishlist-btn-{{ $product->id }}">
                <i
                    class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product)
                        ? 'bi-heart-fill text-danger'
                        : 'bi-heart text-secondary' }} fs-5"></i>
            </button>

        </div>
    </div>
</div>
