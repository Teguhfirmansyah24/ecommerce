@props(['status'])

@php
    $classes = [
        'pending' => 'bg-warning text-dark',
        'processing' => 'bg-primary',
        'shipped' => 'bg-info',
        'delivered' => 'bg-success',
        'cancelled' => 'bg-danger',
    ];

    $class = $classes[$status] ?? 'bg-secondary';
@endphp

<span class="badge {{ $class }} px-3 py-2 rounded-pill fw-semibold shadow-sm">
    {{ ucfirst($status) }}
</span>
