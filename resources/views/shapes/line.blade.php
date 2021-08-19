@props([
    'colorClass'   => 'bg-theme-secondary-200',
    'sizeClass'    => 'w-full h-3',
    'roundedClass' => 'rounded-xl',
])

<div>
    <div class="{{ $colorClass }} {{ $sizeClass }} {{ $roundedClass }}"></div>
</div>
