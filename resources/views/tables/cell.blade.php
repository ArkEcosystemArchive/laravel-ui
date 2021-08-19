@props([
    'breakpoint' => 'lg',
    'class'      => '',
    'colspan'    => null,
    // In wich screen sizes this column will be the first one  (`xl`, `lg`, etc)
    // (Only neccesary if the first column changes on responsive versions)
    'firstOn'    => null,
    // In wich screen sizes this column will be the last one (`xl`, `lg`, etc)
    // (Only neccesary if the last column changes on responsive versions)
    'lastOn'     => null,
    'responsive' => false,
])

<td {{ $attributes->merge([
    'class' =>
        'hoverable-cell'
        . ($responsive && !$breakpoint ? ' hidden lg:table-cell' : '')
        . ($responsive && $breakpoint === 'xl' ? ' hidden xl:table-cell' : '')
        . ($responsive && $breakpoint === 'lg' ? ' hidden lg:table-cell' : '')
        . ($responsive && $breakpoint === 'md' ? ' hidden md:table-cell' : '')
        . ($responsive && $breakpoint === 'sm' ? ' hidden sm:table-cell' : '')
        . ($lastOn === 'sm' ? ' last-cell last-cell-sm' : '')
        . ($lastOn === 'md' ? ' last-cell last-cell-md' : '')
        . ($lastOn === 'lg' ? ' last-cell last-cell-lg' : '')
        . ($lastOn === 'xl' ? ' last-cell last-cell-xl' : '')
        . ($firstOn === 'sm' ? ' first-cell first-cell-sm' : '')
        . ($firstOn === 'md' ? ' first-cell first-cell-md' : '')
        . ($firstOn === 'lg' ? ' first-cell first-cell-lg' : '')
        . ($firstOn === 'xl' ? ' first-cell first-cell-xl' : '')
        . ' ' . $class
]) }}
    @if ($colspan) colspan="{{ $colspan }}" @endif
>
    <div class="table-cell-bg"></div>
    <div class="table-cell-content">
        {{ $slot }}
    </div>
</td>
