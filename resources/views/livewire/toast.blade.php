<div class="flex fixed right-0 bottom-0 z-50 flex-col items-end p-5 space-y-3">
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
