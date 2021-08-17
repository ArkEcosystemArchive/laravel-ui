@props([
    'xData' => '{}',
    'onSelected' => null,
    'defaultSelected' => '',
    'noData' => false,
])

<div
    {{ $attributes->merge(['class' => 'tabs-wrapper']) }}
    @unless($noData)
        x-data="Tabs(
            '{{ $defaultSelected }}',
            {{ $xData }}
            @if($onSelected) , {{ $onSelected }} @endif
        )"
    @endunless
>
    <ul role="tablist" class="tabs">
        {{ $slot }}
    </ul>

    <div class="{{ $panelWrapperClass }}">
        {{ $panels }}
    </div>
</div>
