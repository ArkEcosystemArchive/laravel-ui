@props([
    'xData' => '{}',
    'onSelected' => null,
    'defaultSelected' => '',
    'noData' => false,
    'panelWrapperClass' => 'mt-6 w-full',
    'tablistClass' => '',
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
    <ul role="tablist" class="tabs {{ $tablistClass }}">
        {{ $tabs }}
    </ul>

    <div class="{{ $panelWrapperClass }}">
        {{ $slot }}
    </div>
</div>
