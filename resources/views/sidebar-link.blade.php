@props([
    'name',
    'attributes' => [],
    'icon'       => null,
    'href'       => null,
    'params'     => [],
    'route'      => null,
])

@php ($isCurrent = $route && url()->full() === route($route, $params))

<div class="flex">
    <div @class([
        'w-2 -mr-1 z-10',
        'bg-theme-primary-600 rounded-xl' => $isCurrent,
    ])></div>

    <a
        @if ($href)
            href="{{ $href }}"
        @else
            href="{{ route($route, $params) }}"
        @endif
        @class([
            'flex items-center block font-semibold pl-8 py-3 space-x-2 rounder-r w-full',
            'text-theme-primary-600 bg-theme-primary-100'           => $isCurrent,
            'text-theme-secondary-900 hover:text-theme-primary-600' => ! $isCurrent,
        ])
        dusk='navbar-item-{{ Str::slug($name) }}'
        @foreach($attributes as $attribute => $attributeValue)
            {{ $attribute }}="{{ $attributeValue }}"
        @endforeach
    >
        <span>{{ $name }}</span>

        @if ($icon)
            <x-ark-icon class="text-theme-primary-600" size="sm" :name="$icon" />
        @endif
    </a>
</div>
