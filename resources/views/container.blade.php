@props([
    'containerClass' => 'flex flex-col',
])

<div {{ $attributes->except('containerClass') }}>
    <div class="py-8 w-full content-container {{ $containerClass }}">
        {{ $slot }}
    </div>
</div>
