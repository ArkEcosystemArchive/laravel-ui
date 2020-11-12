@props([
    'responsive' => false,
    'breakpoint' => 'lg',
    'last' => false,
    'lastOn' => null,
    'class' => '',
])

<td {{ $attributes->merge([
    'class' =>
        't-cell'
        . ($responsive ? ' ' . $breakpoint . ':table-cell hidden' : '')
        . ($last || $lastOn ? (' last-cell' . (is_string($lastOn) ? ' last-cell-' . $lastOn : '')) : '')
        . ' ' . $class
]) }}>
    <div class="relative flex items-center w-full h-full px-3 py-4">
        {{ $slot }}
    </div>
</td>
