<a
    href="{{ $url ?? '#' }}"
    target="_blank"
    rel="noopener noreferrer"
    class="logo-simple"
>
    <div class="relative transition-default">
        <img src="{{ $image }}" class="logo-simple-image {{ $class ?? '' }}" />

        <img
            src="{{ $imageHover }}"
            class="logo-simple-image-hover {{ $class ?? '' }}"
        />
    </div>
</a>
