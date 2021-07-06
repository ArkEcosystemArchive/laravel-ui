<div class="fixed bottom-0 right-0 z-50 grid grid-rows-1 gap-2 p-5">
    @foreach ($toasts as $key => $toast)
        <div
            class="z-20 cursor-pointer"
            x-data="{ dismiss() { livewire.emit('dismissToast', '{{ $key }}' ) } }"
            x-init="() => setTimeout(() => dismiss(), 5000);"
            @click="dismiss()"
            wire:key="{{ $key }}"
        >
            <x-ark-toast :type="$toast['type']" wire-close="dismissToast('{{ $key }}')">
                <x-slot name='message'>
                    <div class="px-3">{!! $toast['message'] !!}</div>
                </x-slot>
            </x-ark-toast>
        </div>
    @endforeach
</div>
