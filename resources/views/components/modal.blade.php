@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div
    x-data="{ show: {{ $show ? 'true' : 'false' }} }"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-50"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div class="fixed inset-0 bg-black opacity-50" x-on:click="show = false"></div>

    <div class="relative mx-auto mt-20 w-full {{ $maxWidth }} bg-white p-6 shadow-lg">
        {{ $slot }}
    </div>
</div>
