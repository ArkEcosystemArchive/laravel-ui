@props([
    'type' => 'info',
    'message' => '',
    'wireClose' => false,
    'alpineClose' => false,
])

@php
    $icon = Arr::get([
        'warning' => 'toasts.warning',
        'error' => 'toasts.danger',
        'danger' => 'toasts.danger',
        'success' => 'toasts.success',
        'info' => 'toasts.info',
        'hint' => 'toasts.hint',
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
