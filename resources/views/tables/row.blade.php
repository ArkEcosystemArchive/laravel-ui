@props([
    'danger' => false,
    'warning' => false,
    'tooltip' => false,
])
<tr {{ $attributes }}
    @if($danger) data-danger @elseif($warning) data-warning @endif
    @if($tooltip) data-tippy-content="{{ $tooltip }}" @endif
>
    {{ $slot }}
</tr>
