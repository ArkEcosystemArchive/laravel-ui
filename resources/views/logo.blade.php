@props ([
    'image'               => null,
    'imageHover'          => null,
    'containerClass'      => 'p-5',
    'imageContainerClass' => null,
    'logo'                => null,
    'logoHover'           => null,
    'slot'                => null
    'tooltip'             => null,
    'url'                 => null,
    'wrapperClass'        => 'justify-center',
])

@if($url)
    <a
        href="{{ $url }}"
        target="_blank"
        rel="noopener noreferrer"
        class="{{ $wrapperClass }} logo-entry"
        @if($tooltip)
            data-tippy-content="{{ $tooltip }}"
        @endif
    >
@else
    <div
        class="{{ $wrapperClass }} cursor-pointer logo-entry"
        @if($tooltip)
            data-tippy-content="{{ $tooltip }}"
        @endif
    >
@endif

    <div class="flex items-center justify-center flex-1 {{ $containerClass }}">
        <div class="relative flex items-center justify-center {{ $imageContainerClass }} transition-default">
            @if($image)
                <img
                    class="logo-entry-image"
                    src="{{ $image }}"
                />
            @else
                <div class="logo-entry-image">{{ $logo }}</div>
            @endif

            @if($imageHover)
                <img
                    class="logo-entry-image-hover"
                    src="{{ $imageHover }}"
                />
            @elseif($logoHover)
                <div class="logo-entry-image-hover">{{ $logoHover }}</div>
            @endif
        </div>

        @if($slot)
            {{ $slot }}
        @endif
    </div>

@if($url)
    </a>
@else
    </div>
@endif
