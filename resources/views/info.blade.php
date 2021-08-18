@props([
    'class'   => '',
    'large'   => false
    'tooltip' => '',
    'type'    => 'question',
])

<div
    data-tippy-content="{{ $tooltip }}"
    @class([
        $class,
        'inline-block cursor-pointer transition-default rounded-full bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-600 hover:text-white hover:bg-theme-primary-700 dark:hover:text-theme-secondary-800 dark:hover:bg-theme-secondary-600'
        'p-1.5'     => $large,
        'p-1'       => ! $large,
    ])
>
    @if($type === 'question')
        <x-ark-icon name="question-mark" size="{{ $large ? 'sm' : 'xs' }}" />
    @else
        <x-ark-icon name="hint" size="{{ $large ? 'sm' : 'xs' }}" />
    @endif
</div>
