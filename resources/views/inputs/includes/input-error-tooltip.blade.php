@props([
    'error',
    'id',
    'shifted' => false,
])

<button
    type="button"
    wire:key="{{ md5($id.$error) }}"
    @class([
        'px-4 input-icon focus-visible:rounded',
        'right-13' => $shifted,
        'right-0'  => ! $shifted,
    ])
    data-tippy-content="{{ $error }}"
    onclick="document.getElementById('{{ $id }}').focus()"
>
    @svg('report', 'w-5 h-5 text-theme-danger-500')

    @if($shifted)
        <div class="w-px h-5 transform translate-x-4 bg-theme-secondary-300">&nbsp;</div>
    @endif
</button>
