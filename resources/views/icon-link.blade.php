@props([
    'href',
    'slot',
    'hideIcon' => false,
    'rel'      => null,
    'target'   => '_self',
])

<a
    href="{{ $href }}"
    target="{{ $target }}"
    rel="{{ $rel }}"
    class="flex items-center space-x-2 font-semibold link"
>
    @if(! $hideIcon)
        <span>@svg('link', 'h-4 w-4')</span>
    @endif

    <span>{{ $slot }}</span>
</a>
