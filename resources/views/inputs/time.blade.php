@php
$hours = range(0, 23);
$minutes = range(0, 59, 30);
$options = collect($hours)
    ->flatMap(fn($hour) => collect($minutes)->map(fn($minute) =>  str_pad($hour, 2, '0', STR_PAD_LEFT).':'.str_pad($minute, 2, '0', STR_PAD_LEFT)))
    ->mapWithKeys(fn($value) => [$value => $value])
    ->toArray();

@endphp

<x-ark-rich-select
    :options="$options"
    :initial-value="$time ?? '00:00'"
    dropdown-list-class="max-h-48"
    wire:model="{{ $name ?? $id }}"
/>
