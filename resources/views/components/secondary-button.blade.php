<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-2 bg-white border border-gray-300 text-gray-700']) }}>
    {{ $slot }}
</button>
