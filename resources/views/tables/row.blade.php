@props([
    'danger'  => false,
    'tooltip' => false,
    'warning' => false,
])
<tr {{ $attributes }}
    @if($danger) data-danger @elseif($warning) data-warning @endif
    @if($tooltip) data-tippy-content="{{ $tooltip }}" @endif
>
    {{ $slot }}
</tr>
