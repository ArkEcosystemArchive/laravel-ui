<div class="flex justify-between">
    <div class="{{ $titleClass ?? 'w-32' }}">{{ $title }}</div>

    <div class="flex items-center space-x-3">
        <div>{{ $slot }}</div>

        @if ($icon ?? false)
            <x-ark-icon :name="$icon" class="{{ $iconClass ?? '' }}" />
        @elseif ($iconRaw ?? false)
            {{ $iconRaw }}
        @endif
    </div>
</div>
