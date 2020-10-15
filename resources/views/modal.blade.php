<div class="fixed inset-0 z-40 overflow-y-auto opacity-75 bg-theme-secondary-900"></div>

<div
    class="fixed inset-0 z-50 flex overflow-y-auto"
    @if(!($closeButtonOnly ?? false) && ($wireClose ?? false)) wire:click.self="{{ $wireClose ?? '' }}" @endif
>
    <div
        class="m-auto {{ $class ?? '' }}"
        @if(isset($style)) style="{{ $style }}" @endif
        @if(!($closeButtonOnly ?? false) && ($alpineClose ?? false)) @click.away="{{ $alpineClose ?? '' }}" @endif
    >
        <div class="modal-content overflow-y-auto {{ $widthClass ?? 'max-w-2xl' }}" style="max-height: calc(100vh - 8rem)">
            <div class="p-6 sm:p-12">
                @if(($wireClose ?? false) || ($alpineClose ?? false))
                    <button
                        class="absolute top-0 right-0 w-10 h-10 mt-4 mr-4 rounded text-theme-secondary-700 bg-theme-secondary-100 transition-default hover:shadow-lg hover:bg-theme-secondary-300"
                        @if($wireClose ?? false) wire:click="{{ $wireClose }}" @endif
                        @if($alpineClose ?? false) @click="{{ $alpineClose }}" @endif
                    >
                        @svg('close', 'w-4 h-4 m-auto')
                    </button>
                @endif

                @if ($title ?? false)
                    <h1 class="{{ $titleClass ?? 'inline-block pb-2 font-bold' }}">
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
