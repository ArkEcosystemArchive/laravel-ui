@props([
    'xData' => '{}',
    'onSelected' => null,
    'defaultSelected' => '',
    'noData' => false,
    'panelWrapperClass' => '',
])

<div {{ $attributes->merge(['class' => 'tabs-wrapper']) }}
    @unless($noData)
        x-data="Tabs(
            '{{ $defaultSelected }}',
            {{ $xData }}
            @if($onSelected) , {{ $onSelected }} @endif
        )"
    @endunless
>
    <ul role="tablist" class="tabs">
        {{ $tabs }}
    </ul>

    <div class="{{ $panelWrapperClass }}">
        {{ $slot }}
    </div>
</div>
