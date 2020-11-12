<td {{ $attributes->merge([
    'class' =>
        't-cell'
        . (!empty($responsive) ? ' ' . ($breakpoint ?? 'lg').':table-cell hidden' : '')
        . (!empty($last) || !empty($lastOn) ? (' last-cell' . (!empty($lastOn) ? ' last-cell-' . $lastOn : '')) : '')
        . (isset($attributes['class']) ? ' ' . $attributes['class'] : '')
]) }}>
    <div class="relative flex items-center w-full h-full px-3 py-4">
        {{ $slot }}
    </div>
</td>
