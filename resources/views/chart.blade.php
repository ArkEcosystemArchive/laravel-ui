@props([
    'currency',
    'data',
    'id',
    'labels',
    'canvasClass' => '',
    'grid'        => false,
    'height'      => '500',
    'theme'       => collect(['name' => 'grey', 'mode' => 'light']),
    'tooltips'    => false,
    'width'       => '1000',
])

<div
    x-data="CustomChart(
        '{{ $id }}',
        {{ $data }},
        {{ $labels }},
        '{{ $grid }}',
        '{{ $tooltips }}',
        {{ $theme }},
        '{{ time() }}',
        '{{ $currency }}',
    )"
    x-init="init"
    @stats-period-updated.window="updateChart"
    wire:key="{{ $id.time() }}"
    {{ $attributes->only('class') }}
>
    <div wire:ignore class="relative w-full h-full">
        <canvas
            x-ref="{{ $id }}"
            @if($canvasClass) class="{{ $canvasClass }}" @endif
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
        ></canvas>
    </div>
</div>
