<form id="newsletter" class="flex-1" wire:submit.prevent="subscribe">
    <x-ark-input-with-icon
        type="email"
        id="subscribe_email"
        name="subscribe_email"
        placeholder="Enter your email"
        model="email"
        keydown-enter="subscribe"
        autocomplete="email"
        input-class="w-full"
        container-class="p-1 overflow-hidden bg-white rounded"
        :errors="$errors"
        :hide-label="true"
    >
        <button type="submit" class="block px-2 bg-white text-theme-secondary-500">
            <x-ark-icon name="paper-plane" />
        </button>
    </x-ark-input-with-icon>

    @error('email')
        <div class="mt-1 text-sm font-semibold">{{ $message }}</div>
    @enderror

    @error('list')
        <div class="mt-1 text-sm font-semibold">{{ $message }}</div>
    @enderror

    @if($status)
        @if($subscribed)
            <div class="mt-1 text-sm font-semibold text-theme-success-600">{{ $status }}</div>
        @else
            <div class="mt-1 text-sm font-semibold">{{ $status }}</div>
        @endif
    @endif
</form>
