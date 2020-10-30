<div
    x-data="clipboard()"
    x-init="initClipboard()"
>
    <button
        type="button"
        class="clipboard @unless($noStyling ?? false) button-icon @endif {{ $class ?? 'h-10 w-12' }}"
        tooltip-content="{{ ($tooltipContent ?? '') ? $tooltipContent : trans('tooltips.copied') }}"
        @if($copyInput ?? false)
            x-on:click="copyFromInput('{{ $value }}')"
        @else
            x-on:click="copy('{{ $value }}')"
        @endif
    >
        @svg('copy', 'h-4 w-4')
    </button>
</div>
