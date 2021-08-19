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
    'type'       => null,
])

@php
    $colours = [
        'success'   => 'bg-theme-success-50 text-theme-success-400',
        'failed'    => 'bg-theme-danger-50 text-theme-danger-400',
        'error'     => 'bg-theme-danger-50 text-theme-danger-400',
        'debug'     => 'bg-theme-hint-50 text-theme-hint-500',
        'running'   => 'bg-theme-warning-50 text-theme-warning-400',
        'updated'   => 'bg-theme-warning-50 text-theme-warning-400',
        'active'    => 'bg-theme-primary-50 text-theme-primary-400',
        'locked'    => 'bg-theme-secondary-50 text-theme-secondary-400',
        'emergency' => 'bg-theme-danger-50 text-theme-danger-400',
        'alert'     => 'bg-theme-danger-50 text-theme-danger-400',
        'critical'  => 'bg-theme-danger-50 text-theme-danger-400',
        'warning'   => 'bg-theme-warning-50 text-theme-warning-400',
        'notice'    => 'bg-theme-hint-50 text-theme-hint-400',
        'info'      => 'bg-theme-info-50 text-theme-info-400',
        'none'      => '',
    ][$type ?? 'none'];
@endphp

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
    <div>
        <div class="flex items-center space-x-2 font-semibold px-4 py-3 -mx-3 -my-4 {{ $colours }}">
            <x-ark-status-circle-shallow :type="$type" />

            <div>@lang('ui::status.'.$type)</div>
        </div>
    </div>
</td>
