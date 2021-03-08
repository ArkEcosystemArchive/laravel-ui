@props([
    'url',
    'text',
    'class'     => 'link font-semibold',
    'inline'    => false,
    'allowWrap' => false,
    'small'     => false,
])

<a
    href="{{ $url }}"
    class="{{ $class }} {{ $inline ? 'inline space-x-1' : 'flex items-center space-x-2' }} {{ $allowWrap ? '' : 'whitespace-nowrap' }}"
    target="_blank"
    rel="noopener nofollow noreferrer"
>
    <span>{{ $text }}</span>

    @svg('link', (($small ?? false) ? 'h-3 w-3' : 'h-4 w-4').' flex-shrink-0 '.(($inline ?? false) ? 'inline mr-1 -mt-1' : 'mr-2'))
</a>
