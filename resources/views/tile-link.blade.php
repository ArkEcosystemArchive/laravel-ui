@props([
    'id',
    'link',
])

<a
    wire:key="tile-link-{{ $link['id'] }}"
    url="{{ $link['url'] ?? '' }}"
    class="tile-link"
    data-index="{{ $index }}"
    @if ($index >= 7)
        x-bind:class="{
            @if ($index == 7)
                'hidden sm:block md:hidden lg:block': linksHidden,
            @elseif ($index == 8)
                'hidden lg:block': linksHidden,
            @elseif ($index == 9 || $index == 10)
                'hidden xl:block': linksHidden,
            @else
                'hidden': linksHidden,
            @endif
        }"
    @endif
>
    <div class="flex flex-col justify-center items-center space-y-2 h-full font-semibold">
        @if ($link['icon'] ?? false)
            <x-ark-icon :name="$link['icon']" size="md" />
        @endif

        <div>{{ $link['title'] }}</div>
    </div>
</a>
