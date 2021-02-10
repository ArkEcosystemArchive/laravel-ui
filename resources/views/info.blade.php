@props([
    'tooltip' => '',
    'type' => 'question',
    'large' => false
])

@php
    $typeIcon = [
        'info' => 'info',
        'hint' => 'hint',
        'question' => 'question-mark',
        'warning' => 'question-mark',
    ][$type];

    $typeClasses = [
        'info' => [
            'bg-theme-primary-100', 'text-theme-primary-600',
            'dark:bg-theme-secondary-800', 'dark:text-theme-secondary-600',
            'hover:text-white', 'hover:bg-theme-primary-700',
            'dark:hover:text-theme-secondary-800', 'dark:hover:bg-theme-secondary-600',
        ],
        'hint' => [
            'bg-theme-primary-100', 'text-theme-primary-600',
            'dark:bg-theme-secondary-800', 'dark:text-theme-secondary-600',
            'hover:text-white', 'hover:bg-theme-primary-700',
            'dark:hover:text-theme-secondary-800', 'dark:hover:bg-theme-secondary-600',
        ],
        'question' => [
            'bg-theme-primary-100', 'text-theme-primary-600',
            'dark:bg-theme-secondary-800', 'dark:text-theme-secondary-600',
            'hover:text-white', 'hover:bg-theme-primary-700',
            'dark:hover:text-theme-secondary-800', 'dark:hover:bg-theme-secondary-600',
        ],
        'warning' => [
            'border-2', 'border-theme-warning-600', 'text-theme-warning-600',
            'dark:border-theme-warning-100', 'dark:text-theme-warning-100',
            'hover:border-theme-warning-600', 'hover:text-theme-warning-600',
            'dark:hover:border-theme-warning-100', 'dark:hover:text-theme-warning-100',
        ],
    ][$type];

    $classes = array_merge([
        'inline-block',
        'cursor-pointer',
        $large ? 'p-1.5' : 'p-1',
        'transition-default',
        'rounded-full',
], $typeClasses);
@endphp

<div data-tippy-content="{{ $tooltip }}" {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    <x-ark-icon :name="$typeIcon" size="{{ $large ? 'xs' : '2xs' }}" />
</div>
