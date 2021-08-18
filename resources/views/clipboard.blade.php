@props([
    'value',
    'class'          => 'h-10 w-12',
    'copyInput'      => false,
    'noStyling'      => false,
    'tooltipContent' => trans('tooltips.copied'),
])

<div
    x-data="clipboard()"
    x-init="initClipboard()"
>
    <button
        type="button"
        @class([
            $class,
            'clipboard',
            'button-icon' => ! $noStyling
        ])
        tooltip-content="{{ $tooltipContent }}"
        @if($copyInput)
            x-on:click="copyFromInput('{{ $value }}')"
        @else
            x-on:click="copy('{{ $value }}')"
        @endif
    >
        @svg('copy', 'h-4 w-4')
    </button>
</div>