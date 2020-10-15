<a
    href="{{ $url }}"
    class="block w-16 border rounded-lg cursor-pointer border-theme-secondary-300 h-14 lg:w-14 lg:h-12 transition-default hover:bg-theme-danger-400 hover:text-white"
    @unless($internal ?? false)
        target="_blank"
        rel="noopener noreferrer"
    @endunless
>
    <div class="flex items-center justify-center h-full">@svg($icon, 'w-6 h-6 lg:w-5 lg:h-5')</div>
</a>
