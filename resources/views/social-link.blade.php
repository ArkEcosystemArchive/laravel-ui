@props([
    'iconSize' => '4',
    'url',
    'icon',
])

<a
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    class="transition-default hover:text-theme-secondary-500"
>
    @svg($icon, sprintf('w-%s h-%s', $iconSize, $iconSize))
</a>
