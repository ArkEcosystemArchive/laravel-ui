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
    'colspan' => null,
    'type' => null,
])

@php
    $colour = [
        'success'   => 'text-theme-success-600',
        'failed'    => 'text-theme-danger-400',
        'error'     => 'text-theme-danger-400',
        'debug'     => 'text-theme-hint-500',
        'running'   => 'text-theme-warning-900',
        'updated'   => 'text-theme-warning-500',
        'active'    => 'text-theme-warning-900',
        'locked'    => 'text-theme-secondary-700',
        'emergency' => 'text-theme-danger-400',
        'alert'     => 'text-theme-danger-400',
        'critical'  => 'text-theme-danger-400',
        'warning'   => 'text-theme-warning-400',
        'notice'    => 'text-theme-hint-400',
        'info'      => 'text-theme-info-400',
        'none'      => '',
    ][$type ?? 'none'];
@endphp

<div class="flex font-semibold space-x-2 {{ $colour }}">
    <div>@lang('ui::status.'.$type)</div>

    <x-ark-status-circle :type="$type" />
</div>
