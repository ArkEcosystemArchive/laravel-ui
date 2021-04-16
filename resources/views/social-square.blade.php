@props([
    'icon',
    'url',
    'internal' => false,
    'hoverClass' => 'hover:bg-theme-danger-400 hover:text-white',
])

<a
    href="{{ $url }}"
    class="block w-16 border rounded-xl cursor-pointer h-14 border-theme-secondary-300 lg:w-14 lg:h-12 transition-default {{ $hoverClass }}"
    @unless($internal)
        target="_blank"
        rel="noopener noreferrer"
    @endunless
>
    <div class="flex justify-center items-center h-full">
        <x-ark-icon :name="$icon" size="w-6 h-6 lg:w-5 lg:h-5" />
    </div>
</a>
