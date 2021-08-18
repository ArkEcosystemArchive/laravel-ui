@props ([
    'image',
    'imageHover',
    'class'     => null,
    'linkClass' => null,
    'url'       => '#',
])

<a
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    class="logo-simple {{ $linkClass }}"
>
    <div class="relative transition-default">
        <img src="{{ $image }}" class="logo-simple-image {{ $class }}" />

        <img
            src="{{ $imageHover }}"
            class="logo-simple-image-hover {{ $class }}"
        />
    </div>
</a>
