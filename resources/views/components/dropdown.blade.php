@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

@php
    $alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';

    if ($align == 'left') {
        $alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
    }

    if ($align == 'top') {
        $alignmentClasses = 'origin-top';
    }

    if ($width == '48') {
        $width = 'w-48';
    }
@endphp

<details class="relative">
    <summary style="list-style: none; cursor: pointer;">
        {{ $trigger }}
    </summary>

    <div class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</details>
