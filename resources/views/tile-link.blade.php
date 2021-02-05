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
            {{-- 'hidden': {{ $index }} > 6,
            'sm:hidden': {{ $index }} > 7,
            'md:hidden': {{ $index }} > 6,
            'lg:hidden': {{ $index }} > 8,
            'xl:hidden': {{ $index }} > 10, --}}
        }"
    @endif

    {{-- @if ($mobileHidden || $desktopHidden)
        x-bind:class="{
            @if ($mobileHidden && $desktopHidden)
                'hidden': mobileHidden && desktopHidden,
                'hidden sm:block': mobileHidden && ! desktopHidden,
                'block sm:hidden': ! mobileHidden && desktopHidden,
            @elseif ($mobileHidden)
                'hidden sm:block': mobileHidden,
            @else
                'sm:hidden': desktopHidden,
            @endif
        }"
    @endif --}}
>
    <div class="flex flex-col justify-center items-center space-y-2 h-full font-semibold">
        @if ($option['icon'] ?? false)
            <x-ark-icon :name="$option['icon']" size="md" />
        @endif

        <div>{{ $option['title'] }}</div>
    </div>
</a>
