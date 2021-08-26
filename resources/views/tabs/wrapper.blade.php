@props([
    'xData' => '{}',
    'onSelected' => null,
    'defaultSelected' => '',
    'noData' => false,
    'panelWrapperClass' => 'mt-6 w-full',
    'tabsWrapperClass' => '',
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
    <ul role="tablist" class="tabs {{ $tabsWrapperClass }}">
        {{ $tabs }}
    </ul>

    <div class="{{ $panelWrapperClass }}">
        {{ $slot }}
    </div>
</div>
