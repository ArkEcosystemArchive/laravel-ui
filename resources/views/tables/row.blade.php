@props([
    'danger' => false,
    'warning' => false,
])
<tr {{ $attributes }} @if($danger) data-danger @elseif($warning) data-warning @endif>
    {{ $slot }}
</tr>
