@props(['active'])

@php
    $classes = $active
        ? 'responsive-nav-link responsive-nav-link-active'
        : 'responsive-nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
