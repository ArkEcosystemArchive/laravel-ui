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
        'success' => 'text-theme-success-600',
        'failed'  => 'text-theme-danger-400',
        'error'   => 'text-theme-danger-400',
        'debug'   => 'text-theme-hint-500',
        'running' => 'text-theme-warning-900',
        'updated' => 'text-theme-warning-500',
        'active'  => 'text-theme-warning-900',
        'locked'  => 'text-theme-secondary-700',
        'none'    => '',
    ][$type ?? 'none'];
@endphp
{{-- 
@if ($type === 'success')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-success-600 {{ $containerSize }}">
        @svg('checkmark', 'text-theme-success-600 '.$size)
    </div>
@elseif ($type === 'failed' || $type === 'error')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-danger-400 {{ $containerSize }}">
        @svg('cross', 'text-theme-danger-400 '.$size)
    </div>
@elseif ($type === 'running')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-900 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-900 animation-spin '.$size)
    </div>
@elseif ($type === 'paused')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-500 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-500 '.$size)
    </div>
@elseif ($type === 'updated')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-900 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-900 '.$size)
    </div>
@elseif ($type === 'locked')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-secondary-700 {{ $containerSize }}">
        @svg('lock', 'text-theme-secondary-700 '.$size)
    </div>
@endif --}}

<div class="flex font-semibold space-x-2 {{ $colour }}">
    <div>@lang('ui::status.'.$type)</div>

    <x-ark-status-circle-shallow :type="$type" />
</div>