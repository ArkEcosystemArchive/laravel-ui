@props([
    'responsive' => false,
    'breakpoint' => 'lg',
    // Set to true for the first column.
    // Only needed if the first column dissapears in resposive versions
    'first' => false,
    // In wich screen sizes this column will be the first one
    // Expects breakpoints as string `xl`, `lg`, etc
    'firstOn' => null,
    // Set to true for the last column.
    // Only needed if the last column dissapears in resposive versions
    'last' => false,
    // In wich screen sizes this column will be the last one
    // Expects breakpoints as string `xl`, `lg`, etc
    'lastOn' => null,
    'class' => '',
])

<td {{ $attributes->merge([
    'class' =>
        't-cell'
        . ($responsive ? ' ' . $breakpoint . ':table-cell hidden' : '')
        . ($last || $lastOn ? (' last-cell' . (is_string($lastOn) ? ' last-cell-' . $lastOn : '')) : '')
        . ($first || $firstOn ? (' first-cell' . (is_string($firstOn) ? ' first-cell-' . $firstOn : '')) : '')
        . ' ' . $class
]) }}>
    <div class="relative flex items-center w-full h-full px-3 py-4">
        {{ $slot }}
    </div>
</td>
