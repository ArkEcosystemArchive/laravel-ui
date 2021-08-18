@props([
    'image',
    'slot',
    'url',
    'isExternal' => false,
])

<a
    href="{{ $url }}"
    class="image-tile"
    @if($isExternal)
        target="_blank"
        rel="noopener nofollow noreferrer"
    @endif
>
    <img src="{{ $image }}" class="w-3/4" />
    <span class="mt-4 font-semibold text-center text-theme-secondary-900">{{ $slot }}</span>
</a>
