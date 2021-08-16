@props([
    'class' => 'mr-2 right-0 -mt-4 p-1 bg-white group-hover:bg-theme-primary-100 transition-default',
    'color' => 'bg-theme-danger-400 border-theme-danger-400',
])

<span class="notification-dot {{ $class }}">
    <span class="block w-1 h-1 rounded-full border-3 {{ $color }}"></span>
</span>
