@props([
    'xData'           => '{}',
    'buttons'         => null,
    'buttonsStyle'    => 'modal-buttons',
    'class'           => '',
    'closeButtonOnly' => false,
    'escToClose'      => true,
    'fixedPosition'   => false,
    'style'           => null,
    'title'           => null,
    'titleClass'      => 'inline-block pb-2 font-bold dark:text-theme-secondary-200',
    'widthClass'      => 'max-w-2xl',
    'wireClose'       => false,

])

<div class="fixed inset-0 z-50 opacity-75 dark:opacity-50 bg-theme-secondary-900 dark:bg-theme-secondary-800"></div>

<div
    wire:ignore.self
    x-ref="modal"
    data-modal
    x-data="Modal.livewire({{ $xData }})"
    x-init="init"
    @if(!$closeButtonOnly && $wireClose)
        wire:click.self="{{ $wireClose }}"
    @endif
    class="flex overflow-y-auto fixed inset-0 z-50 md:py-10 md:px-8"
    @if(!$closeButtonOnly && $escToClose)
        wire:keydown.escape="{{ $wireClose }}"
        tabindex="0"
    @endif
>
    <div
        @class([
            $class,
            $widthClass,
            'modal-content-wrapper w-full',
            'md:mx-auto' => $fixedPosition,
            'md:m-auto'  => ! $fixedPosition,
        ])
        @if($style) style="{{ $style }}" @endif
    >
        <div class="modal-content custom-scroll {{ $widthClass }}">
            <div class="p-8 sm:p-10">
                @if($wireClose)
                    <button
                        type="button"
                        class="modal-close"
                        @if($wireClose) wire:click="{{ $wireClose }}" @endif
                    >
                        <x-ark-icon name="close" size="md" class="m-auto" />
                    </button>
                @endif

                @if ($title)
                    <h1 class="{{ $titleClass }}">
                        {{ $title }}
                    </h1>
                @endif

                {{ $description }}

                @if($buttons)
                    <div class="mt-8 text-right {{ $buttonsStyle }}">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
