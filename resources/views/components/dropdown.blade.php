@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'dropdown-panel'])

@php
    $alignmentClasses = 'dropdown-panel-right';

    if ($align == 'left') {
        $alignmentClasses = 'dropdown-panel-left';
    }

    if ($align == 'top') {
        $alignmentClasses = 'dropdown-panel-top';
    }

    if ($width == '48') {
        $width = 'dropdown-panel-width';
    }
@endphp

<details class="dropdown">
    <summary style="list-style: none; cursor: pointer;">
        {{ $trigger }}
    </summary>

    <div class="{{ $width }} {{ $alignmentClasses }}">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</details>
