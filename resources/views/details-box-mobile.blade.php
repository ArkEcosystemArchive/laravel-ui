@props([
    'slot',
    'title'
    'icon'       => null,
    'iconRaw'    => null,
    'iconClass'  => ''
    'titleClass' => 'w-32'
])

<div class="flex justify-between">
    <div class="{{ $titleClass }}">{{ $title }}</div>

    <div class="flex items-center space-x-3">
        <div>{{ $slot }}</div>

        @if ($icon)
            <x-ark-icon :name="$icon" class="{{ $iconClass }}" />
        @elseif ($iconRaw)
            {{ $iconRaw }}
        @endif
    </div>
</div>
