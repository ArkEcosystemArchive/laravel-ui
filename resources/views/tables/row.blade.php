@props([
    'danger' => false,
    'warning' => false,
])
<tr @if($danger) data-danger @elseif($warning) data-warning @endif>
    {{ $slot }}
</tr>
