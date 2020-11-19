<div class="flex justify-between">
    <div>{{ $title }}</div>

    <div class="flex space-x-3">
        <div>{{ $slot }}</div>

        @if ($icon ?? false)
            <x-ark-icon :name="$icon" class="{{ $iconClass ?? '' }}" />
        @elseif ($iconRaw ?? false)
            {{ $iconRaw }}
        @endif
    </div>
</div>
