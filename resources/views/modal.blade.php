@props([
    'xData' => '{}',
    'class' => '',
    'style' => null,
    'widthClass' => 'max-w-2xl',
    'title' => null,
    'titleClass' => 'inline-block pb-2 font-bold dark:text-theme-secondary-200',
    'buttons' => null,
    'buttonsStyle' => 'modal-buttons',
    'closeButtonOnly' => false,
    'wireClose' => false,
    'escToClose' => true,
])

<div class="fixed inset-0 z-50 opacity-75 bg-theme-secondary-900 dark:bg-theme-secondary-800 dark:opacity-50"></div>

<div
    x-ref="modal"
    data-modal
    x-data="Modal.livewire({{ $xData }})"
    x-init="init"
    @if(!$closeButtonOnly && $wireClose)
    wire:click.self="{{ $wireClose }}"
    @endif
    class="flex overflow-y-auto fixed inset-0 z-50 py-10 px-5 "
    @if(!$closeButtonOnly && $escToClose)
    wire:keydown.escape="{{ $wireClose }}"
    tabindex="0"
    @endif
>
    <div
        class="m-auto w-full {{ $class }}"
        @if($style) style="{{ $style }}" @endif
    >
        <div class="modal-content dropdown-scrolling {{ $widthClass }}">
            <div class="p-6 sm:p-12">
                @if($wireClose)
                    <button
                        class="modal-close"
                        @if($wireClose ?? false) wire:click="{{ $wireClose }}" @endif
                    >
                        @svg('close', 'w-4 h-4 m-auto')
                    </button>
                @endif

                @if ($title)
                    <h1 class="{{ $titleClass }}">
                        {{ $title }}
                    </h1>
                @endif

                {{ $description }}

                @if($buttons ?? false)
                    <div class="mt-8 text-right {{ $buttonsStyle }}">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
