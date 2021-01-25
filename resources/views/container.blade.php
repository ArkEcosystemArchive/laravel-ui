@props([
    'border' => false,
    'containerClass' => 'flex flex-col',
    'wrapperClass' => '',
])

<div class="@if ($border) border-t-20 border-theme-secondary-100 @endif {{ $wrapperClass }}">
    <div class="py-16 content-container {{ $containerClass }}" {{ $attributes->only('id') }}>
        {{ $slot }}
    </div>
</div>
