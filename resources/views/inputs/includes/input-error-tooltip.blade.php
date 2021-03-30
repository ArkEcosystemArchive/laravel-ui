@props([
    'error',
    'id',
])

<div
    wire:key="{{ md5($error) }}"
    class="right-0 px-3 input-icon"
    data-tippy-content="{{ $error }}"
    onclick="document.getElementById('{{ $id }}').focus()"
>
    <svg class="w-5 h-5 text-theme-danger-500" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
</div>
