@props([
    'class'   => '',
    'large'   => false,
    'tooltip' => '',
    'type'    => 'question',
])

<div
    @class([
        $class,
        'inline-block cursor-pointer transition-default rounded-full bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-600 hover:text-white hover:bg-theme-primary-700 dark:hover:text-theme-secondary-800 dark:hover:bg-theme-secondary-600 outline-none focus-visible:ring-2 focus-visible:ring-theme-primary-500'
        'p-1.5'     => $large,
        'p-1'       => ! $large,
    ])
    data-tippy-content="{{ $tooltip }}"
    aria-label="{{ $tooltip }}"
    tabindex="0"
>
    @if($type === 'question')
        <x-ark-icon name="question-mark" size="{{ $large ? 'sm' : 'xs' }}" />
    @else
        <x-ark-icon name="hint" size="{{ $large ? 'sm' : 'xs' }}" />
    @endif
</div>
