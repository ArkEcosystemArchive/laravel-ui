@props([
    'datetime',
    'format',
    'placeholder' => null,
    'tooltipFormat' => null,
])

<span
    x-data="{
        datetime: dayjs({{ $datetime->timestamp }} * 1000),
        format: '{{ $format }}',
        output: '{{ $placeholder }}',
        tooltip: null,
    }"
    aax-init="function (bla) {"
    x-init="
        output = datetime.format(format);
        @if($tooltipFormat)
            tooltip = datetime.format('{{ $tooltipFormat }}');
        @endif
    "
    x-text="output"
    :data-tippy-content="tooltip"
></span>
