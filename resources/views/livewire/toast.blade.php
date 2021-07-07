<div class="grid fixed right-0 bottom-0 z-50 grid-rows-1 gap-3 p-5 max-w-4xl">
    @foreach ($toasts as $key => $toast)
        <div
            class="z-20 cursor-pointer"
            x-data="{ dismiss() { livewire.emit('dismissToast', '{{ $key }}' ) } }"
            x-init="() => setTimeout(() => dismiss(), 5000);"
            @click="dismiss()"
            wire:key="{{ $key }}"
        >
            <x-ark-toast :type="$toast['type']" :style="$toast['style']" wire-close="dismissToast('{{ $key }}')">
                <x-slot name='message'>
                    {!! $toast['message'] !!}
                </x-slot>
            </x-ark-toast>
        </div>
    @endforeach
</div>
