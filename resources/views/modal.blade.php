<div class="fixed inset-0 z-40 opacity-75 bg-theme-secondary-900 dark:bg-theme-secondary-800 dark:opacity-50"></div>

<div
    x-ref="modal"
    @empty($alpineModal)
    x-data="Modal({{ $xData ?? '{}' }})"
    x-init="init"
    @endempty
    class="flex overflow-y-auto fixed inset-0 z-50 py-10 px-5 "
    @if(!($closeButtonOnly ?? false) && ($wireClose ?? false)) wire:click.self="{{ $wireClose ?? '' }}" @endif
    data-modal
>
    <div
        class="m-auto w-full {{ $class ?? '' }}"
        @if(isset($style)) style="{{ $style }}" @endif
        @if(!($closeButtonOnly ?? false) && ($alpineClose ?? false)) @click.away="{{ $alpineClose ?? '' }}" @endif
    >
        <div class="modal-content dropdown-scrolling {{ $widthClass ?? 'max-w-2xl' }}">
            <div class="p-6 sm:p-12">
                @if(($wireClose ?? false) || ($alpineClose ?? false))
                    <button
                        class="modal-close"
                        @if($wireClose ?? false) wire:click="{{ $wireClose }}" @endif
                        @if($alpineClose ?? false) @click="{{ $alpineClose }}" @endif
                    >
                        @svg('close', 'w-4 h-4 m-auto')
                    </button>
                @endif

                @if ($title ?? false)
                    <h1 class="{{ $titleClass ?? 'inline-block pb-2 font-bold dark:text-theme-secondary-200' }}">
                        {{ $title }}
                    </h1>
                @endif

                {{ $description }}

                @if($buttons ?? false)
                    <div class="mt-8 text-right {{ $buttonsStyle ?? 'modal-buttons' }}">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
