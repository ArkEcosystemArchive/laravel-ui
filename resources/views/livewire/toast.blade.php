<div class="grid fixed right-0 bottom-0 z-20 grid-rows-1 gap-2 mr-1 mb-5" style="min-width: 250px; max-width: 350px">
    @foreach ($toasts as $key => $toast)
        <div
            class="z-20 cursor-pointer"
            x-data="{ dismiss() { livewire.emit('dismissToast', '{{ $key }}' ) } }"
            x-init="() => setTimeout(() => dismiss(), 5000);"
            @click="dismiss()"
        >
            <x-ark-toast :type="$toast['type']" wire-close="dismissToast('{{ $key }}')">
                <x-slot name='message'>
                    <div class="px-3">{!! $toast['message'] !!}</div>
                </x-slot>
            </x-ark-toast>
        </div>
    @endforeach
</div>
