@props([
    'name',
    'size' => 'base',
    'style' => '',
    'class' => ''
])
@php
    $availableSizes = ['2xs', 'xs', 'sm', 'md', 'lg', 'xl', '2xl', 'base'];

    if (in_array($size, $availableSizes) || empty($size)) {
        $size = [
            '2xs'  => 'w-2 h-2 ',
            'xs'   => 'w-3 h-3 ',
            'sm'   => 'w-4 h-4 ',
            'md'   => 'w-6 h-6 ',
            'lg'   => 'w-8 h-8 ',
            'xl'   => 'w-12 h-12 ',
            '2xl'  => 'w-14 h-14 ',
            'base' => 'w-5 h-5 ',
        ][$size ?? 'base'];
    }

    if (!empty($style)) {
        $style = [
            'secondary' => 'text-theme-secondary-500 ',
            'success'   => 'text-theme-success-500 ',
            'danger'    => 'text-theme-danger-500 ',
        ][$style];
    }
@endphp

@svg($name, $size . $style . $class, ['wire:key' => Str::random(8)])
