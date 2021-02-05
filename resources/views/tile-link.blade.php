@props([
    'id',
    'option',
])

<a
    wire:key="tile-link-{{ $option['id'] }}"
    url="{{ $option['url'] ?? '' }}"
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
        @if ($option['icon'] ?? false)
            <x-ark-icon :name="$option['icon']" size="md" />
        @endif

        <div>{{ $option['title'] }}</div>
    </div>
</a>
