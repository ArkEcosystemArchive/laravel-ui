@if($url ?? false)
    <a
        href="{{ $url ?? '#' }}"
        target="_blank"
        rel="noopener noreferrer"
        class="{{ $wrapperClass ?? 'justify-center' }} logo-entry"
        @if($tooltip ?? false)
            data-tippy-content="{{ $tooltip }}"
        @endif
    >
@else
    <div
        class="{{ $wrapperClass ?? 'justify-center' }} cursor-pointer logo-entry"
        @if($tooltip ?? false)
            data-tippy-content="{{ $tooltip }}"
        @endif
    >
@endif

    <div class="flex items-center justify-center flex-1 {{ $containerClass ?? 'p-5' }}">
        <div class="relative flex items-center justify-center {{ $imageContainerClass ?? '' }} transition-default">
            @if($image ?? false)
                <img
                    class="logo-entry-image"
                    src="{{ $image }}"
                />
            @else
                <div class="logo-entry-image">{{ $logo }}</div>
            @endif

            @if($imageHover ?? false)
                <img
                    class="logo-entry-image-hover"
                    src="{{ $imageHover }}"
                />
            @elseif($logoHover ?? false)
                <div class="logo-entry-image-hover">{{ $logoHover }}</div>
            @endif
        </div>

        @if($slot ?? false)
            {{ $slot }}
        @endif
    </div>

@if($url ?? false)
    </a>
@else
    </div>
@endif
