@props([
    'url',
    'text',
    'class'     => 'link font-semibold inline break-all',
    'small'     => false,
    'noIcon'    => false,
])

<a
    href="{{ $url }}"
    class="{{ $class }}"
    target="_blank"
    rel="noopener nofollow noreferrer"
>
    <span>{{ isset($slot) && trim($slot) ? $slot : $text }}</span>

    @unless($noIcon)
        <x-ark-icon
            name="link"
            :size="$small ? 'xs' : 'sm'"
            :class="'flex-shrink-0 inline relative ml-0.5 ' . ($small ? '-top-1 -mt-0.5' : '-mt-1.5')"
        />
    @endunless
</a>
