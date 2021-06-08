@props([
    'class' => '',
    'tooltip' => '',
    'type' => 'question',
    'large' => false
])

<div
    data-tippy-content="{{ $tooltip }}"
    class="inline-block cursor-pointer {{ $large ? 'p-1.5' : 'p-1' }} transition-default rounded-full bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-600 hover:text-white hover:bg-theme-primary-700 dark:hover:text-theme-secondary-800 dark:hover:bg-theme-secondary-600 {{ $class }}"
>
    @if($type === 'question')
        <x-ark-icon name="question-mark" size="{{ $large ? 'md' : 'xs' }}" />
    @else
        <x-ark-icon name="hint" size="{{ $large ? 'md' : 'xs' }}" />
    @endif
</div>
