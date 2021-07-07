@props([
    'type' => 'info',
    'message' => '',
    'wireClose' => false,
    'alpineClose' => false,
])

@php
    $colorClass = Arr::get([
        'warning' => 'bg-theme-warning-50',
        'error' => 'bg-theme-danger-50',
        'danger' => 'bg-theme-danger-50',
        'success' => 'bg-theme-success-50',
        'info' => 'bg-theme-primary-50',
        'hint' => 'bg-theme-hint-50',
    ], $type, 'bg-theme-primary-50');

    $iconClass = Arr::get([
        'warning' => 'bg-theme-warning-600',
        'error' => 'bg-theme-danger-400',
        'danger' => 'bg-theme-danger-400',
        'success' => 'bg-theme-success-600',
        'info' => 'bg-theme-primary-600',
        'hint' => 'bg-theme-hint-500',
    ], $type, 'bg-theme-primary-600');

    $icon = Arr::get([
        'warning' => 'toasts.warning',
        'error' => 'toasts.danger',
        'danger' => 'toasts.danger',
        'success' => 'toasts.success',
        'info' => 'toasts.info',
        'hint' => 'toasts.hint',
    ], $type, 'info');

    $closeButtonClass = Arr::get([
        'warning' => 'bg-theme-warning-100 hover:bg-theme-warning-200',
        'error' => 'bg-theme-danger-100 hover:bg-theme-danger-200',
        'danger' => 'bg-theme-danger-100 hover:bg-theme-danger-200',
        'success' => 'bg-theme-success-100 hover:bg-theme-success-200',
        'info' => 'bg-theme-primary-100 hover:bg-theme-primary-200',
        'hint' => 'bg-theme-hint-100 hover:bg-theme-hint-200',
    ], $type, 'bg-theme-primary-100 hover:bg-theme-primary-200');
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:space-x-4 items-center p-4 text-sm select-none text-theme-secondary-900 rounded-xl relative ' . $colorClass]) }}>
    <span class="flex items-center justify-center rounded text-white w-11 h-11 flex-shrink-0 {{ $iconClass }}">
        <x-ark-icon :name="$icon" />
    </span>

    <div class="mt-4 text-center sm:pr-6 sm:mt-0 sm:text-left">{{ $message }}</div>

    @if ($wireClose || $alpineClose)
        <button
            @if ($wireClose) wire:click="{{ $wireClose }}" @endif
            @if ($alpineClose) @click="{{ $alpineClose }}" @endif
            type="button"
            class="absolute top-0 right-0 m-4 sm:m-0 sm:top-auto sm:right-auto sm:relative flex items-center justify-center w-11 h-11 rounded flex-shrink-0 {{ $closeButtonClass }}"
        >
            <x-ark-icon name="close" />
        </button>
    @endif
</div>
