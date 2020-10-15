<div class="toast-{{ $type }} flex items-center {{ $class ?? '' }}">
    <div class="flex-1">{{ $message }}</div>

    @if (($wireClose ?? false) || ($alpineClose ?? false))
        <div
            @if ($wireClose ?? false) wire:click="{{ $wireClose }}" @endif
            @if ($alpineClose ?? false) @click="{{ $alpineClose }}" @endif
        >
            @svg('close', 'toast-close')
        </div>
    @endif
</div>
