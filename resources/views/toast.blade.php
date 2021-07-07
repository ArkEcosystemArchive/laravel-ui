@props([
    'type' => 'info',
    'style' => 'regular',
    'message' => '',
    'wireClose' => false,
    'alpineClose' => false,
])

@php
    if ($style === 'simple') {
        $colorClass = Arr::get([
            'info' => 'text-theme-secondary-900 bg-theme-primary-100',
            'warning' => 'text-theme-secondary-900 bg-theme-warning-100',
            'error' => 'text-theme-secondary-900 bg-theme-danger-100',
            'danger' => 'text-theme-secondary-900 bg-theme-danger-100',
            'success' => 'text-theme-secondary-900 bg-theme-success-100',
            'hint' => 'text-theme-secondary-900 bg-theme-hint-100',
        ], $type);
    } else {
        $colorClass = Arr::get([
            'info' => 'text-theme-secondary-900 bg-theme-primary-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
            'warning' => 'text-theme-secondary-900 bg-theme-warning-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
            'error' => 'text-theme-secondary-900 bg-theme-danger-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
            'danger' => 'text-theme-secondary-900 bg-theme-danger-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
            'success' => 'text-theme-secondary-900 bg-theme-success-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
            'hint' => 'text-theme-secondary-900 bg-theme-hint-50 dark:text-theme-secondary-500 dark:bg-theme-secondary-800',
        ], $type);
    }

    $iconClass = Arr::get([
        'warning' => 'bg-theme-warning-600',
        'error' => 'bg-theme-danger-400',
        'danger' => 'bg-theme-danger-400',
        'success' => 'bg-theme-success-600',
        'info' => 'bg-theme-primary-600',
        'hint' => 'bg-theme-hint-500',
    ], $type);

    $icon = Arr::get([
        'warning' => 'toasts.warning',
        'error' => 'toasts.danger',
        'danger' => 'toasts.danger',
        'success' => 'toasts.success',
        'info' => 'toasts.info',
        'hint' => 'toasts.hint',
    ], $type);

    $closeButtonClass = Arr::get([
        'info' => 'bg-theme-primary-100 text-theme-secondary-900 hover:bg-theme-primary-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
        'warning' => 'bg-theme-warning-100 text-theme-secondary-900 hover:bg-theme-warning-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
        'error' => 'bg-theme-danger-100 text-theme-secondary-900 hover:bg-theme-danger-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
        'danger' => 'bg-theme-danger-100 text-theme-secondary-900 hover:bg-theme-danger-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
        'success' => 'bg-theme-success-100 text-theme-secondary-900 hover:bg-theme-success-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
        'hint' => 'bg-theme-hint-100 text-theme-secondary-900 hover:bg-theme-hint-200 dark:bg-theme-secondary-900 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-500 dark:hover:text-theme-secondary-400',
    ], $type);
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:space-x-4 items-center p-4 text-sm select-none rounded-xl relative ' . $colorClass]) }}>
    @unless ($style === 'simple')
        <span class="flex items-center justify-center rounded text-white w-11 h-11 flex-shrink-0 {{ $iconClass }}">
            <x-ark-icon :name="$icon"/>
        </span>
    @endunless

    <div class="@unless ($style === 'simple') mt-4 @endif text-center sm:pr-6 sm:mt-0 sm:text-left">{{ $message }}</div>

    @if ($style === 'regular')
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
    @endif
</div>
