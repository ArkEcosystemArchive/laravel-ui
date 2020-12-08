@props([
    'init' => false,
    'xData' => '{}',
    'class' => '',
    'widthClass' => 'max-w-2xl',
    'title' => null,
    'titleClass' => 'inline-block pb-2 font-bold dark:text-theme-secondary-200',
    'buttons' => null,
    'buttonsStyle' => 'modal-buttons',
    'closeButtonOnly' => false,
    'escToClose' => true,
    'name' => '',
])

<div
    x-ref="modal"
    x-show="shown"
    data-modal
    x-cloak
    @if($init)
    x-data="Modal.alpine({{ $xData }}, '{{ $name }}')"
    x-init="init"
    @endif
    @if(!$closeButtonOnly && $escToClose)
    @keydown.escape="hide"
    tabindex="0"
    @endif
>
    <div class="fixed inset-0 z-40 opacity-75 bg-theme-secondary-900 dark:bg-theme-secondary-800 dark:opacity-50"></div>

    <div class="fixed inset-0 z-50 flex px-5 py-10 overflow-y-auto">
        <div
            class="m-auto w-full {{ $class }}"
            @if(!$closeButtonOnly)
            @click.away="hide"
            @endif
        >
            <div class="modal-content dropdown-scrolling {{ $widthClass }}">
                <div class="p-6 sm:p-12">
                    @if(!$closeButtonOnly)
                    <button
                        class="modal-close"
                        @click="hide"
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

                    @if($buttons)
                        <div class="mt-8 text-right {{ $buttonsStyle }}">
                            {{ $buttons }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
