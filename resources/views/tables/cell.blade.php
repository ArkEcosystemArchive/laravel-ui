@props([
    'responsive' => false,
    'breakpoint' => 'lg',
    // In wich screen sizes this column will be the first one  (`xl`, `lg`, etc)
    // (Only neccesary if the first column changes on responsive versions)
    'firstOn' => null,
    // In wich screen sizes this column will be the last one (`xl`, `lg`, etc)
    // (Only neccesary if the last column changes on responsive versions)
    'lastOn' => null,
    'class' => '',
])

<td {{ $attributes->merge([
    'class' =>
        $class . ' t-cell'
        . ($responsive ? ' ' . $breakpoint . ':table-cell hidden' : '')
        . ($lastOn ? ' last-cell last-cell-' . $lastOn : '')
        . ($firstOn ? ' first-cell first-cell-' . $firstOn : '')
]) }}>
    <div>
        {{ $slot }}
    </div>
</td>
