@props(['active'])

@php
    $classes = $active
        ? 'nav-link nav-link-active'
        : 'nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
