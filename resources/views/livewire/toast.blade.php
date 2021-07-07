<div class="fixed bottom-0 right-0 z-50 grid max-w-4xl grid-rows-1 gap-3 p-5">
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
