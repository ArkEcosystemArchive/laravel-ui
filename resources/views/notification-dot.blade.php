@props([
    'class' => 'mr-2 -mt-4 p-1 bg-white group-hover:bg-theme-primary-100',
    'color' => 'bg-theme-danger-400 border-theme-danger-400',
])

<span class="absolute right-0 block rounded-full transition-default {{ $class }}">
    <span class="block w-1 h-1 rounded-full border-3 {{ $color }}"></span>
</span>
