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
    x-init="
        output = datetime.format(format);
        @if($tooltipFormat)
            tooltip = datetime.format('{{ $tooltipFormat }}');
            $nextTick(() => tippy($el, tooltipSettings));
        @endif
    "
    x-text="output"
    :data-tippy-content="tooltip"
></span>
