@props([
    'error',
    'id',
    'shifted' => false,
])

<div
    wire:key="{{ md5($error) }}"
    class="px-4 input-icon @if($shifted) right-13 @else right-0 @endif"
    data-tippy-content="{{ $error }}"
    onclick="document.getElementById('{{ $id }}').focus()"
>
    @svg('report', 'w-5 h-5 text-theme-danger-500')

    @if($shifted)
        <div class="w-px h-5 transform translate-x-4 bg-theme-secondary-300">&nbsp;</div>
    @endif
</div>
