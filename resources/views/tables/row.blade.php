<tr @if(!empty($danger)) data-danger @elseif(!empty($warning)) data-warning @endif>
    {{ $slot }}
</tr>
