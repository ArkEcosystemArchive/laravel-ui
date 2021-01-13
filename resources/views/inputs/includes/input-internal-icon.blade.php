@props([
    'icon',
    'position' => 'right',
    'iconClass' => '',
])

@php
    $positionClasses = [
        'left' => 'left-0 ml-3',
        'right' => 'right-0 mr-3',
        'base' => 'right-0 mr-3',
    ][$position];
@endphp

<div class="input-icon {{ $positionClasses }} {{ $iconClass }}">
    <x-ark-icon :name="$icon" />
</div>
