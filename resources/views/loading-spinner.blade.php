@props([
    'class'             => 'rounded',
    'dimensions'        => 'w-48 h-48',
    'spinnerDimensions' => 'w-20 h-20',
])

<div class="cursor-pointer flex items-center justify-center absolute top-0 opacity-90 transition-default bg-theme-secondary-900 {{ $dimensions }} {{ $class }}">
    @svg('oval', $spinnerDimensions.' text-white')
</div>
