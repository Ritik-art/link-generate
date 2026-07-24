@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-300 px-3 py-2']) }}>
