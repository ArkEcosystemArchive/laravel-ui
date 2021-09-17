@props([
    'xData' => '{}',
    'onSelected' => null,
    'defaultSelected' => '',
    'noData' => false,
    'panelWrapperClass' => 'mt-6 w-full',
    'tablistClass' => 'w-full',
    'tabsTrigger' => false,
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
    @if($tabsTrigger)
        {{ $tabsTrigger }}
    @else
        <ul role="tablist" class="tabs {{ $tablistClass }}">
            {{ $tabs }}
        </ul>
    @endif

    <div class="{{ $panelWrapperClass }}">
        {{ $slot }}
    </div>
</div>
