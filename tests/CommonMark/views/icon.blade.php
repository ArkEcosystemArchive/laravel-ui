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

<svg wire:key="GfLVwv0b" class="fill-current w-4 h-4 inline ml-1 -mt-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
