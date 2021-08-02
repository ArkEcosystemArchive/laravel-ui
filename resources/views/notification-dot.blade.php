@props([
    'size'       => 1,
    'background' => 'p-1 bg-white group-hover:bg-theme-primary-100',
    'position'   => 'mr-2 -mt-4',
    'colour'     => 'bg-theme-danger-400 border-theme-danger-400',
])

<span class="absolute right-0 block rounded-full transition-default {{ $background }} {{ $position }}">
    <span class="block w-{{ $size }} h-{{ $size }} rounded-full border-3 {{ $colour }}"></span>
</span>
