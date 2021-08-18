@props([
    'alpineClose' => false,
    'message'     => '',
    'type'        => 'info',
    'wireClose'   => false,
])

@php
    $icon = Arr::get([
        'warning' => 'circle.exclamation-mark',
        'error' => 'circle.cross',
        'danger' => 'circle.cross',
        'success' => 'circle.checkmark',
        'info' => 'circle.info',
        'hint' => 'circle.question-mark',
    ], $type);

    $toastClass = Arr::get([
        'warning' => 'toast-warning',
        'error' => 'toast-danger',
        'danger' => 'toast-danger',
        'success' => 'toast-success',
        'info' => 'toast-info',
        'hint' => 'toast-hint',
    ], $type);
@endphp

<div {{ $attributes->merge(['class' => 'toast ' . $toastClass]) }}>
    <span class="toast-icon">
        <x-ark-icon :name="$icon"/>
    </span>

    <div class="toast-body">{{ $message }}</div>

    <button
        @if ($wireClose) wire:click="{{ $wireClose }}" @endif
        @if ($alpineClose) @click="{{ $alpineClose }}" @endif
        type="button"
        class="toast-button"
    >
        <x-ark-icon name="close" />
    </button>
</div>
